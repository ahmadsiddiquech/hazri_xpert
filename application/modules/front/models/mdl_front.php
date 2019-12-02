<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_front extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function _get_institutes(){
        $table = 'users';
        $this->db->select('id instId, org_name instName');
        $this->db->where('status', '1');
        $this->db->where('role_id','2');
        return $this->db->get($table);
    }

    function _get_all_classes($org_id){
        $table = 'classes';
        $this->db->select('id classId,name className');
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _get_all_sections($class_id,$org_id){
        $table = 'sections';
        $this->db->select('id sectionId,section sectionName');
        $this->db->where('org_id',$org_id);
        $this->db->where('class_id',$class_id);
        return $this->db->get($table);
    }

    function _get_user_login($inst_id, $username, $password){
        $table = 'users_add';
        $this->db->select('id userId, name userName, designation, org_id orgId,phone');
        $this->db->where('org_id',$inst_id);
        $this->db->where('phone', $username);
        $this->db->where('password', $password);
        $this->db->where('status', '1');
        return $this->db->get($table);
    }

    function _check_session($user_id,$username,$inst_id){
        $table = 'users_sessions';
        $this->db->select('*');
        $this->db->where('org_id',$inst_id);
        $this->db->where('username', $username);
        $this->db->where('user_id', $user_id);
        $this->db->where('login_status', '1');
        return $this->db->get($table);
    }

    function _create_session($data){
        $table = "users_sessions";
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _logout($currentDateTime,$user_id,$username,$inst_id){
        $table = "users_sessions";
        $this->db->where('username', $username);
        $this->db->where('user_id', $user_id);
        $this->db->where('org_id', $inst_id);
        $this->db->where('login_status', 1);
        $this->db->set('login_status' , 0);
        $this->db->set('logout_date_time' , $currentDateTime);
        $this->db->update($table);
        $affected_rows = $this->db->affected_rows();

        $table2 = "users_add";
        $this->db->where('id', $user_id);
        $this->db->where('org_id', $inst_id);
        $this->db->set('fcm_token' , '');
        $this->db->update($table2);
        return $affected_rows;
    }

    function _get_teacher_subject_list($teacher_id, $org_id, $page_no, $limit){
        $table = 'subject';
        $this->db->select('id subId, name subName,s_type subjectType, section_id, program_id, class_id, time');
        $this->db->where('org_id', $org_id);
        $this->db->where('status', '1');
        $this->db->limit($limit, $limit*($page_no-1));
        $this->db->where('teacher_id', $teacher_id);
        $this->db->order_by('id', 'DESC');
        $query['all_data'] = $this->db->get($table)->result_array();

        $table = 'subject';
        $this->db->where('org_id', $org_id);
        $this->db->where('status', '1');
        $this->db->where('teacher_id', $teacher_id);
        $query['count_data'] = $this->db->get($table)->num_rows();

        return $query;
    }

    function _get_teacher_sections($section_id, $class_id,$org_id){
        $table = 'sections';
        $this->db->select('section sectionName,id,teacher_id');
        $this->db->where('org_id', $org_id);
        $this->db->where('id', $section_id);
        $this->db->where('class_id', $class_id);
        return $this->db->get($table);
    }

    function _get_student_list($section_id,$org_id, $subject_id, $subject_type){
        $table = 'student';
        $this->db->select('id stdId, roll_no stdRollNo, name stdName,image,gender');
        if($subject_type == 'Optional'){
            $this->db->where('subject_id', $subject_id);
        }
        $this->db->where('status', '1');
        $this->db->where('section_id', $section_id);
        $this->db->where('org_id', $org_id);
        $this->db->order_by('roll_no asc');
        return $this->db->get($table);
    }

    function _get_total_num_of_stds($subject_type,$subject_id,$section_id,$class_id,$org_id){
        $table = 'student';
        $this->db->select('id programId, name programName');
        $this->db->where('status', '1');
        $this->db->where('org_id', $org_id);
        $this->db->where('section_id', $section_id);
        $this->db->where('class_id', $class_id);
        if($subject_type == "Optional"){
            $this->db->where('subject_id', $subject_id);
        }
        return $this->db->get($table);
    }
    function _get_teacher_classes($class_id,$org_id){
        $table = 'classes';
        $this->db->select('name className,id');
        $this->db->where('status', '1');
        $this->db->where('org_id', $org_id);
        $this->db->where('id', $class_id);
        return $this->db->get($table);
    }

    function _change_leave_status($status,$leave_id,$org_id){
        $table = "leave";
        $this->db->where('id', $leave_id);
        $this->db->where('org_id', $org_id);
        $this->db->set('status' , $status);
        $this->db->update($table);
        return $this->db->affected_rows();
    }

    function _get_announcement_list($org_id, $page_no, $limit){
        $table = 'announcement';
        $this->db->select('id ancmntId,title,image,start_date startDate,end_date endDate,description');
        $this->db->where('status', '1');
        $this->db->order_by('id desc');
        $this->db->limit($limit, $limit*($page_no-1));
        $this->db->where('org_id', $org_id);
        $query['limit_data'] = $this->db->get($table)->result_array();

        $table = 'announcement';
        $this->db->where('status', '1');
        $this->db->order_by('id desc');
        $this->db->where('org_id', $org_id);
        $query['count_data'] = $this->db->get($table)->num_rows();
        return $query;
    }

    function _get_announcement_detail($ancmntId,$org_id){
        $table = 'announcement';
        $this->db->select('title,image,start_date startDate,end_date endDate,description');
        $this->db->where('status', '1');
        $this->db->where('id', $ancmntId);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_children_list($parent_id,$org_id){
        $table = 'student';
        $this->db->select('id stdId,name stdName,roll_no stdRollNo,class_id,section_id,image,gender');
        $this->db->where('status', '1');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('org_id', $org_id);
        $this->db->order_by('id', $org_id);
        return $this->db->get($table);
    }

    function _get_teacher_name($teacher_id,$org_id){
        $table = 'users_add';
        $this->db->select('name teacher_name,id');
        $this->db->where('status', '1');
        $this->db->where('id', $teacher_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_student($std_id,$org_id){
        $table = 'student';
        $this->db->select('id stdId,name stdName,roll_no stdRollNo,image,gender');
        $this->db->where('id', $std_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function get_student_result($exam_id,$org_id){
        $table = 'exam_subject';
        $this->db->select('*');
        $this->db->where('exam_id', $exam_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_student_result_detail($std_id,$exam_subject_id,$exam_id){
        $table = 'exam_marks';
        $this->db->where('exam_id', $exam_id);
        $this->db->where('exam_subject_id', $exam_subject_id);
        $this->db->where('std_id', $std_id);
        return $this->db->get($table);
    }

    function _insert_attend_data($data){
        $table = "attend_record";
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_student_attend_data($data){
        $table = "take_attendance";
        $this->db->insert($table, $data);
        return $this->db->affected_rows();
    }

    function _submit_test_marks($data){
        $table = "test_marks";
        $this->db->insert($table, $data);
        return $this->db->affected_rows();
    }

    function _get_subject_detail($subject_id,$org_id){
        $table = "subject";
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->where('id', $subject_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_attendance_id($subject_id,$org_id){
        $table = "attend_record";
        $this->db->select('*');
        $this->db->where('subject_id', $subject_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_attendance_list($attend_id, $date){
        $table = "take_attendance";
        $this->db->select('*');
        $this->db->where('attend_id', $attend_id);
        $this->db->where('attend_date', $date);
        $this->db->order_by('id', 'DESC');
        return $this->db->get($table);
    }

    function _get_attendance_record($attend_id,$attend_date,$org_id, $subject_id){
        $table = "attend_record";
        $this->db->select('*');
        $this->db->where('attend_id', $attend_id);
        $this->db->where('subject_id', $subject_id);
        $this->db->where('attend_date', $attend_date);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_student_attendance_detail($org_id, $subject_id){
        $table = "attend_record";
        $this->db->select('*');
        $this->db->where('org_id', $org_id);
        if($subject_id!=null)
        {
            $this->db->where('subject_id', $subject_id);
        }
        return $this->db->get($table);
    }

    function _get_student_attendance_record($std_id,$roll_no, $attend_id, $attend_date){
        $table = "take_attendance";
        $this->db->select('*');
        if($attend_id!=null && $attend_date!=null){
            $this->db->where('attend_id', $attend_id);
            $this->db->where('attend_date', $attend_date);
        }
        $this->db->where('student_id', $std_id);
        $this->db->where('roll_no', $roll_no);
        $this->db->order_by('attend_date', 'DESC');
        return $this->db->get($table);
    }

    function _get_overall_student_attendence($roll_no,$std_id){
        $table = "take_attendance";
        $this->db->select('attend_status');
        $this->db->where('roll_no', $roll_no);
        $this->db->where('student_id', $std_id);
        return $this->db->get($table);
    }

    function _insert_apply_leave($data){
        $table = "leave";
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_submit_test($data){
        $table = "test";
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _edit_test_marks($test_id, $std_id, $data){
        $table = "test_marks";
        $this->db->where('test_id', $test_id);
        $this->db->where('std_id', $std_id);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    function _edit_test_detail($test_id, $org_id, $data){
        $table = "test";
        $this->db->where('id', $test_id);
        $this->db->where('org_id', $org_id);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    function _check_test_submission($test_id,$org_id){
        $table = "test_marks";
        $this->db->where('test_id', $test_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table)->num_rows();
    }

    function _get_test_list($where,$org_id){
        $table = "test";
        $this->db->select('id testId,test_title testTitle,test_description testDescription,program_id programId,class_id classId,class_name className,section_id sectionId,section_name sectionName,subject_id subjectId,subject_name subjectName,test_date testDate,test_time testTime,teacher_id teacherId,teacher_name teacherName, total_marks totalMarks');
        $this->db->where($where);
        $this->db->where('org_id', $org_id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get($table);
    }

    function _get_exam_list($where,$org_id){
        $table = "exam";
        $this->db->select('id examId,exam_title examTitle,exam_description examDescription,class_id classId,class_name className,program_id programId,program_name programName,start_date startDate,end_date endDate');
        $this->db->where($where);
        $this->db->where('org_id', $org_id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get($table);
    }

    function _get_teacher_class_list($where,$org_id){
        $this->db->select('classes.id classId, classes.name className,program.id programId,program.name programName,sections.id sectionId,sections.section sectionName');
        $this->db->from('subject');
        $this->db->join("classes", "subject.class_id = classes.id and subject.program_id = classes.program_id", "full");
        $this->db->join("sections", "sections.id = subject.section_id", "full");
        $this->db->join("exam", "subject.class_id = exam.class_id", "full");
        $this->db->join("program", "program.id= subject.program_id", "full");
        $this->db->where($where);
        $this->db->where('subject.org_id', $org_id);
        return $this->db->get();
    }

    function _get_teacher_exam_student_list($class_id,$program_id,$org_id){
        $table = "student";
        $this->db->where('class_id',$class_id);
        $this->db->where('program_id',$program_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_test_marks($test_id,$org_id){
        $table = "test_marks";
        $this->db->select('*');
        $this->db->where('test_id',$test_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_exam_marks($exam_id,$org_id){
        $table = "exam_marks";
        $this->db->select('*');
        $this->db->where('exam_id',$exam_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_test_marks_parent($test_id,$std_id,$org_id){
        $table = "test_marks";
        $this->db->select('*');
        $this->db->where('test_id',$test_id);
        $this->db->where('std_id',$std_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_exam_marks_parent($exam_id,$std_id,$org_id){
        $table = "exam_marks";
        $this->db->select('*');
        $this->db->where('exam_id',$exam_id);
        $this->db->where('std_id',$std_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _leave_teacher_section($org_id, $user_id){
        $table = "subject";
        $this->db->select('section_id');
        $this->db->where('teacher_id',$user_id);
        $this->db->where('org_id', $org_id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get($table);
    }

    function _leave_teacher_list($section_id,$org_id){
        $table = "leave";
        $this->db->select('*');
        $this->db->where('section_id',$section_id);
        $this->db->where('org_id', $org_id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get($table);
    }

    function _get_leave_history($org_id, $user_id, $page_no, $limit){
        $table = "leave";
        $this->db->select('*');
        $this->db->where('org_id', $org_id);
        $this->db->where('parent_id', $user_id);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $limit*($page_no-1));
        $query['all_data'] = $this->db->get($table)->result_array();

        $table = "leave";
        $this->db->where('org_id', $org_id);
        $this->db->where('parent_id', $user_id);
        $query['count_data'] = $this->db->get($table)->num_rows();
        return $query;
    }

    function _get_std_data($std_id,$std_roll_no,$org_id){
        $table = "student";
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->where('org_id', $org_id);
        $this->db->where('roll_no', $std_roll_no);
        $this->db->where('id', $std_id);
        return $this->db->get($table);
    }

    function _get_promotion_banner(){
        $table = 'banner';
        $this->db->where('status', '1');
        return $this->db->get($table);
    }
    
    function _get_leave_detail($leave_id,$org_id){
        $table = "leave";
        $this->db->select('*');
        $this->db->where('org_id', $org_id);
        $this->db->where('id', $leave_id);
        return $this->db->get($table);
    }

    function _get_user_profile($user_id,$org_id){
        $table = "users_add";
        $this->db->select('*');
        $this->db->where('status', '1');
        $this->db->where('org_id', $org_id);
        $this->db->where('id', $user_id);
        return $this->db->get($table);
    }

    function _get_org($org_id){
        $table = "users";
        $this->db->where('status', '1');
        $this->db->select('id,org_name orgName,org_address orgAddress,org_phone,org_email');
        $this->db->where('id', $org_id);
        return $this->db->get($table);
    }

    function _student_subject_teacher($std_id,$org_id){
        $this->db->select('student.subject_id subject_id,subject.time time, subject.name subject_name,subject.teacher_id, users_add.id teacher_id, users_add.name teacher_name');
        $this->db->from('student');
        $this->db->join("subject", "student.subject_id = subject.id", "full");
        $this->db->join("users_add", "subject.teacher_id= users_add.id", "full");
        $this->db->where('student.id', $std_id);
        $this->db->where('student.org_id', $org_id);
        return $this->db->get();
    }

    function _student_subject_teacher_list($section_id,$org_id){
        $this->db->select('subject.id subject_id,subject.name subject_name,subject.teacher_id,users_add.id teacher_id,users_add.name teacher_name,subject.time time');
        $this->db->from('subject');
        $this->db->join("users_add", "users_add.id=subject.teacher_id", "full");
        $this->db->where('subject.section_id', $section_id);
        $this->db->where('s_type', 'Mandatory');
        $this->db->where('subject.org_id', $org_id);
        return $this->db->get();
    }

    function _check_attendance($attend_date,$subject_id,$org_id){
        $table = "attend_record";
        $this->db->select('*');
        $this->db->where('org_id', $org_id);
        $this->db->where('attend_date', $attend_date);
        $this->db->where('subject_id', $subject_id);
        return $this->db->get($table);
    }

    function _get_program_from_section($class_id,$section_id,$org_id){
        $this->db->select('program.id program_id,program.name program_name');
        $this->db->from('sections');
        $this->db->join("program", "sections.program_id = program.id", "full");
        $this->db->where('sections.org_id', $org_id);
        $this->db->where('sections.class_id', $class_id);
        $this->db->where('sections.id', $section_id);
        return $this->db->get();
    }

    function _login_validation($user_id,$username,$imei,$org_id){
        $table = 'users_sessions';
        $this->db->select('*');
        $this->db->where('login_status', '1');
        $this->db->where('imei', $imei);
        $this->db->where('username', $username);
        $this->db->where('user_id', $user_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_timetable_record($section_id,$class_id,$org_id){
        $table = 'timetable_record';
        $this->db->select('*');
        $this->db->where('section_id', $section_id);
        $this->db->where('class_id', $class_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_timetable_data($id){
        $table = 'timetable_data';
        $this->db->select('*');
        $this->db->where('timetable_id', $id);
        $this->db->order_by('start_time','ASC');
        return $this->db->get($table);
    }

    function _get_datesheet_record($class_id,$org_id){
        $table = 'datesheet_record';
        $this->db->select('DATE_FORMAT(start_date, "%d-%m-%Y") as s_date,DATE_FORMAT(end_date, "%d-%m-%Y") as e_date, datesheet_record.*', FALSE);
        $this->db->where('class_id', $class_id);
        $this->db->where('org_id', $org_id);
        return $this->db->get($table);
    }

    function _get_datasheet_data($id){
        $table = 'datesheet_data';
        $this->db->select('DATE_FORMAT(exam_date, "%d-%m-%Y") as date, datesheet_data.*', FALSE);
        $this->db->where('datesheet_id', $id);
        $this->db->order_by('exam_date','ASC');
        return $this->db->get($table);
    }

    function _insert_feedback($data){
        $table = "feedback";
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _insert_feedback_reply($data){
        $table = "feedback_reply";
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function _get_parent_by_std_id($std_id){
        $this->db->select('users_add.id parent_id,users_add.name parent_name');
        $this->db->from('student');
        $this->db->join("users_add", "student.parent_id = users_add.id", "full");
        $this->db->where('student.id',$std_id);
        return $this->db->get();
    }

    function _get_feedback_list($user_id,$user_type,$org_id ,$page_no, $limit){
        $table = "feedback";
        if ($user_type == 'Parent') {
            $this->db->where('parent_id',$user_id);
        }
        elseif ($user_type == 'Teacher') {
            $this->db->where('teacher_id',$user_id);
        }
        $this->db->where('org_id',$org_id);
        $this->db->order_by('id','DESC');
        if(!empty($limit) && !empty($page_no)){
            $this->db->limit($limit, $limit*($page_no-1));
        }
        $query['all_data']=$this->db->get($table)->result_array();


        $table = 'feedback';
        if ($user_type == 'Parent') {
            $this->db->where('parent_id',$user_id);
        }
        elseif ($user_type == 'Teacher') {
            $this->db->where('teacher_id',$user_id);
        }
        $query['count_data'] = $this->db->get($table)->num_rows();
        return $query;
    }

    function _get_feedback_detail($f_id,$page_no, $limit){
        $table = 'feedback_reply';
        $this->db->where('f_id',$f_id);
        $this->db->order_by('id','DESC');
        if(!empty($limit) && !empty($page_no)){
            $this->db->limit($limit, $limit*($page_no-1));
        }
        $query['all_data'] = $this->db->get($table)->result_array();

        $table = 'feedback_reply';
        $this->db->where('f_id',$f_id);
        $query['count_data'] = $this->db->get($table)->num_rows();
        return $query;
    }


// ========================================================= //
// =============== Notification functions ================== //
// ========================================================= //


    function _count_unread_notification($user_id,$org_id){
        $table = 'notification';
        $this->db->where('user_id',$user_id);
        $this->db->where('org_id',$org_id);
        $this->db->where('notif_status','unread');
        return $this->db->get($table);
    }

    function _change_notification_status($notif_id,$org_id){
        $table = 'notification';
        $this->db->where('notif_id', $notif_id);
        $this->db->where('org_id', $org_id);
        $this->db->set('notif_status' , 'read');
        $this->db->update($table);
        return $this->db->affected_rows();
    }

    function _notif_get_list($where1,$where2,$page_no,$limit){
        $table = 'notification';
        $this->db->where($where1);
        $this->db->where($where2);
        $this->db->order_by('notif_id desc');
        if (isset($page_no) && !empty($page_no)) {
            $this->db->limit($limit, $limit*($page_no-1));
        }
        $query['limit_data'] = $this->db->get($table)->result_array();

        $table = 'notification';
        $this->db->where($where1);
        $this->db->where($where2);
        $this->db->order_by('notif_id desc');
        $query['count_data'] = $this->db->get($table)->num_rows();
        return $query;
    }

    function _notif_insert_data($data){
        $table = 'notification';
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    function _get_teacher_token($teacher_id,$org_id){
        $table = 'users_add';
        $this->db->select('fcm_token');
        $this->db->where('org_id',$org_id);
        $this->db->where('id',$teacher_id);
        $this->db->where('designation','Teacher');
        return $this->db->get($table);
    }

    function _get_teacher_id_for_notification($where,$org_id){
        $table = 'subject';
        $this->db->where('org_id',$org_id);
        $this->db->where($where);
        return $this->db->get($table);
    }

    function _get_parent_id_for_notification($where,$org_id){
        $table = 'student';
        $this->db->where('org_id',$org_id);
        $this->db->where($where);
        return $this->db->get($table);
    }

    function _notif_get_test_detail($test_id){
        $table = 'test';
        $this->db->where('id',$test_id);
        return $this->db->get($table);
    }

    function _notif_get_child_detail($std_id){
        $table = 'student';
        $this->db->where('id',$std_id);
        return $this->db->get($table);
    }

    function _update_fcm_token($user_id,$fcm_token,$org_id){
        $table = "users_add";
        $this->db->where('id', $user_id);
        $this->db->where('org_id', $org_id);
        $this->db->set('fcm_token' , $fcm_token);
        $this->db->update($table);
        return $this->db->affected_rows();
    }

    function _get_parent_token($parent_id,$org_id){
        $table = 'users_add';
        $this->db->select('fcm_token');
        $this->db->where('org_id',$org_id);
        $this->db->where('id',$parent_id);
        $this->db->where('designation','Parent');
        return $this->db->get($table);
    }
//=====================================================================================
//==============================FEE VOUCHER FUNCTIONS==================================
//=====================================================================================


    function _get_fee_voucher_list($class_id,$section_id,$std_id,$year,$org_id){
        $this->db->select('*');
        $this->db->from('voucher_record');
        $this->db->join("voucher_data", "voucher_record.id = voucher_data.voucher_id", "full");
        $this->db->where('voucher_data.std_id',$std_id);
        $this->db->where('voucher_record.section_id',$section_id);
        $this->db->where('voucher_record.class_id',$class_id);
        $this->db->where('voucher_record.org_id',$org_id);

        $this->db->order_by('voucher_record.id','DESC');
        $firstDate = $year.'/01/01';
        $secondDate = $year.'/12/31';
        $this->db->where('issue_date >=', $firstDate);
        $this->db->where('issue_date <=', $secondDate);

        return $this->db->get();
    }

    function _get_fee_year($class_id,$section_id,$org_id){
        $table = 'voucher_record';
        $this->db->select('issue_date');
        $this->db->where('section_id',$section_id);
        $this->db->where('class_id',$class_id);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _get_fee_voucher_list_installment($voucher_id,$std_voucher_id){
        $table = 'installment';
        $this->db->where('std_voucher_id',$std_voucher_id);
        $this->db->where('voucher_id',$voucher_id);
        return $this->db->get($table);
    }

    function _get_std_fee_voucher($voucher_id,$std_voucher_id,$org_id){
        $this->db->select('*');
        $this->db->from('voucher_record');
        $this->db->join("voucher_data", "voucher_record.id = voucher_data.voucher_id", "full");
        $this->db->where('voucher_data.id',$std_voucher_id);
        $this->db->where('voucher_record.id',$voucher_id);
        $this->db->where('voucher_record.org_id',$org_id);
        return $this->db->get();
    }

    function _get_std_fee_voucher_installment($voucher_id,$std_voucher_id,$org_id){
        $this->db->select('*');
        $this->db->from('voucher_record');
        $this->db->join("voucher_data", "voucher_record.id = voucher_data.voucher_id", "full");
        $this->db->join("installment", "installment.std_voucher_id = voucher_data.id", "full");
        $this->db->where('installment.id',$std_voucher_id);
        $this->db->where('voucher_record.id',$voucher_id);
        $this->db->where('voucher_record.org_id',$org_id);
        return $this->db->get();
    }

    // function _pay_std_fee_voucher($amount,$date,$std_voucher_id){
    //     $table = "voucher_data";
    //     $this->db->where('id', $std_voucher_id);
    //     $this->db->set('paid' , $amount);
    //     $this->db->set('pay_date' , $date);
    //     $this->db->set('status' , '1');
    //     $this->db->update($table);
    //     return $this->db->affected_rows();
    // }

}
?>