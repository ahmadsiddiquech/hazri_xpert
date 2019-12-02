<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_voucher extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "voucher_record";
        return $table;
    }

   function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('*');
        $this->db->where($arr_col);
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        return $this->db->get($table);
    }

    function _get_by_arr_id_std_voucher($arr_col) {
        $table = 'voucher_data';
        $this->db->where($arr_col);
        return $this->db->get($table);
    }

    function _get_data_from_db_print_voucher($where) {
        $this->db->select('student.id student_id,student.*,voucher_data.id std_voucher_id,voucher_data.*,users.id org_id,users.*,voucher_record.*');
        $this->db->from('student');
        $this->db->join("voucher_data", "voucher_data.std_id = student.id", "full");
        $this->db->join("users", "users.id = student.org_id", "full");
        $this->db->join("voucher_record", "voucher_record.id = voucher_data.voucher_id", "full");
        $this->db->where($where);
        return $this->db->get();
    }

    function _get($order_by) {
        $submit_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $role_id = $user_data['role_id'];
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->select('*');
        if($role_id!= 1)
        {
        $this->db->where('org_id',$org_id);
        }
        elseif (isset($submit_id) && !empty($submit_id) && $role_id=1) {
            $this->db->where('org_id',$submit_id);
        }
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function _get_std_vouchers($voucher_id) {
        $table = 'voucher_data';
        $this->db->where('voucher_id',$voucher_id);
        return $this->db->get($table);
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function _insert_std_voucher($data1) {
        $table = 'voucher_data';
        $this->db->insert($table, $data1);
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

    function _update_std_voucher($arr_col, $data) {
        $table = 'voucher_data';
        $this->db->where('id',$arr_col);
        $this->db->update($table, $data);
    }

       function _update_id($id, $data) {
        $table = 'voucher_data';
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
        $table = 'voucher_data';
        $set_publish['status'] = 'paid';
        $this->db->where($where);
        $this->db->update($table, $set_publish);
    }

    function _set_unpublish($where) {
        $table = 'voucher_data';
        $set_un_publish['status'] = 'unpaid';
        $this->db->where($where);
        $this->db->update($table, $set_un_publish);
    }
    function _getItemById($id) {
        $table = $this->get_table();
        $this->db->where("( id = '" . $id . "'  )");
        $query = $this->db->get($table);
        return $query->row();
    }

    function _get_student_by_section_id($section_id,$org_id){
        $table = 'student';
        $this->db->where('section_id',$section_id);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _notif_insert_data($data){
        $table = 'notification';
        $this->db->insert($table,$data);
        return $this->db->insert_id();   
    }

    function _get_parent_token($parent_id,$org_id){
        $table = 'users_add';
        $this->db->select('fcm_token');
        $this->db->where('org_id',$org_id);
        $this->db->where('id',$parent_id);
        $this->db->where('designation','Parent');
        return $this->db->get($table);
    }

    function _get_parent_id_for_notification($where,$org_id){
        $table = 'student';
        $this->db->where('org_id',$org_id);
        $this->db->where($where);
        return $this->db->get($table);
    }

    function _get_previous_fee($std_id){
    	$table = 'voucher_data';
        $this->db->select('remaining');
        $this->db->where('std_id',$std_id);
        $this->db->order_by('id','DESC');
        return $this->db->get($table);
    }
}