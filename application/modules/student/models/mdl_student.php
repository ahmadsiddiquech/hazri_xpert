<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_student extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "student";
        return $table;
    }

    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('classes.id class_id,classes.name class_name,sections.id section_id,sections.section section_name,student.id,student.name,student.status,student.parent_name,student.org_id,student.p_c_no,student.gender,student.image,student.dob,student.roll_no,student.address,student.addmission_date,program.name program_name,program.id program_id,student.*');
        $this->db->join("classes", "classes.id = student.class_id", "full");
        $this->db->join("sections", "sections.id = student.section_id", "full");
        $this->db->join("program", "program.id = student.program_id", "full");
        $this->db->where($arr_col);
        if($role_id!=1){
            $this->db->where('student.org_id',$org_id);
        }
        return $this->db->get($table);
    }

    function _get_subject_by_arr_id($update_id){
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('student.id,subject.id subject_id,subject.name subject_name');
        $this->db->from('student');
        $this->db->join("subject", "subject.id = student.subject_id", "full");
        $this->db->where('student.id',$update_id);
        
        if($role_id!=1){
            $this->db->where('student.org_id',$org_id);
        }
        return $this->db->get();
    }

    function _get_parent_by_arr_id($update_id){
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('student.id,users_add.id parent_id');
        $this->db->from('student');
        $this->db->join("users_add", "users_add.id = student.parent_id", "full");
        $this->db->where('student.id',$update_id);
        if($role_id!=1){
            $this->db->where('student.org_id',$org_id);
        }
        return $this->db->get();
    }

    function check_roll_no($roll_no,$section_id){
        $table = $this->get_table();
        $this->db->select('*');
        $this->db->where('roll_no',$roll_no);
        $this->db->where('section_id',$section_id);
        return $this->db->get($table);
    }

    function _get_by_arr_id_section($section_id){
        $table = $this->get_table();
        $this->db->select('*');
        $this->db->where('status','1');
        $this->db->where('section_id',$section_id);
        return $this->db->get($table);
    }

    function _get($order_by) {
        $user_data = $this->session->userdata('user_data');
        $role_id = $user_data['role_id'];
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->select('classes.id class_id,classes.name class_name,sections.id section_id,sections.section section_name,student.id,student.name,student.status,student.parent_name,student.org_id');
        $this->db->join("classes", "classes.id = student.class_id", "full");
        $this->db->join("sections", "sections.id = student.section_id", "full");
        if($role_id!= 1)
        {
        $this->db->where('student.org_id',$org_id);
        }
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_subject_teacher_detail($where){
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $role_id = $user_data['role_id'];
        $org_id = $user_data['user_id'];
        $this->db->select('subject.name subject_name,users_add.name teacher_name,subject.s_type subject_type');
        $this->db->join("subject", "subject.section_id = student.section_id", "full");
        $this->db->join("users_add", "users_add.id = subject.teacher_id", "full");
        if($role_id!= 1)
        {
        $this->db->where('student.org_id',$org_id);
        }
        $this->db->where($where);
        return $this->db->get($table);
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        return $this->db->insert_id();
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
        $this->db->where('id',$id);
        $query = $this->db->get($table);
        return $query->row();
    }

    function _get_class($program_id){
        $table = "classes";
        $this->db->where('program_id',$program_id);
        return $this->db->get($table);
    }
    function _get_section($class_id,$program_id){
        $table = "sections";
        $this->db->where('class_id',$class_id);
        $this->db->where('program_id',$program_id);
        return $this->db->get($table);
    }
    function _get_roll($section_id,$class_id,$program_id){
        $table = "sections";
        $this->db->where('id',$section_id);
        $this->db->where('class_id',$class_id);
        $this->db->where('program_id',$program_id);
        return $this->db->get($table);
    }
    function _get_subject($section_id,$class_id,$program_id){
        $table = "subject";
        $this->db->where('section_id',$section_id);
        $this->db->where('class_id',$class_id);
        $this->db->where('program_id',$program_id);
        $this->db->where('s_type','Optional');
        return $this->db->get($table);
    }
}