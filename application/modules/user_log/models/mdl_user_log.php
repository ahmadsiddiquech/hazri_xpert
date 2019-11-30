<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_user_log extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "users_sessions";
        return $table;
    }

    function _get_by_arr_id() {
        $table = $this->get_table();
        $this->db->select('users_sessions.*,users_add.name name,users.org_name org_name');
        $this->db->join("users_add", "users_add.id = users_sessions.user_id", "full");
        $this->db->join("users", "users.id = users_sessions.org_id", "full");
        return $this->db->get($table);
    }

    function _get($order_by,$org_id) {
        $table = $this->get_table();
        $this->db->select('users_sessions.*,users_add.name name,users.org_name org_name');
        $this->db->join("users_add", "users_add.id = users_sessions.user_id", "full");
        $this->db->join("users", "users.id = users_sessions.org_id", "full");
        $this->db->where('users_sessions.org_id', $org_id);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _change_status($user_id,$org_id,$log_id,$status){
        $table = 'users_sessions';
        $this->db->where('user_id', $user_id);
        $this->db->where('org_id', $org_id);
        $this->db->where('id', $log_id);
        $this->db->set('login_status' , $status);
        $this->db->update($table);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
    }

    function _get_org($order_by){
        $table = 'users';
        $this->db->where('role_id', 2);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

}