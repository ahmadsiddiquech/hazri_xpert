<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_sections extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "sections";
        return $table;
    }

    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('classes.id,classes.name class_name,sections.id,sections.class_id,sections.status,sections.org_id,sections.section,sections.roll_from,sections.roll_to,users_add.id teacher_id,users_add.name teacher_name,sections.program_id,program.name program_name');
        $this->db->join("classes", "classes.id = sections.class_id", "full");
        $this->db->join("users_add", "sections.teacher_id = users_add.id", "full");
        $this->db->join("program", "program.id = sections.program_id", "full");
        $this->db->where($arr_col);
        if($role_id!=1){
            $this->db->where('sections.org_id',$org_id);
        }
        return $this->db->get($table);
    }

    // function _get_by_arr_id_sections() {
    //     $table = $this->get_table();
    //     $user_data = $this->session->userdata('user_data');
    //     $org_id = $user_data['user_id'];
    //     $role_id = $user_data['role_id'];
    //     $this->db->select('*');
    //     if($role_id!=1){
    //         $this->db->where('org_id',$org_id);
    //     }
    //     return $this->db->get($table);
    // }

    function _get_by_arr_id_roll($id) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->select('*');
        $this->db->where('id',$id);
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        return $this->db->get($table);
    }
    function _get_by_arr_id_class($class_id){
        $table = $this->get_table();
        $this->db->select('*');
        $this->db->where('class_id',$class_id);
        
        $query = $this->db->get($table);
        // print_r($query);exit();
        return $query;
    }
    function _get($order_by) {
        $user_data = $this->session->userdata('user_data');
        $role_id = $user_data['role_id'];
        $org_id = $user_data['user_id'];
        $table = $this->get_table();
        $this->db->select('classes.id,classes.name class_name,sections.id,sections.class_id,sections.status,sections.org_id,sections.section,sections.roll_from,sections.roll_to');
        $this->db->join("classes", "classes.id = sections.class_id", "full");
        if($role_id!= 1)
        {
        $this->db->where('sections.org_id',$org_id);
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

}