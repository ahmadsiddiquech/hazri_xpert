<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends MX_Controller
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
        $data['news'] = $this->_get('test.id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
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

    function marks() {
        $update_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        
        $data['update_id'] = $update_id;
        $student_list = $this->_get_class_student_list($update_id,$org_id)->result_array();
        foreach ($student_list as $key => $value) {
            $obtained_marks=$this->_get_class_student_marks($value['std_id'],$value['test_id'])->result_array();
            
            $finalData['test_id'] = $value['test_id'];
            $finalData['test_title'] = $value['test_title'];
            $finalData['class_name'] = $value['class_name'];
            $finalData['total_marks'] = $value['total_marks'];
            $finalData['std_id'] = $value['std_id'];
            $finalData['roll_no'] = $value['roll_no'];
            $finalData['name'] = $value['name'];
            if (isset($obtained_marks) && !empty($obtained_marks)) {
                foreach ($obtained_marks as $key => $value1) {
                    $finalData['obtained_marks'] = $value1['obtained_marks'];
                    $finalData2[] = $finalData;
                }
            }
            else{
                $finalData['obtained_marks'] = '';
                $finalData2[] = $finalData;
            }

        }
        $data['student_list'] = $finalData2;
        $data['view_file'] = 'marks';
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
        $where['test.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['test_title'] = $row->test_title;
            $data['test_description'] = $row->test_description;
            $data['class_name'] = $row->class_name;
            $data['subject_name'] = $row->subject_name;
            $data['section_id'] = $row->section_id;
            $data['section_name'] = $row->section_name;
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['teacher_id'] = $row->teacher_id;
            $data['teacher_name'] = $row->teacher_name;
            $data['class_id'] = $row->class_id;
            $data['subject_id'] = $row->subject_id;
            $data['total_marks'] = $row->total_marks;
            $data['test_date'] = $row->test_date;
            $data['test_time'] = $row->test_time;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $subject_id = $this->input->post('subject_id');
        if(isset($subject_id) && !empty($subject_id)){
            $stdData = explode(",",$subject_id);
            $data['subject_id'] = $stdData[0];
            $var = str_replace('-', ' ', $stdData[1]);
            $data['subject_name'] = $var;
        }

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
        $data['test_title'] = $this->input->post('test_title');
        $data['test_description'] = $this->input->post('test_description');
        $data['test_date'] = $this->input->post('test_date');
        $data['test_time'] = $this->input->post('test_time');
        $data['total_marks'] = $this->input->post('total_marks');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;

    }

    function submit() {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            $arr_teacher = Modules::run('subjects/_get_subject_teacher',$data['subject_id'],$data['org_id'])->result_array();
            if (isset($arr_teacher) && !empty($arr_teacher)) {
            $data['teacher_id'] = $arr_teacher[0]['teacher_id'];
            $data['teacher_name'] =  $arr_teacher[0]['teacher_name'];
            }
            $data['created_by'] = 'admin';
            $user_data = $this->session->userdata('user_data');
            if ($update_id != 0) {
                $id = $this->_update($update_id,$user_data['user_id'], $data);
                $whereSection['section_id'] = $data['section_id'];
                $parents = $this->_get_parent_id_for_notification($whereSection,$data['org_id'])->result_array();
                if (isset($parents) && !empty($parents)) {
                    foreach ($parents as $key => $value) {
                        $data2['user_id'] = $value['parent_id'];
                        $data2['std_id'] = $value['id'];
                        $data2['std_name'] = $value['name'];
                        $data2['std_roll_no'] = $value['roll_no'];
                        $data2['notif_for'] = 'Parent';
                        $data2['notif_title'] = $data['test_title'];
                        $data2['notif_description'] = 'Admin Updated this Test';
                        $data2['notif_type'] = 'test';
                        $data2['notif_sub_type'] = 'test_update';
                        $data2['type_id'] = $update_id;
                        $data2['subject_id'] = $data['subject_id'];
                        $data2['subject_name'] = $data['subject_name'];
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
                $whereSbj['id'] = $data['subject_id'];
                $teachers = $this->_get_teacher_id_for_notification($whereSbj,$data['org_id'])->result_array();
                if (isset($teachers) && !empty($teachers)) {
                    foreach ($teachers as $key => $value) {
                        $data2['notif_for'] = 'Teacher';
                        $data2['user_id'] = $value['teacher_id'];
                        $data2['std_id'] = '';
                        $data2['std_name'] = '';
                        $data2['std_roll_no'] = '';
                        $data2['notif_title'] = $data['test_title'];
                        $data2['notif_description'] = 'Admin Updated this Test';
                        $data2['notif_type'] = 'test';
                        $data2['notif_sub_type'] = 'test_update';
                        $data2['type_id'] = $update_id;
                        $data2['subject_id'] = $data['subject_id'];
                        $data2['subject_name'] = $data['subject_name'];
                        $data2['section_id'] = $data['section_id'];
                        $data2['class_id'] = $data['class_id'];
                        $data2['program_id'] = $data['program_id'];
                        date_default_timezone_set("Asia/Karachi");
                        $data2['notif_date'] = date('Y-m-d H:i:s');
                        $data2['org_id'] = $data['org_id'];
                        $nid = $this->_notif_insert_data($data2);
                        $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                        Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
                    }
                }
            }
            else
            {
                $id = $this->_insert($data);
                $whereSection['section_id'] = $data['section_id'];
                $parents = $this->_get_parent_id_for_notification($whereSection,$data['org_id'])->result_array();
                if (isset($parents) && !empty($parents)) {
                    foreach ($parents as $key => $value) {
                        $data2['user_id'] = $value['parent_id'];
                        $data2['std_id'] = $value['id'];
                        $data2['std_name'] = $value['name'];
                        $data2['std_roll_no'] = $value['roll_no'];
                        $data2['notif_for'] = 'Parent';
                        $data2['notif_title'] = $data['test_title'];
                        $data2['notif_description'] = $data['test_description'];
                        $data2['notif_type'] = 'test';
                        $data2['notif_sub_type'] = 'test';
                        $data2['type_id'] = $id;
                        $data2['subject_id'] = $data['subject_id'];
                        $data2['subject_name'] = $data['subject_name'];
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
                $whereSbj['id'] = $data['subject_id'];
                $teachers = $this->_get_teacher_id_for_notification($whereSbj,$data['org_id'])->result_array();
                if (isset($teachers) && !empty($teachers)) {
                    foreach ($teachers as $key => $value) {
                        $data2['notif_for'] = 'Teacher';
                        $data2['user_id'] = $value['teacher_id'];
                        $data2['std_id'] = '';
                        $data2['std_name'] = '';
                        $data2['std_roll_no'] = '';
                        $data2['notif_title'] = $data['test_title'];
                        $data2['notif_description'] = $data['test_description'];
                        $data2['notif_type'] = 'test';
                        $data2['notif_sub_type'] = 'test';
                        $data2['type_id'] = $id;
                        $data2['subject_id'] = $data['subject_id'];
                        $data2['subject_name'] = $data['subject_name'];
                        $data2['section_id'] = $data['section_id'];
                        $data2['class_id'] = $data['class_id'];
                        $data2['program_id'] = $data['program_id'];
                        date_default_timezone_set("Asia/Karachi");
                        $data2['notif_date'] = date('Y-m-d H:i:s');
                        $data2['org_id'] = $data['org_id'];
                        $nid = $this->_notif_insert_data($data2);
                        $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                        Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
                    }
                }
            }
            $this->session->set_flashdata('message', 'test'.' '.DATA_SAVED);                                        
            $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'test');
    }

    function get_subject(){
        $section_id = $this->input->post('id');
        if(isset($section_id) && !empty($section_id)){
            $stdData = explode(",",$section_id);
            $section_id = $stdData[0];
        }
        $arr_subject = Modules::run('subjects/_get_subject',$section_id)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_subject as $key => $value) {
            $var = str_replace(' ', '-', $value['name']);
            $html.='<option value='.$value['id'].','.$var.'>'.$value['name'].'</option>';
        }
        echo $html;
    }

    function check_subject () {
        $subject_id = $this->input->post('subject_id');
        $this->load->model('mdl_test');
        $check = $this->mdl_test->check_subject($subject_id);
        if($check->num_rows()!=0){
            echo "true";
        }
        else{
            echo "false";
        }
    }

    function update_marks () {
        $std_id = $this->input->post('std_id');
        $roll_no = $this->input->post('roll_no');
        $test_id = $this->input->post('test_id');
        $std_name = $this->input->post('std_name');
        $obtained_marks = $this->input->post('obt_mark');
        $this->load->model('mdl_test');
        $check = $this->mdl_test->update_marks($std_id,$roll_no,$test_id,$obtained_marks);
        $data = $this->_get_data_from_db($test_id);

        $whereSection['id'] = $std_id;
        $parents = $this->_get_parent_id_for_notification($whereSection,$data['org_id'])->result_array();
        if (isset($parents) && !empty($parents)) {
            foreach ($parents as $key => $value) {
                $data2['user_id'] = $value['parent_id'];
                $data2['std_id'] = $value['id'];
                $data2['std_name'] = $value['name'];
                $data2['std_roll_no'] = $value['roll_no'];
                $data2['notif_for'] = 'Parent';
                $data2['notif_title'] = $data['test_title'];
                $data2['notif_description'] = 'Marks of '.$std_name .' for this Test are ' . $obtained_marks .'  (updated)';
                $data2['notif_type'] = 'test';
                $data2['notif_sub_type'] = 'marks_update';
                $data2['type_id'] = $test_id;
                $data2['subject_id'] = $data['subject_id'];
                $data2['subject_name'] = $data['subject_name'];
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
        $whereSbj['id'] = $data['subject_id'];
        $teachers = $this->_get_teacher_id_for_notification($whereSbj,$data['org_id'])->result_array();
        if (isset($teachers) && !empty($teachers)) {
            foreach ($teachers as $key => $value) {
                $data2['notif_for'] = 'Teacher';
                $data2['user_id'] = $value['teacher_id'];
                $data2['std_id'] = '';
                $data2['std_name'] = '';
                $data2['std_roll_no'] = '';
                $data2['notif_title'] = $data['test_title'];
                $data2['notif_description'] = 'Marks of '.$std_name .' for this Test are ' . $obtained_marks .'  (updated)';
                $data2['notif_type'] = 'test';
                $data2['notif_sub_type'] = 'marks_update';
                $data2['type_id'] = $test_id;
                $data2['subject_id'] = $data['subject_id'];
                $data2['subject_name'] = $data['subject_name'];
                $data2['section_id'] = $data['section_id'];
                $data2['class_id'] = $data['class_id'];
                $data2['program_id'] = $data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $data['org_id'];
                $nid = $this->_notif_insert_data($data2);
                $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
            }
        }
        if($check == true){
            echo "true";
        }
        else{
            echo "false";
        }
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
        redirect(ADMIN_BASE_URL . 'test/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'test/manage/' . '');
    }

   

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == PUBLISHED)
            $status = UN_PUBLISHED;
        else
            $status = PUBLISHED;
        $data = array('status' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
    }

    /////////////// for detail ////////////
    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }
	
    function _getItemById($id) {
        $this->load->model('mdl_test');
        return $this->mdl_test->_getItemById($id);
    }


    function _set_publish($arr_col) {
        $this->load->model('mdl_test');
        $this->mdl_test->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_test');
        $this->mdl_test->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_test');
        return $this->mdl_test->_get($order_by);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_by_arr_id($arr_col);
    }


    function _insert($data) {
        $this->load->model('mdl_test');
        return $this->mdl_test->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_test');
        $this->mdl_test->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_test');
        $this->mdl_test->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_test');
        $this->mdl_test->_delete($arr_col, $org_id);
    }

    function _get_subject_by_arr_id($update_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_subject_by_arr_id($update_id);
    }
    function _get_parent_by_arr_id($update_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_parent_by_arr_id($update_id);
    }

    function _get_by_arr_id_section($section_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_by_arr_id_section($section_id);
    }

    function _get_class_student_list($update_id,$org_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_class_student_list($update_id,$org_id);
    }

    function _get_class_student_marks($std_id,$test_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_class_student_marks($std_id,$test_id);
    }

    function _notif_insert_data($data2){
        $this->load->model('mdl_test');
        return $this->mdl_test->_notif_insert_data($data2);
    }

    function _get_parent_id_for_notification($where,$org_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_parent_id_for_notification($where,$org_id);
    }

    function _get_teacher_id_for_notification($where,$org_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_teacher_id_for_notification($where,$org_id);
    }

    function _get_teacher_token($teacher_id,$org_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_teacher_token($teacher_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
        $this->load->model('mdl_test');
        return $this->mdl_test->_get_parent_token($parent_id,$org_id);
    }
}