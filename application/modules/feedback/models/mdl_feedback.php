<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_feedback extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "feedback";
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
        return $this->db->get($table);
    }

    function _get_conversation($id) {
        $table = 'feedback_reply';
        $this->db->where('f_id',$id);
        return $this->db->get($table);
    }
}