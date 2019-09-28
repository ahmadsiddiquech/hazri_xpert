<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Timetable extends MX_Controller
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
        $data['news'] = $this->_get('timetable_record.class_id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function create() {
        $update_id = $this->uri->segment(4);
        // print_r($update_id);exit();
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
        $exam_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $total = $this->_get_exam_subject_total($exam_id,$subject_id)->result_array();
        if (isset($total) && !empty($total)) {
            foreach ($total as $key => $value) {
                $total_marks = $value['total_marks'];
            }
        }
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $student_list = $this->_get_subject_student_list($subject_id,$org_id)->result_array();
        foreach ($student_list as $key => $value) {
            $finalData['std_id'] = $value['std_id'];
            $finalData['roll_no'] = $value['roll_no'];
            $finalData['name'] = $value['name'];
            $finalData['exam_id'] = $exam_id;
            $finalData['subject_id'] = $subject_id;
            $finalData['total_marks'] = $total_marks;

        $obtained_marks = $this->get_obtained_marks($value['std_id'],$subject_id,$exam_id,$org_id)->result_array();
        
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
        // print_r($obtained_marks);exit();
        $data['student_list'] = $finalData2;
        $data['view_file'] = 'marks';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function subjects() {
        $timetable_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        
        $finalData2 = $this->_get_timetable_subject($timetable_id)->result_array();
        // print_r($finalData2);exit();

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
        // print_r($query);exit();
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
                $data2['notif_title'] = $data['class_name'];
                $data2['notif_description'] = 'Admin updated this timetable for section '.$data['section_name'];
                $data2['notif_type'] = 'timetable';
                $data2['type_id'] = $update_id;
                $data2['section_id'] = $data['section_id'];
                $data2['class_id'] = $data['class_id'];
                $data2['program_id'] = $data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $data['org_id'];
                $this->_notif_insert_data_teacher($data2);
                $this->_notif_insert_data_parent($data2);

                $where['section_id'] = $data2['section_id'];
                $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();
                if (isset($teacher_id) && !empty($teacher_id)) {
                    foreach ($teacher_id as $key => $value) {
                        $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                        Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
                    }  
                }

                $where1['section_id'] = $data2['section_id'];
                $parent_id = $this->_get_parent_for_push_noti($where1,$data2['org_id'])->result_array();
                if (isset($parent_id) && !empty($parent_id)) {
                    foreach ($parent_id as $key => $value) {
                        $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                       Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
                    }   
                }
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

                $data2['notif_title'] = $data['class_name'];
                $data2['notif_description'] = 'Timetable added for section '.$data['section_name'];
                $data2['notif_type'] = 'timetable';
                $data2['type_id'] = $timetable_id;
                $data2['section_id'] = $data['section_id'];
                $data2['class_id'] = $data['class_id'];
                $data2['program_id'] = $data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $data['org_id'];
                $this->_notif_insert_data_teacher($data2);
                $this->_notif_insert_data_parent($data2);

                $where['section_id'] = $data2['section_id'];
                $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();
                if (isset($teacher_id) && !empty($teacher_id)) {
                    foreach ($teacher_id as $key => $value) {
                        $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                        Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
                    }  
                }

                $where1['section_id'] = $data2['section_id'];
                $parent_id = $this->_get_parent_for_push_noti($where1,$data2['org_id'])->result_array();
                if (isset($parent_id) && !empty($parent_id)) {
                    foreach ($parent_id as $key => $value) {
                        $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                       Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
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
                // print_r($data);exit();
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

    function adding_exam_subject_marks($roll_no, $std_id, $name, $obtained_marks,$exam_id,$subject_id, $org_id){
         $counter=0;
            foreach ($roll_no as $key => $value) {
            $data = array();
            unset($data); 
            $data = array();
            $data['std_roll_no']=$roll_no[$counter];
            $data['std_id']=$std_id[$counter];
            $data['std_name']=$name[$counter];
            $data['obtained_marks']=$obtained_marks[$counter];
            $data['org_id']=$org_id;
            $data['exam_id']=$exam_id;
            $data['exam_subject_id']=$subject_id;

            if(!empty($value)){
                // $data['day']=$value;
                $this->_insert_exam_subject_marks($data);
            }
            $counter++; 
        }
    }

    function submit_marks() {
        // print_r($this->input->post('roll_no'));exit();
        $exam_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        // print_r($exam_id);exit();
        $user_data = $this->session->userdata('user_data');
        $roll_no = $this->input->post('roll_no');
        $std_id = $this->input->post('std_id');
        $name = $this->input->post('std_name');
        $obtained_marks = $this->input->post('obtained_marks');
        $this->adding_exam_subject_marks($roll_no, $std_id, $name, $obtained_marks,$exam_id,$subject_id,$user_data['user_id']);

        $notif_data = $this->_get_data_from_db($exam_id);
        $data2['notif_title'] = $notif_data['class_name'];
        $data2['notif_description'] = 'Timetable has been updated for section '.$notif_data['section_name'];
        $data2['notif_type'] = 'timetable';
        $data2['notif_sub_type'] = 'update';
        $data2['type_id'] = $notif_data['timetable_id'];
        $data2['section_id'] = $notif_data['section_id'];
        $data2['class_id'] = $notif_data['class_id'];
        $data2['program_id'] = $notif_data['program_id'];
        date_default_timezone_set("Asia/Karachi");
        $data2['notif_date'] = date('Y-m-d H:i:s');
        $data2['org_id'] = $notif_data['org_id'];
        $this->_notif_insert_data_teacher($data2);
        $this->_notif_insert_data_parent($data2);

        $where['section_id'] = $data2['section_id'];
        $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();
        if (isset($teacher_id) && !empty($teacher_id)) {
            foreach ($teacher_id as $key => $value) {
                $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
            }  
        }

        $where1['section_id'] = $data2['section_id'];
        $parent_id = $this->_get_parent_for_push_noti($where1,$data2['org_id'])->result_array();
        if (isset($parent_id) && !empty($parent_id)) {
            foreach ($parent_id as $key => $value) {
                $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
               Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
            }   
        }
        
        
        $this->session->set_flashdata('message', 'timetable'.' '.DATA_SAVED);
        $this->session->set_flashdata('status', 'success');
        
        redirect(ADMIN_BASE_URL . 'timetable/subjects/'.$timetable_id);
    }

    function subject_edit() {
        // print_r($this->input->post('roll_no'));exit();
        $timetable_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        // print_r($exam_id);exit();
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
        // print_r($data);exit();
        $check = $this->update_subject($subject_id,$timetable_id,$data);

        $notif_data = $this->_get_data_from_db($timetable_id);
        // print_r($notif_data);exit();
        $data2['notif_title'] = $notif_data['class_name'];
        $data2['notif_description'] = 'Admin Edited The Subjects of Timetable for section '.$notif_data['section_name'];
        $data2['notif_type'] = 'timetable';
        $data2['type_id'] = $timetable_id;
        $data2['section_id'] = $notif_data['section_id'];
        $data2['class_id'] = $notif_data['class_id'];
        $data2['program_id'] = $notif_data['program_id'];
        date_default_timezone_set("Asia/Karachi");
        $data2['notif_date'] = date('Y-m-d H:i:s');
        $data2['org_id'] = $notif_data['org_id'];
        $this->_notif_insert_data_teacher($data2);
        $this->_notif_insert_data_parent($data2);

        $where['section_id'] = $data2['section_id'];
        $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();
        if (isset($teacher_id) && !empty($teacher_id)) {
            foreach ($teacher_id as $key => $value) {
                $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
            }  
        }

        $where1['section_id'] = $data2['section_id'];
        $parent_id = $this->_get_parent_for_push_noti($where1,$data2['org_id'])->result_array();
        if (isset($parent_id) && !empty($parent_id)) {
            foreach ($parent_id as $key => $value) {
                $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
               Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
            }   
        }

        if($check == true){
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
        // print_r($check);exit();
        if($check->num_rows()!=0){
            echo "1";
        }
        else{
            echo "0";
        }
    }

    function update_marks () {
        $std_id = $this->input->post('std_id');
        $std_name = $this->input->post('std_name');
        $roll_no = $this->input->post('roll_no');
        $exam_id = $this->input->post('exam_id');
        $sbj_id = $this->input->post('sbj_id');
        // print_r($sbj_id);exit();
        $obtained_marks = $this->input->post('obt_mark');
        $this->load->model('mdl_exam');
        $check = $this->mdl_exam->update_marks($sbj_id,$std_id,$roll_no,$exam_id,$obtained_marks);

        $notif_data = $this->_get_data_from_db($exam_id);
        $data2['notif_title'] = $notif_data['exam_title'];
        $data2['notif_description'] = 'Marks of '.$std_name.' for this exam are '.$obtained_marks.' (updated)';
        $data2['notif_type'] = 'exam';
        $data2['type_id'] = $notif_data['exam_id'];
        $data2['class_id'] = $notif_data['class_id'];
        $data2['program_id'] = $notif_data['program_id'];
        date_default_timezone_set("Asia/Karachi");
        $data2['notif_date'] = date('Y-m-d H:i:s');
        $data2['org_id'] = $notif_data['org_id'];
        $this->_notif_insert_data_teacher($data2);
        $data2['std_id'] = $std_id;
        $data2['std_name'] = $std_name;
        $data2['std_roll_no'] = $roll_no;
        $data2['notif_sub_type'] = 'update';
        $this->_notif_insert_data_parent($data2);

        $where['class_id'] = $data2['class_id'];
        $teacher_id = $this->_get_teacher_for_push_noti($where,$data2['org_id'])->result_array();
        if (isset($teacher_id) && !empty($teacher_id)) {
            foreach ($teacher_id as $key => $value) {
                $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
            }  
        }

        $where1['id'] = $data2['std_id'];
        $parent_id = $this->_get_parent_for_push_noti($where1,$data2['org_id'])->result_array();
        if (isset($parent_id) && !empty($parent_id)) {
            foreach ($parent_id as $key => $value) {
                $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
               Modules::run('front/send_notification',$token,$data2['notif_title'],$data2['notif_description']);
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
        //$lang_id = $this->uri->segment(5);
        $where['id'] = $update_id;
        //$where['lang_id'] = $lang_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'timetable/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        //$lang_id = $this->uri->segment(5);
        $where['id'] = $update_id;
        //$where['lang_id'] = $lang_id;
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
       // $lang_id = $this->input->post('lang_id');
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

    function _get($order_by) {
        $this->load->model('mdl_timetable');
        $query = $this->mdl_timetable->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_by_arr_id($update_id);
    }


    function _insert_timetable_subject($data_timetable) {
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_insert_timetable_subject($data_timetable);
    }
    function _insert_exam_subject_marks($data_marks) {
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_insert_exam_subject_marks($data_marks);
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

    function _get_exam_subject_total($exam_id,$subject_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_exam_subject_total($exam_id,$subject_id);
    }

    function _get_class_student_list($update_id,$org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_class_student_list($update_id,$org_id);
    }

    function _get_subject_student_list($subject_id,$org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_subject_student_list($subject_id,$org_id);
    }

    function get_obtained_marks($std_id,$subject_id,$exam_id,$org_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->get_obtained_marks($std_id,$subject_id,$exam_id,$org_id);
    }

    function _get_class_student_marks($std_id,$exam_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_class_student_marks($std_id,$exam_id);
    }

    function _get_subject_data($timetable_id,$subject_id){
        $this->load->model('mdl_timetable');
        return $this->mdl_timetable->_get_subject_data($timetable_id,$subject_id);
    }

    function _notif_insert_data_teacher($data2){
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_notif_insert_data_teacher($data2);
    }

    function _notif_insert_data_parent($data2){
        $this->load->model('mdl_timetable');
        $this->mdl_timetable->_notif_insert_data_parent($data2);
    }

    function _get_teacher_for_push_noti($where,$org_id){
    $this->load->model('mdl_timetable');
    return $this->mdl_timetable->_get_teacher_for_push_noti($where,$org_id);
    }

    function _get_parent_for_push_noti($where,$org_id){
    $this->load->model('mdl_timetable');
    return $this->mdl_timetable->_get_parent_for_push_noti($where,$org_id);
    }

    function _get_teacher_token($teacher_id,$org_id){
    $this->load->model('mdl_timetable');
    return $this->mdl_timetable->_get_teacher_token($teacher_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
    $this->load->model('mdl_timetable');
    return $this->mdl_timetable->_get_parent_token($parent_id,$org_id);
    }
}