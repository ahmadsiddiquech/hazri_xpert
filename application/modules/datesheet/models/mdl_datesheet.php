
<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_datesheet extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "datesheet_record";
        return $table;
    }

   function _get_by_arr_id($update_id) {
        $table = $this->get_table();
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $role_id = $user_data['role_id'];
        $this->db->where('id',$update_id);
        if($role_id!=1){
            $this->db->where('org_id',$org_id);
        }
        return $this->db->get($table);
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

     function _get_subject_data($datesheet_id,$subject_id) {
        $table = "datesheet_data";
        $this->db->select('*');
        $this->db->where('datesheet_id',$datesheet_id);
        $this->db->where('id',$subject_id);
        return $this->db->get($table);
    }

    function _insert_datesheet_subject($data2) {
        $table = 'datesheet_data';
        $this->db->insert($table, $data2);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function _get_datesheet_subject($datesheet_id) {
        $table = 'datesheet_data';
        $this->db->where('datesheet_id',$datesheet_id);
        return $this->db->get($table);
    }

    function _insert_datesheet($data_datesheet) {
        $table = 'datesheet_record';
        $this->db->insert($table, $data_datesheet);
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


    function update_subject($sbj_id,$datesheet_id,$data){
        $table = "datesheet_data";
        $this->db->where('datesheet_id', $datesheet_id);
        $this->db->where('id', $sbj_id);
        $this->db->set($data);
        $this->db->update($table);
        $affected_rows = $this->db->affected_rows();
        return $affected_rows;
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