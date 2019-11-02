<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_fee_history extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "subject";
        return $table;
    }

    function _get_by_arr_id($update_id) {
        $table = 'voucher_data';
        $this->db->select('voucher_record.*,voucher_data.*');
        $this->db->join("voucher_record", "voucher_record.id = voucher_data.voucher_id", "full");
        $this->db->where('voucher_data.id',$update_id);
        return $this->db->get($table);
    }

    function _get_fee_history($data){
        $table = 'voucher_record';
        $this->db->select('voucher_record.*,voucher_data.*');
        $this->db->join("voucher_data", "voucher_record.id = voucher_data.voucher_id", "full");
        $this->db->where('voucher_record.class_id',$data['class_id']);
        $this->db->where('voucher_record.program_id',$data['program_id']);
        $this->db->where('voucher_record.section_id',$data['section_id']);
        $this->db->where('voucher_record.org_id',$data['org_id']);
        $this->db->where('voucher_record.issue_date >=', $data['from']);
        $this->db->where('voucher_record.issue_date <=', $data['to']);
        return $this->db->get($table);
    }

}