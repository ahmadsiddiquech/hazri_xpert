<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_user extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "users_add";
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
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
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
    function _get_by_arr_id_teacher() {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('*');
        $this->db->where('designation','Teacher');
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        return $this->db->get($table);
    }

    function _get_by_arr_id_parent() {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('*');
        $this->db->where('designation','Parent');
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        return $this->db->get($table);
    }

    function _get_where_validate($phone){   
        $table = $this->get_table();
        $this->db->where('phone', $phone);
        $query=$this->db->get($table);
        return $query;
    }

    function _get_session($id,$username,$org_id){
        $table = 'users_sessions';
        $this->db->select('login_status');
        $this->db->where('user_id',$id);
        $this->db->where('login_status', 1);
        $this->db->where('username',$username);
        $this->db->where('org_id',$org_id);
        return $this->db->get($table);
    }

    function _logout_user($user_id,$org_id,$username){
        $table = "users_sessions";
        $this->db->where('username', $username);
        $this->db->where('user_id', $user_id);
        $this->db->where('org_id', $org_id);
        $this->db->where('login_status', 1);
        $this->db->set('login_status' , 0);
        $this->db->update($table);
        $affected_rows = $this->db->affected_rows();

        $table2 = "users_add";
        $this->db->where('id', $user_id);
        $this->db->where('org_id', $org_id);
        $this->db->set('fcm_token' , '');
        $this->db->update($table2);
        return $affected_rows;

    }
}