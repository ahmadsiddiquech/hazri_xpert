<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exam extends MX_Controller
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
        $data['news'] = $this->_get('exam.id desc');
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
        $data['student_list'] = $finalData2;
        $data['view_file'] = 'marks';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function subjects() {
        $exam_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        
        $finalData2 = $this->_get_exam_subject($exam_id)->result_array();
        $data['update_id'] = $exam_id;
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
            $data['exam_id'] = $row->exam_id;
            $data['exam_title'] = $row->exam_title;
            $data['exam_description'] = $row->exam_description;
            $data['class_name'] = $row->class_name;
            $data['subject_name'] = $row->subject_name;
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['teacher_id'] = $row->teacher_id;
            $data['teacher_name'] = $row->teacher_name;
            $data['class_id'] = $row->class_id;
            $data['subject_id'] = $row->subject_id;
            $data['total_marks'] = $row->total_marks;
            $data['exam_date'] = $row->exam_date;
            $data['exam_time'] = $row->exam_time;
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
        $data['exam_title'] = $this->input->post('exam_title');
        $data['exam_description'] = $this->input->post('exam_description');
        $data['start_date'] = $this->input->post('start_date');
        $data['end_date'] = $this->input->post('end_date');

        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;

    }

    function get_subject_data($exam_id,$subject_id,$org_id) {
        $query = $this->_get_subject_data($exam_id,$subject_id,$org_id);
        foreach ($query->result() as
                $row) {
            $data['subject_id'] = $row->subject_id;
            $data['subject_name'] = $row->subject_name;
            $data['exam_date'] = $row->exam_date;
            $data['exam_time'] = $row->exam_time;
            $data['total_marks'] = $row->total_marks;
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

                $whereClass['class_id'] = $data['class_id'];
                $parents = $this->_get_parent_id_for_notification($whereClass,$data['org_id'])->result_array();
                if (isset($parents) && !empty($parents)) {
                    foreach ($parents as $key => $value) {
                        $data2['notif_for'] = 'Parent';
                        $data2['user_id'] = $value['parent_id'];
                        $data2['std_id'] = $value['id'];
                        $data2['std_name'] = $value['name'];
                        $data2['std_roll_no'] = $value['roll_no'];
                        $data2['notif_title'] = $data['exam_title'];
                        $data2['notif_description'] = 'Admin Updated This Exam';
                        $data2['notif_type'] = 'exam';
                        $data2['notif_sub_type'] = 'exam_update';
                        $data2['type_id'] = $update_id;
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

                $teachers = $this->_get_teacher_id_for_notification($whereClass,$data['org_id'])->result_array();
                if (isset($teachers) && !empty($teachers)) {
                    foreach ($teachers as $key => $value) {
                        $data2['notif_for'] = 'Teacher';
                        $data2['user_id'] = $value['teacher_id'];
                        $data2['subject_name'] = $value['name'];
                        $data2['subject_id'] = $value['id'];
                        $data2['std_id'] = '';
                        $data2['std_name'] = '';
                        $data2['std_roll_no'] = '';
                        $data2['notif_title'] = $data['exam_title'];
                        $data2['notif_description'] = 'Admin Updated This Exam';
                        $data2['notif_type'] = 'exam';
                        $data2['notif_sub_type'] = 'exam_update';
                        $data2['type_id'] = $update_id;
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
            else {
                $exam_id = $this->_insert_exam($data);
                $subject_name = $this->input->post('subject_name');
                $exam_date = $this->input->post('exam_date');
                $exam_time = $this->input->post('exam_time');
                $total_marks = $this->input->post('total_marks');
                $this->adding_exam_subject($subject_name, $exam_date, $exam_time, $total_marks, $exam_id,$user_data['user_id']);

                $whereClass['class_id'] = $data['class_id'];
                $parents = $this->_get_parent_id_for_notification($whereClass,$data['org_id'])->result_array();
                if (isset($parents) && !empty($parents)) {
                    foreach ($parents as $key => $value) {
                        $data2['notif_for'] = 'Parent';
                        $data2['user_id'] = $value['parent_id'];
                        $data2['std_id'] = $value['id'];
                        $data2['std_name'] = $value['name'];
                        $data2['std_roll_no'] = $value['roll_no'];
                        $data2['notif_title'] = $data['exam_title'];
                        $data2['notif_description'] = $data['exam_description'];
                        $data2['notif_type'] = 'exam';
                        $data2['notif_sub_type'] = 'exam';
                        $data2['type_id'] = $exam_id;
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

                $teachers = $this->_get_teacher_id_for_notification($whereClass,$data['org_id'])->result_array();
                if (isset($teachers) && !empty($teachers)) {
                    foreach ($teachers as $key => $value) {
                        $data2['notif_for'] = 'Teacher';
                        $data2['user_id'] = $value['teacher_id'];
                        $data2['subject_name'] = $value['name'];
                        $data2['subject_id'] = $value['id'];
                        $data2['std_id'] = '';
                        $data2['std_name'] = '';
                        $data2['std_roll_no'] = '';
                        $data2['notif_title'] = $data['exam_title'];
                        $data2['notif_description'] = $data['exam_description'];
                        $data2['notif_type'] = 'exam';
                        $data2['notif_sub_type'] = 'exam';
                        $data2['type_id'] = $exam_id;
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
            $this->session->set_flashdata('message', 'exam'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'exam');
    }
    function adding_exam_subject($subject_name ,$exam_date,$exam_time,$total_marks, $exam_id,$org_id) {
        $counter=0;
        foreach ($subject_name as $key => $value) {
            $data = array();
            unset($data); 
            $data = array();
            $subject_name2=explode(',', $subject_name[$counter]);
            $data['subject_id'] = $subject_name2[0];
            $data['subject_name'] = $subject_name2[1];
            $data['exam_date']=$exam_date[$counter];
            $data['exam_time']=$exam_time[$counter];
            $data['total_marks']=$total_marks[$counter];
            $data['exam_id']=$exam_id;
            $data['org_id']=$org_id;

            $arr_teacher = Modules::run('subjects/_get_subject_teacher',$data['subject_id'],$org_id)->result_array();
            if (isset($arr_teacher) && !empty($arr_teacher)) {
                $data['teacher_id'] = $arr_teacher[0]['teacher_id'];
                $data['teacher_name'] =  $arr_teacher[0]['teacher_name'];
            }

            if(!empty($value)){
                $this->_insert_exam_subject($data);
            }
            $counter++; 
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
                $this->_insert_exam_subject_marks($data);
            }
            $counter++; 
        }
    }

    function submit_marks() {
        $exam_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $user_data = $this->session->userdata('user_data');
        $roll_no = $this->input->post('roll_no');
        $std_id = $this->input->post('std_id');
        $name = $this->input->post('std_name');
        $obtained_marks = $this->input->post('obtained_marks');
        $this->adding_exam_subject_marks($roll_no, $std_id, $name, $obtained_marks,$exam_id,$subject_id,$user_data['user_id']);

        $data = $this->_get_data_from_db($exam_id);
        $whereClass['class_id'] = $data['class_id'];
        $parents = $this->_get_parent_id_for_notification($whereClass,$data['org_id'])->result_array();
        if (isset($parents) && !empty($parents)) {
            foreach ($parents as $key => $value) {
                $data2['notif_for'] = 'Parent';
                $data2['user_id'] = $value['parent_id'];
                $data2['std_id'] = $value['id'];
                $data2['std_name'] = $value['name'];
                $data2['std_roll_no'] = $value['roll_no'];
                $data2['notif_title'] = $data['exam_title'];
                $data2['notif_description'] = 'Admin Submitted Marks of this Exam';
                $data2['notif_type'] = 'exam';
                $data2['notif_sub_type'] = 'marks';
                $data2['type_id'] = $exam_id;
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

        $teachers = $this->_get_teacher_id_for_notification($whereClass,$data['org_id'])->result_array();
        if (isset($teachers) && !empty($teachers)) {
            foreach ($teachers as $key => $value) {
                $data2['notif_for'] = 'Teacher';
                $data2['user_id'] = $value['teacher_id'];
                $data2['subject_name'] = $value['name'];
                $data2['subject_id'] = $value['id'];
                $data2['std_id'] = '';
                $data2['std_name'] = '';
                $data2['std_roll_no'] = '';
                $data2['notif_title'] = $data['exam_title'];
                $data2['notif_description'] = 'Admin Submitted Marks of this Exam';
                $data2['notif_type'] = 'exam';
                $data2['notif_sub_type'] = 'marks';
                $data2['type_id'] = $exam_id;
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
        
        $this->session->set_flashdata('message', 'exam'.' '.DATA_SAVED);
        $this->session->set_flashdata('status', 'success');
        
        redirect(ADMIN_BASE_URL . 'exam/subjects/'.$exam_id);
    }

    function subject_edit() {
        $exam_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['news'] = $this->get_subject_data($exam_id,$subject_id,$org_id);
        $data['view_file'] = 'subject_edit';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function submit_subject_edit() {
        $exam_id = $this->uri->segment(4);
        $subject_id = $this->uri->segment(5);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $data['exam_date'] = $this->input->post('exam_date');
        $data['exam_time'] = $this->input->post('exam_time');
        $data['total_marks'] = $this->input->post('total_marks');
        $check = $this->update_subject($subject_id,$exam_id,$data);

        $notif_data = $this->_get_data_from_db($exam_id);
        $whereClass['class_id'] = $notif_data['class_id'];
        $parents = $this->_get_parent_id_for_notification($whereClass,$notif_data['org_id'])->result_array();
        if (isset($parents) && !empty($parents)) {
            foreach ($parents as $key => $value) {
                $data2['notif_for'] = 'Parent';
                $data2['user_id'] = $value['parent_id'];
                $data2['std_id'] = $value['id'];
                $data2['std_name'] = $value['name'];
                $data2['std_roll_no'] = $value['roll_no'];
                $data2['notif_title'] = $notif_data['exam_title'];
                $data2['notif_description'] = 'Admin Edited the subject of this Exam';
                $data2['notif_type'] = 'exam';
                $data2['notif_sub_type'] = 'subject_update';
                $data2['type_id'] = $exam_id;
                $data2['class_id'] = $notif_data['class_id'];
                $data2['program_id'] = $notif_data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $notif_data['org_id'];
                $nid = $this->_notif_insert_data($data2);
                $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
            }
        }
        $teachers = $this->_get_teacher_id_for_notification($whereClass,$notif_data['org_id'])->result_array();
        if (isset($teachers) && !empty($teachers)) {
            foreach ($teachers as $key => $value) {
                $data2['notif_for'] = 'Teacher';
                $data2['user_id'] = $value['teacher_id'];
                $data2['subject_name'] = $value['name'];
                $data2['subject_id'] = $value['id'];
                $data2['std_id'] = '';
                $data2['std_name'] = '';
                $data2['std_roll_no'] = '';
                $data2['notif_title'] = $notif_data['exam_title'];
                $data2['notif_description'] = 'Admin Edited the subject of this Exam';
                $data2['notif_type'] = 'exam';
                $data2['notif_sub_type'] = 'subject_update';
                $data2['type_id'] = $exam_id;
                $data2['class_id'] = $notif_data['class_id'];
                $data2['program_id'] = $notif_data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $notif_data['org_id'];
                $nid = $this->_notif_insert_data($data2);
                $token = $this->_get_teacher_token($value['teacher_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
            }
        }

        if($check == true){
            $this->session->set_flashdata('message', 'exam'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'exam/subjects/'. $exam_id);
        }
        else{
            $this->session->set_flashdata('message', 'exam'.' '.DATA_SAVED);
            $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'exam/subjects/'. $exam_id);
        }
    }

    function get_subject(){
        $class_id = $this->input->post('id');
        if(isset($class_id) && !empty($class_id)){
            $stdData = explode(",",$class_id);
            $class_id = $stdData[0];
        }
        $check = $this->_check_exam_exist($class_id);
        if ($check == 0) {
            $arr_subject = Modules::run('subjects/_get_subject_class',$class_id)->result_array();
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
                $html.='Exam Time';
                $html.='<input class="form-control" type="time" name="exam_time[]">';
                $html.='</div>';
                $html.='<div class="col-md-2">';
                $html.='Total Marks';
                $html.='<input placeholder="Total Marks" class="form-control" type="number" name="total_marks[]">';
                $html.='</div>';

            }
            print_r($html);    
        }
        else{
            print_r(0);
        }
        
    }

    function check_subject () {
        $subject_id = $this->input->post('subject_id');
        $this->load->model('mdl_exam');
        $check = $this->mdl_exam->check_subject($subject_id);
        if($check->num_rows()!=0){
            echo "true";
        }
        else{
            echo "false";
        }
    }

    function update_marks () {
        $std_id = $this->input->post('std_id');
        $std_name = $this->input->post('std_name');
        $roll_no = $this->input->post('roll_no');
        $exam_id = $this->input->post('exam_id');
        $sbj_id = $this->input->post('sbj_id');
        $obtained_marks = $this->input->post('obt_mark');
        $this->load->model('mdl_exam');
        $check = $this->mdl_exam->update_marks($sbj_id,$std_id,$roll_no,$exam_id,$obtained_marks);

        $notif_data = $this->_get_data_from_db($exam_id);
        $whereStd['id'] = $std_id;
        $parents = $this->_get_parent_id_for_notification($whereStd,$notif_data['org_id'])->result_array();
        if (isset($parents) && !empty($parents)) {
            foreach ($parents as $key => $value) {
                $data2['notif_for'] = 'Parent';
                $data2['user_id'] = $value['parent_id'];
                $data2['std_id'] = $value['id'];
                $data2['std_name'] = $value['name'];
                $data2['std_roll_no'] = $value['roll_no'];
                $data2['notif_title'] = $notif_data['exam_title'];
                $data2['notif_description'] = 'Marks of '.$std_name .' for this Exam are ' . $obtained_marks .'  (updated)';
                $data2['notif_type'] = 'exam';
                $data2['notif_sub_type'] = 'marks_update';
                $data2['type_id'] = $exam_id;
                $data2['class_id'] = $notif_data['class_id'];
                $data2['program_id'] = $notif_data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $notif_data['org_id'];
                $nid = $this->_notif_insert_data($data2);
                $token = $this->_get_parent_token($value['parent_id'],$data2['org_id'])->result_array();
                Modules::run('front/send_notification',$token,$nid,$data2['notif_title'],$data2['notif_description']);
            }
        }
        $whereSbj['id'] = $sbj_id;
        $teachers = $this->_get_teacher_id_for_notification($whereSbj,$notif_data['org_id'])->result_array();
        if (isset($teachers) && !empty($teachers)) {
            foreach ($teachers as $key => $value) {
                $data2['notif_for'] = 'Teacher';
                $data2['user_id'] = $value['teacher_id'];
                $data2['subject_name'] = $value['name'];
                $data2['subject_id'] = $value['id'];
                $data2['std_id'] = '';
                $data2['std_name'] = '';
                $data2['std_roll_no'] = '';
                $data2['notif_title'] = $notif_data['exam_title'];
                $data2['notif_description'] = 'Marks of '.$std_name .' for this Exam are ' . $obtained_marks .'  (updated)';
                $data2['notif_type'] = 'exam';
                $data2['notif_sub_type'] = 'marks_update';
                $data2['type_id'] = $exam_id;
                $data2['class_id'] = $notif_data['class_id'];
                $data2['program_id'] = $notif_data['program_id'];
                date_default_timezone_set("Asia/Karachi");
                $data2['notif_date'] = date('Y-m-d H:i:s');
                $data2['org_id'] = $notif_data['org_id'];
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
        redirect(ADMIN_BASE_URL . 'exam/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'exam/manage/' . '');
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

    function _check_exam_exist($class_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_check_exam_exist($class_id);
    }

    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }
	
    function _getItemById($id) {
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_getItemById($id);
    }


    function _set_publish($arr_col) {
        $this->load->model('mdl_exam');
        $this->mdl_exam->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_exam');
        $this->mdl_exam->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_exam');
        $query = $this->mdl_exam->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_by_arr_id($update_id);
    }


    function _insert_exam_subject($data_subject) {
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_insert_exam_subject($data_subject);
    }
    function _insert_exam_subject_marks($data_marks) {
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_insert_exam_subject_marks($data_marks);
    }

    function _insert_exam($data_exam){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_insert_exam($data_exam);
    }

    function update_subject($subject_id,$exam_id,$data){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->update_subject($subject_id,$exam_id,$data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_exam');
        $this->mdl_exam->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_exam');
        $this->mdl_exam->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_exam');
        $this->mdl_exam->_delete($arr_col, $org_id);
    }

    function _get_subject_by_arr_id($update_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_subject_by_arr_id($update_id);
    }
    function _get_parent_by_arr_id($update_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_parent_by_arr_id($update_id);
    }

    function _get_by_arr_id_section($section_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_by_arr_id_section($section_id);
    }

    function _get_exam_subject($exam_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_exam_subject($exam_id);
    }

    function _get_exam_subject_total($exam_id,$subject_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_exam_subject_total($exam_id,$subject_id);
    }

    function _get_class_student_list($update_id,$org_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_class_student_list($update_id,$org_id);
    }

    function _get_subject_student_list($subject_id,$org_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_subject_student_list($subject_id,$org_id);
    }

    function get_obtained_marks($std_id,$subject_id,$exam_id,$org_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->get_obtained_marks($std_id,$subject_id,$exam_id,$org_id);
    }

    function _get_class_student_marks($std_id,$exam_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_class_student_marks($std_id,$exam_id);
    }

    function _get_subject_data($exam_id,$subject_id,$org_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_subject_data($exam_id,$subject_id,$org_id);
    }

    function _notif_insert_data($data2){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_notif_insert_data($data2);
    }

    function _get_parent_id_for_notification($where,$org_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_parent_id_for_notification($where,$org_id);
    }

    function _get_teacher_id_for_notification($where,$org_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_teacher_id_for_notification($where,$org_id);
    }

    function _get_teacher_token($teacher_id,$org_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_teacher_token($teacher_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
        $this->load->model('mdl_exam');
        return $this->mdl_exam->_get_parent_token($parent_id,$org_id);
    }
}