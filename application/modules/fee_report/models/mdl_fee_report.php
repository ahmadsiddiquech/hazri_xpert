<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_fee_report extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "voucher_record";
        return $table;
    }

    function _get_report_data($program_id,$class_id,$section_id,$startDate,$endDate,$org_id){
    	$this->db->select('voucher_record.*,voucher_data.*,student.parent_name parent_name,users.*');
        $this->db->from('voucher_record');
        $this->db->join("voucher_data", "voucher_data.voucher_id = voucher_record.id", "full");
        $this->db->join("student", "student.id = voucher_data.std_id", "full");
        $this->db->join("users", "users.id = voucher_record.org_id", "full");
        $this->db->where('voucher_record.program_id',$program_id);
        $this->db->where('voucher_record.class_id',$class_id);
        $this->db->where('voucher_record.section_id',$section_id);
        $this->db->where('voucher_record.org_id',$org_id);
        $this->db->where('voucher_record.issue_date >=', $startDate);
        $this->db->where('voucher_record.issue_date <=', $endDate);
        return $this->db->get();
    }
}