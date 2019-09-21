<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_leave extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "leave";
        return $table;
    }

    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('leave.*,sections.section section_name,users_add.name parent_name');
        $this->db->join("sections", "sections.id = leave.section_id", "full");
        $this->db->join("users_add", "users_add.id = leave.parent_id", "full");
        $this->db->where($arr_col);
        if($role_id!=1){
            $this->db->where('leave.org_id',$org_id);
        }
        return $this->db->get($table);
    }

    function _get($order_by) {
        $user_data = $this->session->userdata('user_data');
        $role_id = $user_data['role_id'];
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->select('leave.*,sections.section section_name,users_add.name parent_name');
        $this->db->join("sections", "sections.id = leave.section_id", "full");
        $this->db->join("users_add", "users_add.id = leave.parent_id", "full");
        if($role_id!= 1)
        {
        $this->db->where('leave.org_id',$org_id);
        }
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function _change_status($std_id,$roll_no,$leave_id,$status){
        $table = 'leave';
        $this->db->where('std_roll_no', $roll_no);
        $this->db->where('std_id', $std_id);
        $this->db->where('id', $leave_id);
        $this->db->set('status' , $status);
        $this->db->update($table);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
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