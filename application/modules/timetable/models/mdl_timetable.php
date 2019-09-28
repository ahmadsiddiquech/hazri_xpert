
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_timetable extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "timetable_record";
        return $table;
    }

   function _get_by_arr_id($update_id) {
    $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->where('id', $update_id);
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        $query=$this->db->get($table);
        return $query;
    }

    function _get($order_by) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('*');
        $this->db->order_by($order_by);
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        return $this->db->get($table);
    }

     function _get_subject_data($timetable_id,$subject_id) {
        $table = "timetable_data";
        $this->db->select('*');
        $this->db->where('timetable_id',$timetable_id);
        $this->db->where('subject_id',$subject_id);
        return $this->db->get($table);
    }
    function _insert_timetable_subject($data2) {
        $table = 'timetable_data';
        $this->db->insert($table, $data2);
    }

    function _insert_exam_subject_marks($data) {
        $table = 'exam_marks';
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function _get_timetable_subject($timetable_id) {
        $table = 'timetable_data';
        $this->db->where('timetable_id',$timetable_id);
        return $this->db->get($table);
    }

    function _get_exam_subject_total($exam_id,$subject_id) {
        $table = 'exam_subject';
        $this->db->where('exam_id',$exam_id);
        $this->db->where('subject_id',$subject_id);
        return $this->db->get($table);
    }

    function _insert_timetable($data_timetable) {
        $table = 'timetable_record';
        $this->db->insert($table, $data_timetable);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function _update($arr_col, $org_id, $data) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $role_id = $user_data['role_id'];
        $this->db->where('id',$arr_col);
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        $this->db->update($table, $data);
    }
       function _update_id($id, $data) {
        $table = $this->get_table();
        $this->db->where('id',$id);
        $this->db->update($table, $data);
    }

    function check_subject($subject_id){
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $this->db->select('*');
        $this->db->where('section_id',$section_id);
        return $this->db->get($table);
    }

    function _get_class_student_list($update_id,$org_id){
        $this->db->select('exam.id exam_id, exam.exam_title,exam.class_name,exam.total_marks, student.id std_id, student.name,student.roll_no');
        $this->db->from('exam');
        $this->db->join("student", "student.section_id = exam.section_id", "full");
        $this->db->where('exam.id', $update_id);
        $this->db->where('exam.org_id', $org_id);
        $query=$this->db->get();
        return $query;
    }

    function _get_subject_student_list($subject_id,$org_id){
        $this->db->select('student.id std_id,student.name,student.roll_no');
        $this->db->from('subject');
        $this->db->join("student", "student.class_id = subject.class_id", "full");
        $this->db->where('subject.id', $subject_id);
        $this->db->where('subject.org_id', $org_id);
        $query=$this->db->get();
        return $query;
    }

    function _get_class_student_marks($std_id,$exam_id){
        $table = 'exam_marks';
        $this->db->select('obtained_marks');
        $this->db->where('std_id', $std_id);
        $this->db->where('exam_id', $exam_id);
        $query=$this->db->get($table);
        return $query;
    }

    function get_obtained_marks($std_id,$subject_id,$exam_id,$org_id){
        $table = 'exam_marks';
        $this->db->select('obtained_marks');
        $this->db->where('exam_subject_id', $subject_id);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('std_id', $std_id);
        $query=$this->db->get($table);
        return $query;
    }

    function update_marks($sbj_id,$std_id,$roll_no,$exam_id,$obtained_marks){
        $table = "exam_marks";
        // $where['obtained_marks']= $obtained_marks;
        // print_r($exam_id);exit();
        $this->db->where('std_id', $std_id);
        $this->db->where('std_roll_no', $roll_no);
        $this->db->where('exam_id', $exam_id);
        $this->db->where('exam_subject_id', $sbj_id);
        $this->db->set('obtained_marks',$obtained_marks);
        $this->db->update($table);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function update_subject($sbj_id,$timetable_id,$data){
        $table = "timetable_data";
        $this->db->where('timetable_id', $timetable_id);
        $this->db->where('subject_id', $sbj_id);
        $this->db->set($data);
        $this->db->update($table);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function check_day($day,$section_id){
        $table = $this->get_table();
        $this->db->where('day',$day);
        $this->db->where('section_id',$section_id);
        return $this->db->get($table);
    }

    function _delete($arr_col, $org_id) {       
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $role_id = $user_data['role_id'];
        $this->db->where('id', $arr_col);
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        $this->db->delete($table);
    }
    function _set_publish($where) {
        $table = $this->get_table();
        $set_publish['status'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_publish);
    }

    function _set_unpublish($where) {
        $table = $this->get_table();
        $set_un_publish['status'] = 0;
        $this->db->where($where);
        $this->db->update($table, $set_un_publish);
    }
    function _getItemById($id) {
        $table = $this->get_table();
        $this->db->where("( id = '" . $id . "'  )");
        $query = $this->db->get($table);
        return $query->row();
    }

    function _notif_insert_data_teacher($data){
        $table = 'teacher_notification';
        $this->db->insert($table,$data);   
    }

    function _notif_insert_data_parent($data){
        $table = 'parent_notification';
        $this->db->insert($table,$data);   
    }

    function _get_teacher_token($teacher_id,$org_id){
        $table = 'users_add';
        $this->db->select('fcm_token');
        $this->db->where('org_id',$org_id);
        $this->db->where('id',$teacher_id);
        $this->db->where('designation','Teacher');
        $query=$this->db->get($table);
        return $query;
    }

    function _get_parent_token($parent_id,$org_id){
        $table = 'users_add';
        $this->db->select('fcm_token');
        $this->db->where('org_id',$org_id);
        $this->db->where('id',$parent_id);
        $this->db->where('designation','Parent');
        $query=$this->db->get($table);
        return $query;
    }

    function _get_parent_for_push_noti($where,$org_id){
        $table = 'student';
        $this->db->select('parent_id');
        $this->db->where('org_id',$org_id);
        $this->db->where($where);
        $query=$this->db->get($table);
        return $query;
    }
    function _get_teacher_for_push_noti($where,$org_id){
        $table = 'subject';
        $this->db->select('teacher_id');
        $this->db->where('org_id',$org_id);
        $this->db->where($where);
        $query=$this->db->get($table);
        return $query;
    }
}