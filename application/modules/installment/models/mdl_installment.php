<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_installment extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "voucher_record";
        return $table;
    }

    function _get_data_from_db_print_voucher($where) {
        $this->db->select('installment.id std_voucher_id,installment.std_name std_name,installment.std_id std_id,installment.fee total,installment.due_date due_date,installment.i_tution_fee tution_fee,installment.i_lunch_fee lunch_fee,installment.i_transport_fee transport_fee,users.org_name org_name');
        $this->db->from('installment');
        $this->db->join("voucher_data", "voucher_data.id = installment.std_voucher_id", "full");
        $this->db->join("student", "student.id = installment.std_id", "full");
        $this->db->join("users", "users.id = student.org_id", "full");
        $this->db->where($where);
        return $this->db->get();
    }

    function _get_by_arr_id_std_installment($id) {
        $this->db->select('installment.id installment_id,installment.*,voucher_record.*');
        $this->db->from('installment');
        $this->db->join("voucher_record", "voucher_record.id = installment.voucher_id", "full");
        $this->db->where('installment.id', $id);
        return $this->db->get();
    }

    function _get_by_arr_id_std_voucher($arr_col) {
        $table = 'voucher_data';
        $this->db->where($arr_col);
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
        elseif (isset($submit_id) && !empty($submit_id) && $role_id=1) {
            $this->db->where('org_id',$submit_id);
        }
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function _get_installment($order_by) {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->db->select('installment.id installment_id,installment.due_date due_date,voucher_record.program_name program_name,voucher_record.class_name class_name,voucher_record.section_name section_name,installment.std_name std_name,installment.fee fee,installment.status status,installment.org_id org_id,installment.std_voucher_id std_voucher_id');
        $this->db->from('installment');
        $this->db->join("voucher_record", "voucher_record.id = installment.voucher_id", "full");
        $this->db->where('installment.org_id', $org_id);
        $this->db->order_by($order_by);
        return $this->db->get();
    }

    function _installment_flag($voucher_id,$std_voucher_id) {
        $table = 'voucher_data';
        $this->db->where('voucher_id', $voucher_id);
        $this->db->where('id', $std_voucher_id);
        $this->db->set('installment' , 1);
        $this->db->update($table);
    }

    function _get_std_vouchers($voucher_id) {
        $table = 'voucher_data';
        $this->db->where('voucher_id',$voucher_id);
        return $this->db->get($table);
    }

    function _insert_installment_std_voucher($data) {
        $table = 'installment';
        $this->db->insert($table,$data);
        return $this->db->insert_id();
    }

    function _update_id($id, $data, $std_voucher_id, $data2) {
        $table = 'installment';
        $this->db->where('id',$id);
        $this->db->update($table, $data);

        $table1 = 'voucher_data';
        $this->db->where('id',$std_voucher_id);
        $this->db->update($table1, $data2);
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
}