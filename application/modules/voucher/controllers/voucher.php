<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Voucher extends MX_Controller
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
        $data['news'] = $this->_get('voucher_record.id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function print_voucher(){
        $std_voucher_id = $this->uri->segment(4);
        $where['voucher_data.id'] = $std_voucher_id;
        if (is_numeric($std_voucher_id) && $std_voucher_id != 0) {
            $data['news'] = $this->_get_data_from_db_print_voucher($where)->result_array();
        }
        $this->load->view('print',$data);
    }

    function print_voucher_all(){
        $voucher_id = $this->uri->segment(4);
        $where['voucher_data.voucher_id'] = $voucher_id;
        if (is_numeric($voucher_id) && $voucher_id != 0) {
            $data['news'] = $this->_get_data_from_db_print_voucher($where)->result_array();
        }
        $this->load->view('print',$data);
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
       
        $data['programs'] = $arr_program;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function std_voucher_edit() {
        $voucher_id = $this->uri->segment(4);
        $class = $this->uri->segment(5);
        $std_voucher_id = $this->uri->segment(6);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if (is_numeric($std_voucher_id) && $std_voucher_id != 0) {
            $data['news'] = $this->get_data_from_db_std_voucher($std_voucher_id);
        } else {
            $data['news'] = $this->_get_data_from_post_std_voucher();
        }
        $data['voucher_id'] = $voucher_id;
        $data['class'] = $class;
        $data['update_id'] = $std_voucher_id;
        $data['view_file'] = 'std_voucherform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function std_voucher() {
        $voucher_id = $this->uri->segment(4);
        if (is_numeric($voucher_id) && $voucher_id != 0) {
            $data['news'] = $this->_get_std_vouchers($voucher_id);
        }
        $data['view_file'] = 'std_voucher';
        $this->load->module('template');
        $this->template->admin($data);
    }


    function get_class(){
        $program_id = $this->input->post('id');
        if(isset($program_id) && !empty($program_id)){
            $stdData = explode(",",$program_id);
            $program_id = $stdData[0];
        }
        $arr_class = Modules::run('classes/_get_by_arr_id_program',$program_id)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_class as $key => $value) {
            $html.='<option value='.$value['id'].','.$value['name'].'>'.$value['name'].'</option>';
        }
        echo $html;
    }

    function get_section(){
        $class_id = $this->input->post('id');
        if(isset($class_id) && !empty($class_id)){
            $stdData = explode(",",$class_id);
            $class_id = $stdData[0];
        }
        $arr_section = Modules::run('sections/_get_by_arr_id_class',$class_id)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_section as $key => $value) {
            $html.='<option value='.$value['id'].','.$value['section'].'>'.$value['section'].'</option>';
        }
        echo $html;
    }

    function _get_data_from_db($update_id) {
        $where['voucher_record.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['section_id'] = $row->section_id;
            $data['section_name'] = $row->section_name;
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['class_id'] = $row->class_id;
            $data['class_name'] = $row->class_name;
            $data['issue_date'] = $row->issue_date;
            $data['due_date'] = $row->due_date;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }

    function get_data_from_db_std_voucher($update_id) {
        $where['voucher_data.id'] = $update_id;
        $query = $this->_get_by_arr_id_std_voucher($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['voucher_id'] = $row->voucher_id;
            $data['std_id'] = $row->std_id;
            $data['std_roll_no'] = $row->std_roll_no;
            $data['std_name'] = $row->std_name;
            $data['parent_name'] = $row->parent_name;
            $data['tution_fee'] = $row->tution_fee;
            $data['transport_fee'] = $row->transport_fee;
            $data['stationary_fee'] = $row->stationary_fee;
            $data['lunch_fee'] = $row->lunch_fee;
            $data['other_fee'] = $row->other_fee;
            $data['previous_fee'] = $row->previous_fee;
            $data['total'] = $row->total;
            $data['paid'] = $row->paid;
            $data['remaining'] = $row->remaining;
            $data['status'] = $row->status;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $section_id = $this->input->post('section_id');
        if(isset($section_id) && !empty($section_id)){
            $stdData = explode(",",$section_id);
            $data['section_id'] = $stdData[0];
            $data['section_name'] = $stdData[1];
        }

        $class_id = $this->input->post('class_id');
        if(isset($class_id) && !empty($class_id)){
            $stdData = explode(",",$class_id);
            $data['class_id'] = $stdData[0];
            $data['class_name'] = $stdData[1];
        }
        $program_id = $this->input->post('program_id');
        if(isset($program_id) && !empty($program_id)){
            $stdData = explode(",",$program_id);
            $data['program_id'] = $stdData[0];
            $data['program_name'] = $stdData[1];
        }
        $data['issue_date']=date('Y/m/d');
        $data['due_date'] = $this->input->post('due_date');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function _get_data_from_post_std_voucher() {
        $data['tution_fee'] = $this->input->post('tution_fee');
        $data['transport_fee'] = $this->input->post('transport_fee');
        $data['lunch_fee'] = $this->input->post('lunch_fee');
        $data['stationary_fee'] = $this->input->post('stationary_fee');
        $data['other_fee'] = $this->input->post('other_fee');
        $data['previous_fee'] = $this->input->post('previous_fee');
        $data['paid'] = $this->input->post('paid');
        $data['total'] = $data['tution_fee']+$data['transport_fee']+$data['lunch_fee']+$data['stationary_fee']+$data['other_fee']+$data['previous_fee'];
        $data['remaining'] = $data['total'] - $data['paid'];
        date_default_timezone_set("Asia/Karachi");
        $data['pay_date'] = date('Y-m-d H:i:s');
        if ($data['total'] <= $data['paid']) {
            $data['status'] = 1;
        }
        else{
            $data['status'] = 0;
        }
        return $data;
    }

    function submit() {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            $user_data = $this->session->userdata('user_data');
            if ($update_id != 0) {
                $data3['due_date'] = $data['due_date'];
                $data3['issue_date'] = $data['issue_date'];
                $id = $this->_update($update_id,$user_data['user_id'], $data3);
                $v_data = $this->_get_std_vouchers($update_id)->result_array();

                $whereSection['section_id'] = $data['section_id'];
                $parents = $this->_get_parent_id_for_notification($whereSection,$data['org_id'])->result_array();
                if (isset($parents) && !empty($parents)) {
                    foreach ($parents as $key => $value) {
                        $data2['notif_for'] = 'Parent';
                        $data2['user_id'] = $value['parent_id'];
                        $data2['std_id'] = $value['id'];
                        $data2['std_name'] = $value['name'];
                        $data2['std_roll_no'] = $value['roll_no'];
                        $data2['notif_title'] = 'Fee Voucher Update';
                        $data2['notif_description'] = 'Fee Voucehr of '.$value['name'].' has been updated';
                        $data2['notif_type'] = 'fee';
                        $data2['notif_sub_type'] = 'fee_update';
                        foreach ($v_data as $key => $value2) {
                            if ($value2['std_id'] == $value['id']) {
                                $data2['sub_type_id'] = $value2['id'];
                            }
                        }
                        $data2['type_id'] = $update_id;
                        $data2['section_id']= $data['section_id'];
                        date_default_timezone_set("Asia/Karachi");
                        $data2['notif_date'] = date('Y-m-d H:i:s');
                        $data2['org_id'] = $data['org_id'];
                        $nid = $this->_notif_insert_data($data2);
                        $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                        Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
                    }
                }
            }
            else
            {   
                $voucher_id = $this->_insert($data);
                $student_list = $this->_get_student_by_section_id($data['section_id'],$data['org_id'])->result_array();
                if(isset($student_list) && !empty($student_list)){
                    foreach ($student_list as $key => $value) {
                    	$previous_fee = $this->_get_previous_fee($value['id'])->result_array();
                        $data1['voucher_id'] = $voucher_id;
                        $data1['std_id'] = $value ['id'];
                        $data1['std_roll_no'] = $value['roll_no'];
                        $data1['std_name'] = $value['name'];
                        $data1['parent_name'] = $value ['parent_name'];
                        $data1['tution_fee'] = $value['tution_fee'];
                        $data1['transport_fee'] = $value['transport_fee'];
                        $data1['lunch_fee'] = $value ['lunch_fee'];
                        $data1['stationary_fee'] = $value['stationary_fee'];
                        $data1['other_fee'] = $value['other_fee'];
                        if (isset($previous_fee) && !empty($previous_fee)) {
                        	$data1['previous_fee'] = $previous_fee[0]['remaining'];	
                        }
                        else{
                        	$data1['previous_fee'] = 0;
                        }
                        $data1['total'] = $data1['tution_fee']+$data1['transport_fee']+$data1['lunch_fee']+$data1['stationary_fee']+$data1['other_fee']+$data1['previous_fee'];
                        $data1['remaining'] = $data1['total'];
                        $id = $this->_insert_std_voucher($data1);
                        $data2['notif_for'] = 'Parent';
                        $data2['user_id'] = $value['parent_id'];
                        $data2['std_id'] = $value['id'];
                        $data2['std_name'] = $value['name'];
                        $data2['std_roll_no'] = $value['roll_no'];
                        $data2['notif_title'] = 'Fee Voucher';
                        $data2['notif_description'] = 'Fee of '.$value['name'].' is pending';
                        $data2['notif_type'] = 'fee';
                        $data2['notif_sub_type'] = 'fee';
                        $data2['type_id'] = $voucher_id;
                        $data2['sub_type_id'] = $id;
                        $data2['section_id'] = $data['section_id'];
                        $data2['class_id'] = $data['class_id'];
                        $data2['program_id'] = $data['program_id'];
                        date_default_timezone_set("Asia/Karachi");
                        $data2['notif_date'] = date('Y-m-d H:i:s');
                        $data2['org_id'] = $data['org_id'];
                        $nid = $this->_notif_insert_data($data2);
                        $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                        Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
                    }
                }
            }
                $this->session->set_flashdata('message', 'voucher'.' '.DATA_SAVED);                                        
                $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'voucher');
    }

    function submit_std_voucher() {
        $voucher_id = $this->uri->segment(4);
        $class = $this->uri->segment(5);
        $update_id = $this->uri->segment(6);
        $data = $this->_get_data_from_post_std_voucher();
        if ($update_id != 0) {
            $id = $this->_update_std_voucher($update_id, $data);
        }
        $this->session->set_flashdata('message', 'voucher'.' '.DATA_SAVED);
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'voucher/std_voucher/'.$voucher_id.'/'.$class);
    }


    function _get_student_by_section_id($section_id,$org_id){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_student_by_section_id($section_id,$org_id);
    }

    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->_delete($delete_id, $org_id);
    }

    function set_publish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'voucher/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'voucher/manage/' . '');
    }

   

    function change_status() {
        $id = $this->input->post('id');
        $std_data = $this->get_data_from_db_std_voucher($id);
        if (isset($std_data) && !empty($std_data)) {
            $data['paid'] = $std_data['total'];
            date_default_timezone_set("Asia/Karachi");
            $data['pay_date'] = date('Y-m-d H:i:s');
            $data['remaining'] = 0;
        }
        $status = $this->input->post('status');
        if ($status == PUBLISHED){
            $status = UN_PUBLISHED;
            $data['paid'] = 0;
            $data['pay_date'] = '';
            $data['remaining'] = $std_data['total'];
        }
        else{
            $status = PUBLISHED;
        }
        $data['status'] = $status;
        $status = $this->_update_id($id, $data);
        echo $status;
    }

    /////////////// for detail ////////////

    function _set_publish($arr_col) {
        $this->load->model('mdl_voucher');
        $this->mdl_voucher->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_voucher');
        $this->mdl_voucher->_set_unpublish($arr_col);
    }

    function _getItemById($id) {
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_getItemById($id);
    }

    function _get($order_by) {
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get($order_by);
    }

    function _get_std_vouchers($voucher_id) {
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_std_vouchers($voucher_id);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_by_arr_id($arr_col);
    }

    function _get_by_arr_id_std_voucher($arr_col) {
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_by_arr_id_std_voucher($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_insert($data);
    }

    function _insert_std_voucher($data1) {
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_insert_std_voucher($data1);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_voucher');
        $this->mdl_voucher->_update($arr_col, $org_id, $data);
    }

    function _update_std_voucher($arr_col, $data) {
        $this->load->model('mdl_voucher');
        $this->mdl_voucher->_update_std_voucher($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_voucher');
        $this->mdl_voucher->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_voucher');
        $this->mdl_voucher->_delete($arr_col, $org_id);
    }

    function _get_subject_by_arr_id($update_id){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_subject_by_arr_id($update_id);
    }
    function _get_parent_by_arr_id($update_id){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_parent_by_arr_id($update_id);
    }

    function _get_by_arr_id_section($section_id){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_by_arr_id_section($section_id);
    }

    function _get_class_student_list($update_id,$org_id){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_class_student_list($update_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_parent_token($parent_id,$org_id);
    }

    function _get_parent_id_for_notification($where,$org_id){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_parent_id_for_notification($where,$org_id);
    }

    function _notif_insert_data($data2){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_notif_insert_data($data2);
    }

    function _get_data_from_db_print_voucher($where){
        $this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_data_from_db_print_voucher($where);
    }

    function _get_previous_fee($std_id){
    	$this->load->model('mdl_voucher');
        return $this->mdl_voucher->_get_previous_fee($std_id);
    }
}