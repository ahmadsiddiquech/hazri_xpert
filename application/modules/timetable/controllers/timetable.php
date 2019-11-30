<?php

if (!defined('BASEPATH')) 
    exit('No direct script access allowed');

class Timetable extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->select();
    }

    function select(){
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $arr_program = Modules::run('program/_get_by_arr_id_programs',$org_id)->result_array();
        $program = array();

        foreach($arr_program as $row){
            $program[$row['id']] = $row['name'];
        }
        $data['program_title'] = $program;
        $data['view_file'] = 'select';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function print_timetable(){
        $timetable_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $timetable = $this->_get_timetable_print_voucher($timetable_id,$org_id)->result_array();
        $org = $this->_get_org_print_voucher($org_id)->result_array();
        $data['org'] = $org;
        $data['timetable'] = $timetable;
       
        $this->load->view('print',$data);
    }

    function manage() {
        $program_id = $this->input->post('program_id');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');

        $stdData = explode(",",$program_id);
        $program_id = $stdData[0];

        $stdData = explode(",",$class_id);
        $class_id = $stdData[0];

        $stdData = explode(",",$section_id);
        $section_id = $stdData[0];

        $data['news'] = $this->_get($program_id,$class_id,$section_id);

        // print_r($data['news']);exit();

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
        $timetable_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        
        $finalData2 = $this->_get_timetable_subject($timetable_id)->result_array();
        $data['update_id'] = $timetable_id;
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
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['class_id'] = $row->class_id;
            $data['class_name'] = $row->class_name;
            $data['section_id'] = $row->section_id;
            $data['section_name'] = $row->section_name;
            $data['day'] = $row->day;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
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
        $data['day'] = $this->input->post('day');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function get_subject_data($timetable_id,$subject_id) {
        $query = $this->_get_subject_data($timetable_id,$subject_id);
        foreach ($query->result() as
                $row) {
            $data['subject_id'] = $row->subject_id;
            $data['subject_name'] = $row->subject_name;
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
            }
            else {
                $timetable_id = $this->_insert_timetable($data);
                $subject_name = $this->input->post('subject_name');
                $start_time = $this->input->post('start_time');
                $end_time = $this->input->post('end_time');
                $break = $this->input->post('break');
                $break_start_time = $this->input->post('break_start_time');
                $break_end_time = $this->input->post('break_end_time');

                $this->adding_timetable_subject($subject_name, $start_time, $end_time,$timetable_id,$user_data['user_id'] ,$break,$break_start_time,$break_end_time);

                $no_of_days = $this->_no_of_days($data['class_id'],$data['section_id'])->num_rows();
                if ($no_of_days == 6) {
                    $whereSection['section_id'] = $data['section_id'];
                    $parents = $this->_get_parent_id_for_notification($whereSection,$data['org_id'])->result_array();
                    if (isset($parents) && !empty($parents)) {
                        foreach ($parents as $key => $value) {
                            $data2['user_id'] = $value['parent_id'];
                            $data2['std_id'] = $value['id'];
                            $data2['std_name'] = $value['name'];
                            $data2['std_roll_no'] = $value['roll_no'];
                            $data2['notif_for'] = 'Parent';
                            $data2['notif_title'] = 'Timetabe for Class '.$data['class_name'];
                            $data2['notif_description'] = 'Admin Added the timetable for this class';
                            $data2['notif_type'] = 'timetable';
                            $data2['notif_sub_type'] = 'timetable';
                            $data2['type_id'] = $timetable_id;
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
                    $teachers = $this->_get_teacher_id_for_notification($whereSection,$data['org_id'])->result_array();
                    if (isset($teachers) && !empty($teachers)) {
                        foreach ($teachers as $key => $value) {
                            $data2['notif_for'] = 'Teacher';
                            $data2['user_id'] = $value['teacher_id'];
                            $data2['std_id'] = '';
                            $data2['std_name'] = '';
                            $data2['std_roll_no'] = '';
                            $data2['notif_title'] = 'Timetabe for Class '.$data['class_name'];
                            $data2['notif_description'] = 'Admin Added the timetable for this class';
                            $data2['notif_type'] = 'timetable';
                            $data2['notif_sub_type'] = 'timetable';
                            $data2['type_id'] = $timetable_id;
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
            }
            $this->session->set_flashdata('message', 'timetable'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'timetable');
    }
    
    function adding_timetable_subject($subject_name ,$start_time,$end_time,$timetable_id,$org_id,$break,$break_start_time,$break_end_time) {
        $counter=0;
        foreach ($subject_name as $key => $value) {
            $data = array();
            unset($data); 
            $data = array();
            $subject_name2=explode(',', $subject_name[$counter]);
            $data['subject_id'] = $subject_name2[0];
            $data['subject_name'] = $subject_name2[1];
            $data['start_time']=$start_time[$counter];
            $data['end_time']=$end_time[$counter];
            $data['timetable_id']=$timetable_id;
            if(!empty($value)){

                $this->_insert_timetable_subject($data);
            }
            $counter++; 
        }
        if (isset($break) && !empty($break)) {
            $data['subject_id'] = 0;
            $data['subject_name'] = $break;
            $data['start_time']=$break_start_time;
            $data['end_time']=$break_end_time;
            $data['timetable_id']=$timetable_id;
            $this->_insert_timetable_subject($data);
        }
    }

    function subject_edit() {
        $timetable_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['news'] = $this->get_subject_data($timetable_id,$subject_id);
        $data['view_file'] = 'subject_edit';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_subject_edit() {
        $timetable_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['start_time'] = $this->input->post('start_time');
        $data['end_time'] = $this->input->post('end_time');
        $check = $this->update_subject($subject_id,$timetable_id,$data);
        
        if($check == 1){
            $this->session->set_flashdata('message', 'timetable'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'timetable/subjects/'. $timetable_id);
        }
        else{
            $this->session->set_flashdata('message', 'timetable'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'timetable/subjects/'. $timetable_id);
        }
    }

    function get_subject(){
        $section_id = $this->input->post('id');
        if(isset($section_id) && !empty($section_id)){
            $stdData = explode(",",$section_id);
            $section_id = $stdData[0];
        }
        $arr_subject = Modules::run('subjects/_get_subject_section',$section_id)->result_array();
        $html='';
        $html.='<h3>Subjects</h3>';
        foreach ($arr_subject as $key => $value) {
            $html.='<div class="col-md-4">';
            $html.='Subject Name';
            $html.='<input class="form-control" readonly type="name" name="subject_name[]" value='.$value['id'].','.$value['name'].'>';
            $html.='</div>';
            $html.='<div class="col-md-3">';
            $html.='Start Time';
            $html.='<input class="form-control" type="time" name="start_time[]">';
            $html.='</div>';
            $html.='<div class="col-md-3">';
            $html.='End Time';
            $html.='<input class="form-control" type="time" name="end_time[]">';
            $html.='</div>';
        }
        $html.='<div class="col-md-4">';
        $html.='Break';
        $html.='<input class="form-control" readonly type="name" name="break" value="Break">';
        $html.='</div>';
        $html.='<div class="col-md-3">';
        $html.='Start Time';
        $html.='<input class="form-control" type="time" name="break_start_time">';
        $html.='</div>';
        $html.='<div class="col-md-3">';
        $html.='End Time';
        $html.='<input class="form-control" type="time" name="break_end_time">';
        $html.='</div>';

        print_r($html);
    }

    function check_day () {
        $day = $this->input->post('day');
        $section_id = $this->input->post('section_id');
        if(isset($section_id) && !empty($section_id)){
            $stdData = explode(",",$section_id);
            $section_id = $stdData[0];
        }
        $this->load->model('mdl_timetable');
        $check = $this->mdl_timetable->check_day($day,$section_id);
        if($check->num_rows()!=0){
            echo "1";
        }
        else{
            echo "0";
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
        redirect(ADMIN_BASE_URL . 'timetable/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'timetable/manage/' . '');
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
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_getItemById($id);
    }


    function _set_publish($arr_col) {
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_set_unpublish($arr_col);
    }

    function _get($program_id,$class_id,$section_id) {
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get($program_id,$class_id,$section_id);
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_by_arr_id($update_id);
    }


    function _insert_timetable_subject($data_timetable) {
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_insert_timetable_subject($data_timetable);
    }

    function _insert_timetable($data_timetable){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_insert_timetable($data_timetable);
    }

    function update_subject($subject_id,$timetable_id,$data){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->update_subject($subject_id,$timetable_id,$data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_delete($arr_col, $org_id);
    }

    function _get_subject_by_arr_id($update_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_subject_by_arr_id($update_id);
    }
    function _get_parent_by_arr_id($update_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_parent_by_arr_id($update_id);
    }

    function _get_by_arr_id_section($section_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_by_arr_id_section($section_id);
    }

    function _get_timetable_subject($timetable_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_timetable_subject($timetable_id);
    }

    function _get_subject_data($timetable_id,$subject_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_subject_data($timetable_id,$subject_id);
    }

    function _no_of_days($class_id,$section_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_no_of_days($class_id,$section_id);
    }

    function _notif_insert_data($data2){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_notif_insert_data($data2);
    }

    function _get_parent_id_for_notification($where,$org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_parent_id_for_notification($where,$org_id);
    }

    function _get_teacher_id_for_notification($where,$org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_teacher_id_for_notification($where,$org_id);
    }

    function _get_teacher_token($teacher_id,$org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_teacher_token($teacher_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_parent_token($parent_id,$org_id);
    }

    function _get_timetable_print_voucher($timetable_id,$org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_timetable_print_voucher($timetable_id,$org_id);
    }

    function _get_org_print_voucher($org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_org_print_voucher($org_id);
    }
}
?>