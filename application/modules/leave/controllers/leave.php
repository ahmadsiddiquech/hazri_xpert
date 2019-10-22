<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Leave extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->manage();
    }

    function manage() {
        $query = $this->_get('leave.id desc')->result_array();
        if (isset($query) && !empty($query)) {
            foreach ($query as $key => $value) {
                $data1['id'] = $value['id'];
                $data1['std_id'] = $value['std_id'];
                $data1['std_name'] = $value['std_name'];
                $data1['std_roll_no'] = $value['std_roll_no'];
                $data1['leave_type'] = $value['leave_type'];
                $data1['leave_duration'] = $value['leave_duration'];
                $data1['parent_id'] = $value['parent_id'];
                $data1['section_id'] = $value['section_id'];
                $data1['parent_name'] = $value['parent_name'];
                $data1['section_name'] = $value['section_name'];
                $data1['reason'] = $value['reason'];
                $data1['date'] = $value['date'];
                $data1['leave_start'] = $value['leave_start'];
                $data1['status'] = $value['status'];
                $data2[] = $data1;
            }
        }
        $data['news'] = $data2;
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }


    function _get_data_from_db($update_id) {
        $where['leave.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['std_id'] = $row->std_id;
            $data['std_name'] = $row->std_name;
            $data['std_roll_no'] = $row->std_roll_no;
            $data['leave_type'] = $row->leave_type;
            $data['leave_duration'] = $row->leave_duration;
            $data['teacher_id'] = $row->teacher_id;
            $data['parent_id'] = $row->parent_id;
            $data['section_id'] = $row->section_id;
            $data['parent_name'] = $row->parent_name;
            $data['section_name'] = $row->section_name;
            $data['reason'] = $row->reason;
            $data['date'] = $row->date;
            $data['leave_start'] = $row->leave_start;
            $data['status'] = $row->status;
        }
        if(isset($data))
            return $data;
    }

    function change_status () {
        $std_id = $this->input->post('std_id');
        $std_name = $this->input->post('std_name');
        $roll_no = $this->input->post('roll_no');
        $leave_id = $this->input->post('leave_id');
        $status = $this->input->post('status');
        $this->load->model('mdl_leave');
        $check = $this->mdl_leave->_change_status($std_id,$roll_no,$leave_id,$status);

        $notif_data = $this->_get_data_from_db($leave_id);
        $data2['notif_title'] = $notif_data['leave_type'];
        if($status == '1'){
            $data2['notif_description'] = 'Admin accepted leave for '.$std_name;
        }
        elseif ($status == '2') {
            $data2['notif_description'] = 'Admin rejected leave for '.$std_name;
        }
        elseif ($status == '0') {
            $data2['notif_description'] = 'Leave for '.$std_name . ' is Pending';
        }
        $data2['notif_type'] = 'leave';
        $data2['notif_sub_type'] = 'leave_update';
        $data2['type_id'] = $leave_id;
        $data2['section_id'] = $notif_data['section_id'];
        date_default_timezone_set("Asia/Karachi");
        $data2['notif_date'] = date('Y-m-d H:i:s');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data2['org_id'] = $org_id;
        $data2['std_id'] = $std_id;
        $data2['std_name'] = $std_name;
        $data2['std_roll_no'] = $roll_no;

        $whereStd['id'] = $std_id;
        $parents = $this->_get_parent_id_for_notification($whereStd,$data2['org_id'])->result_array();
        if (isset($parents) && !empty($parents)) {
            foreach ($parents as $key => $value) {
                $data2['notif_for'] = 'Parent';
                $data2['user_id'] = $value['parent_id'];
                $nid = $this->_notif_insert_data($data2);
                $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
            }
        }

        if ($notif_data['leave_duration'] == 'lecture') {
            $data2['notif_for'] = 'Teacher';
            $data2['user_id'] = $notif_data['teacher_id'];
            $nid = $this->_notif_insert_data($data2);
            $token = $this->_get_teacher_token($notif_data['teacher_id'],$data2['org_id'])->result_array();
            Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
        }
        else{
            $whereId['section_id'] = $notif_data['section_id'];
            $teachers = $this->_get_teacher_id_for_notification($whereId,$data2['org_id'])->result_array();
            if (isset($teachers) && !empty($teachers)) {
                foreach ($teachers as $key => $value) {
                    $data2['notif_for'] = 'Teacher';
                    $data2['user_id'] = $value['teacher_id'];
                    $nid = $this->_notif_insert_data($data2);
                    $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                    Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
                }
            }
        }

        if($check == 1){
            echo "true";
        }
        else{
            echo "false";
        }
    }


    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_leave');
        return $this->mdl_leave->_getItemById($id);
    }
    function _get($order_by) {
        $this->load->model('mdl_leave');
        $query = $this->mdl_leave->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_leave');
        return $this->mdl_leave->_get_by_arr_id($arr_col);
    }

    function _change_status($std_id,$roll_no,$leave_id,$status){
        $this->load->model('mdl_leave');
        return $this->mdl_leave->_change_status($std_id,$roll_no,$leave_id,$status);
    }

    function _get_parent_id_for_notification($where,$org_id){
        $this->load->model('mdl_leave');
        return $this->mdl_leave->_get_parent_id_for_notification($where,$org_id);
    }

    function _get_teacher_id_for_notification($where,$org_id){
        $this->load->model('mdl_leave');
        return $this->mdl_leave->_get_teacher_id_for_notification($where,$org_id);
    }

    function _notif_insert_data($data2){
        $this->load->model('mdl_leave');
        return $this->mdl_leave->_notif_insert_data($data2);
    }

    function _get_teacher_token($teacher_id,$org_id){
    $this->load->model('mdl_leave');
    return $this->mdl_leave->_get_teacher_token($teacher_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
    $this->load->model('mdl_leave');
    return $this->mdl_leave->_get_parent_token($parent_id,$org_id);
    }
}