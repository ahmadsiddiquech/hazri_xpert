<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class datesheet extends MX_Controller
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
        $data['news'] = $this->_get('datesheet_record.id desc');
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

    function subjects() {
        $datesheet_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        
        $finalData2 = $this->_get_datesheet_subject($datesheet_id)->result_array();

        $data['update_id'] = $datesheet_id;
        $data['subject_list'] = $finalData2;
        $data['view_file'] = 'subjects';
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
        // print_r($arr_section);exit();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_section as $key => $value) {
            $html.='<option value='.$value['id'].','.$value['section'].'>'.$value['section'].'</option>';
        }
        echo $html;
    }

    function _get_data_from_db($update_id) {
        $query = $this->_get_by_arr_id($update_id);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['class_name'] = $row->class_name;
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['class_id'] = $row->class_id;
            $data['start_date'] = $row->start_date;
            $data['end_date'] = $row->end_date;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }

    function _get_data_from_post() {
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
        $data['start_date'] = $this->input->post('start_date');
        $data['end_date'] = $this->input->post('end_date');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function get_subject_data($datesheet_id,$subject_id) {
        $query = $this->_get_subject_data($datesheet_id,$subject_id);
        foreach ($query->result() as
                $row) {
            $data['subject_id'] = $row->subject_id;
            $data['subject_name'] = $row->subject_name;
            $data['exam_date'] = $row->exam_date;
            $data['start_time'] = $row->start_time;
            $data['end_time'] = $row->end_time;
        }
        if(isset($data))
            return $data;
    }
    function submit() {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            $user_data = $this->session->userdata('user_data');
            if ($update_id != 0) {
                $id = $this->_update($update_id,$user_data['user_id'], $data);
                $data2['notif_title'] = $data['program_name'];
                $data2['notif_description'] = 'Admin updated datesheet for class '.$data['class_name'];
                $data2['notif_type'] = 'datesheet';
                $data2['type_id'] = $update_id;
                $data2['class_id'] = $data['class_id'];
                $data2['program_id'] = $data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $data['org_id'];
                $this->_notif_insert_data_teacher($data2);
                $this->_notif_insert_data_parent($data2);

                $where['class_id'] = $data2['class_id'];
                $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();
                if (isset($teacher_id) && !empty($teacher_id)) {
                    foreach ($teacher_id as $key => $value) {
                        $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                        Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
                    }  
                }

                $where1['class_id'] = $data2['class_id'];
                $parent_id = $this->_get_parent_for_push_noti($where1,$data2['org_id'])->result_array();
                if (isset($parent_id) && !empty($parent_id)) {
                    foreach ($parent_id as $key => $value) {
                        $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                       Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
                    }   
                }
            }
            else {
                $datesheet_id = $this->_insert_datesheet($data);
                $subject_name = $this->input->post('subject_name');
                $exam_date = $this->input->post('exam_date');
                $start_time = $this->input->post('start_time');
                $end_time = $this->input->post('end_time');
                $this->adding_datesheet_subject($subject_name, $exam_date, $start_time, $end_time, $datesheet_id,$user_data['user_id']);

                $data2['notif_title'] = $data['program_name'];
                $data2['notif_description'] = 'Datesheet added for class '.$data['class_name'];
                $data2['notif_type'] = 'datesheet';
                $data2['type_id'] = $datesheet_id;
                $data2['class_id'] = $data['class_id'];
                $data2['program_id'] = $data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $data['org_id'];
                $this->_notif_insert_data_teacher($data2);
                $this->_notif_insert_data_parent($data2);

                $where['class_id'] = $data2['class_id'];
                $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();
                if (isset($teacher_id) && !empty($teacher_id)) {
                    foreach ($teacher_id as $key => $value) {
                        $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                        Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
                    }  
                }

                $where1['class_id'] = $data2['class_id'];
                $parent_id = $this->_get_parent_for_push_noti($where1,$data2['org_id'])->result_array();
                if (isset($parent_id) && !empty($parent_id)) {
                    foreach ($parent_id as $key => $value) {
                        $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                       Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
                    }   
                }
            }
            $this->session->set_flashdata('message', 'datesheet'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'datesheet');
    }
    function adding_datesheet_subject($subject_name ,$exam_date,$start_time,$end_time, $datesheet_id,$org_id) {
        $counter=0;
        foreach ($subject_name as $key => $value) {
            $data = array();
            unset($data); 
            $data = array();
            $subject_name2=explode(',', $subject_name[$counter]);
            $data['subject_id'] = $subject_name2[0];
            $data['subject_name'] = $subject_name2[1];
            $data['exam_date']=$exam_date[$counter];
            $data['start_time']=$start_time[$counter];
            $data['end_time']=$end_time[$counter];
            $data['datesheet_id']=$datesheet_id;

            if(!empty($value)){
                $this->_insert_datesheet_subject($data);
            }
            $counter++; 
        }

    }


   
    function subject_edit() {
        $datesheet_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['news'] = $this->get_subject_data($datesheet_id,$subject_id,$org_id);
        $data['view_file'] = 'subject_edit';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_subject_edit() {
        $datesheet_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['exam_date'] = $this->input->post('exam_date');
        $data['end_time'] = $this->input->post('start_time');
        $data['start_time'] = $this->input->post('end_time');
        // print_r($data);exit();
        $check = $this->update_subject($subject_id,$datesheet_id,$data);

        $notif_data = $this->_get_data_from_db($datesheet_id);
        $data2['notif_title'] = $notif_data['program_name'];
        $data2['notif_description'] = 'Admin Edited The Subjects of this datesheet for class '.$notif_date['class_name'];
        $data2['notif_type'] = 'datesheet';
        $data2['type_id'] = $notif_data['id'];
        $data2['class_id'] = $notif_data['class_id'];
        $data2['program_id'] = $notif_data['program_id'];
        date_default_timezone_set("Asia/Karachi");
        $data2['notif_date'] = date('Y-m-d H:i:s');
        $data2['org_id'] = $notif_data['org_id'];
        $this->_notif_insert_data_teacher($data2);
        $this->_notif_insert_data_parent($data2);

        $where['class_id'] = $data2['class_id'];
        $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();
        if (isset($teacher_id) && !empty($teacher_id)) {
            foreach ($teacher_id as $key => $value) {
                $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
            }  
        }

        $where1['class_id'] = $data2['class_id'];
        $parent_id = $this->_get_parent_for_push_noti($where1,$data2['org_id'])->result_array();
        if (isset($parent_id) && !empty($parent_id)) {
            foreach ($parent_id as $key => $value) {
                $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
               Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
            }   
        }

        if($check == true){
            $this->session->set_flashdata('message', 'datesheet'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'datesheet/subjects/'. $datesheet_id);
        }
        else{
            $this->session->set_flashdata('message', 'datesheet'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'datesheet/subjects/'. $datesheet_id);
        }
    }

    function get_subject(){
        $class_id = $this->input->post('id');
        if(isset($class_id) && !empty($class_id)){
            $stdData = explode(",",$class_id);
            $class_id = $stdData[0];
        }
        $arr_subject = Modules::run('subjects/_get_subject_class',$class_id)->result_array();
        // print_r($arr_subject);exit();
        $html='';
        $html.='<h3>Subjects</h3>';
        foreach ($arr_subject as $key => $value) {
            $html.='<div class="col-md-4">';
            $html.='Subject Name';
            $html.='<input class="form-control" readonly type="name" name="subject_name[]" value='.$value['id'].','.$value['name'].'>';
            $html.='</div>';
            $html.='<div class="col-md-3">';
            $html.='Exam Date';
            $html.='<input class="form-control" type="date" name="exam_date[]">';
            $html.='</div>';
            $html.='<div class="col-md-2">';
            $html.='Start Time';
            $html.='<input class="form-control" type="time" name="start_time[]">';
            $html.='</div>';
            $html.='<div class="col-md-2">';
            $html.='End Time';
            $html.='<input class="form-control" type="time" name="end_time[]">';
            $html.='</div>';

        }
        print_r($html);
    }

    function check_subject () {
        $subject_id = $this->input->post('subject_id');
        $this->load->model('mdl_datesheet');
        $check = $this->mdl_datesheet->check_subject($subject_id);
        if($check->num_rows()!=0){
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
        //$lang_id = $this->uri->segment(5);
        $where['id'] = $update_id;
        //$where['lang_id'] = $lang_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'datesheet/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        //$lang_id = $this->uri->segment(5);
        $where['id'] = $update_id;
        //$where['lang_id'] = $lang_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'datesheet/manage/' . '');
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
       // $lang_id = $this->input->post('lang_id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }
	
    function _getItemById($id) {
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_getItemById($id);
    }


    function _set_publish($arr_col) {
        $this->load->model('mdl_datesheet');
        $this->mdl_datesheet->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_datesheet');
        $this->mdl_datesheet->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_datesheet');
        $query = $this->mdl_datesheet->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_get_by_arr_id($update_id);
    }

    function _insert_datesheet_subject($data_subject) {
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_insert_datesheet_subject($data_subject);
    }

    function _insert_datesheet($data_datesheet){
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_insert_datesheet($data_datesheet);
    }

    function update_subject($subject_id,$datesheet_id,$data){
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->update_subject($subject_id,$datesheet_id,$data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_datesheet');
        $this->mdl_datesheet->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_datesheet');
        $this->mdl_datesheet->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_datesheet');
        $this->mdl_datesheet->_delete($arr_col, $org_id);
    }

    function _get_subject_by_arr_id($update_id){
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_get_subject_by_arr_id($update_id);
    }
    function _get_parent_by_arr_id($update_id){
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_get_parent_by_arr_id($update_id);
    }

    function _get_by_arr_id_section($section_id){
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_get_by_arr_id_section($section_id);
    }

    function _get_datesheet_subject($datesheet_id){
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_get_datesheet_subject($datesheet_id);
    }

    function _get_subject_data($datesheet_id,$subject_id){
        $this->load->model('mdl_datesheet');
        return $this->mdl_datesheet->_get_subject_data($datesheet_id,$subject_id);
    }

    function _notif_insert_data_teacher($data2){
        $this->load->model('mdl_datesheet');
        $this->mdl_datesheet->_notif_insert_data_teacher($data2);
    }

    function _notif_insert_data_parent($data2){
        $this->load->model('mdl_datesheet');
        $this->mdl_datesheet->_notif_insert_data_parent($data2);
    }

    function _get_teacher_for_push_noti($where,$org_id){
    $this->load->model('mdl_datesheet');
    return $this->mdl_datesheet->_get_teacher_for_push_noti($where,$org_id);
    }

    function _get_parent_for_push_noti($where,$org_id){
    $this->load->model('mdl_datesheet');
    return $this->mdl_datesheet->_get_parent_for_push_noti($where,$org_id);
    }

    function _get_teacher_token($teacher_id,$org_id){
    $this->load->model('mdl_datesheet');
    return $this->mdl_datesheet->_get_teacher_token($teacher_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
    $this->load->model('mdl_datesheet');
    return $this->mdl_datesheet->_get_parent_token($parent_id,$org_id);
    }
}