<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Attendance extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->create();
    }


    function create() {
        $update_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        
        $data['update_id'] = $update_id;
        $arr_program = Modules::run('program/_get_by_arr_id_programs',$org_id)->result_array();
        $program = array();

        foreach($arr_program as $row){
            $program[$row['id']] = $row['name'];
        }
        $data['program_title'] = $program;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function _get_data_from_db($class_id,$section_id,$data) {
        $query = $this->_get_by_arr_id($class_id,$section_id,$data);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['section_id'] = $row->section_id;
            $data['section_name'] = $row->section_name;
            $data['class_id'] = $row->class_id;
            $data['class_name'] = $row->class_name;
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['teacher_id'] = $row->teacher_id;
            $data['teacher_name'] = $row->teacher_name;
            $data['s_type'] = $row->s_type;
            $data['org_id'] = $row->org_id;
            $data['status'] = $row->status;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['date'] = $this->input->post('date');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['program_id'] = $this->input->post('program_id');
        $data['class_id'] = $this->input->post('class_id');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;

    }

    function submit() {
        $subject_id = $this->input->post('subject_id');
        if(isset($subject_id) && !empty($subject_id)){
            $stdData = explode(",",$subject_id);
            $subject_id = $stdData[0];
        }

        $section_id = $this->input->post('section_id');
        $class_id = $this->input->post('class_id');

        $data['attendance'] = $this->_get_attendance_record($subject_id,$section_id,$class_id);
        $data['view_file'] = 'view';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function change_status () {
        $std_id = $this->input->post('std_id');
        $roll_no = $this->input->post('roll_no');
        $attendance_id = $this->input->post('attendance_id');
        $attend_status = $this->input->post('attend_status');
        $this->load->model('mdl_attendance');
        $check = $this->mdl_attendance->_change_status($std_id,$roll_no,$attendance_id,$attend_status);
        if($check == 1){
            echo "true";
        }
        else{
            echo "false";
        }
    }

	
    function _getItemById($id) {
        $this->load->model('mdl_attendance');
        return $this->mdl_attendance->_getItemById($id);
    }

    function _set_publish($arr_col) {
        $this->load->model('mdl_attendance');
        $this->mdl_attendance->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_attendance');
        $this->mdl_attendance->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_attendance');
        $query = $this->mdl_attendance->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($class_id,$section_id,$data) {
        $this->load->model('mdl_attendance');
        return $this->mdl_attendance->_get_by_arr_id($class_id,$section_id,$data);
    }
    
    function _insert($data) {
        $this->load->model('mdl_attendance');
        return $this->mdl_attendance->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_attendance');
        $this->mdl_attendance->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_attendance');
        $this->mdl_attendance->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_attendance');
        $this->mdl_attendance->_delete($arr_col, $org_id);
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_attendance');
        $query = $this->mdl_attendance->_custom_query($mysql_query);
        return $query;
    }
    function _get_by_arr_id_attendance($section_id) {
        $this->load->model('mdl_attendance');
        return $this->mdl_attendance->_get_by_arr_id_attendance($section_id);
    }
    function _get_attendance($section_id) {
        $this->load->model('mdl_attendance');
        return $this->mdl_attendance->_get_attendance($section_id);
    }

    function _get_attendance_class($class_id){
        $this->load->model('mdl_attendance');
        return $this->mdl_attendance->_get_attendance_class($class_id);
    }
    function _get_attendance_teacher($attendance_id,$org_id) {
        $this->load->model('mdl_attendance');
        return $this->mdl_attendance->_get_attendance_teacher($attendance_id,$org_id);
    }

    function _get_attendance_record($subject_id,$section_id,$class_id){
        $this->load->model('mdl_attendance');
        return $this->mdl_attendance->_get_attendance_record($subject_id,$section_id,$class_id);
    }

}