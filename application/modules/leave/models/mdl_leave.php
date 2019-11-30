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
        return $this->db->get($table);
    }

    function _change_status($std_id,$roll_no,$leave_id,$status){
        $table = 'leave';
        $this->db->where('std_roll_no', $roll_no);
        $this->db->where('std_id', $std_id);
        $this->db->where('id', $leave_id);
        $this->db->set('status' , $status);
        $this->db->update($table);
        return $this->db->affected_rows();
    }

    function _get_teacher_token($teacher_id,$org_id){
        $table = 'users_add';
        $this->db->select('fcm_token');
        $this->db->where('org_id',$org_id);
        $this->db->where('id',$teacher_id);
        $this->db->where('designation','Teacher');
        return $this->db->get($table);
    }

    function _get_parent_token($parent_id,$org_id){
        $table = 'users_add';
        $this->db->select('fcm_token');
        $this->db->where('org_id',$org_id);
        $this->db->where('id',$parent_id);
        $this->db->where('designation','Parent');
        return $this->db->get($table);
    }

    function _notif_insert_data($data){
        $table = 'notification';
        $this->db->insert($table,$data);
        return $this->db->insert_id();   
    }

    function _get_parent_id_for_notification($where,$org_id){
        $table = 'student';
        $this->db->where('org_id',$org_id);
        $this->db->where($where);
        return $this->db->get($table);
    }

    function _get_teacher_id_for_notification($where,$org_id){
        $table = 'subject';
        $this->db->where('org_id',$org_id);
        $this->db->where($where);
        return $this->db->get($table);
    }

}