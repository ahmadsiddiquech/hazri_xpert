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
        $this->db->select('installment.id installment_id,installment.*,voucher_record.*');
        $this->db->from('installment');
        $this->db->join("voucher_record", "voucher_record.id = installment.voucher_id", "full");
        $this->db->where('installment.org_id', $org_id);
        $this->db->order_by($order_by);
        return $this->db->get();
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
}