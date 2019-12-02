<?php
if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');

class Mdl_dash extends CI_Model {
    function __construct() {
        parent::__construct();
    }

function _get_income($startDate,$endDate,$org_id){
    $this->db->select('voucher_data.paid');
    $this->db->from('voucher_record');
    $this->db->join("voucher_data", "voucher_data.voucher_id = voucher_record.id", "full");
    $this->db->where('voucher_record.org_id', $org_id);
    $this->db->where('voucher_record.issue_date >=', $startDate);
    $this->db->where('voucher_record.issue_date <=', $endDate);
    return $this->db->get();
}

function _get_expense($startDate,$endDate,$org_id){
    $table = 'expense';
    $this->db->where('date >=', $startDate);
    $this->db->where('date <=', $endDate);
    $this->db->where('org_id',$org_id);
    return $this->db->get($table);
}

function _get_total_program($org_id){
    $table = 'program';
    $this->db->where('status', '1');
    $this->db->where('org_id',$org_id);
    return $this->db->get($table);
}


function _get_total_student($org_id){
	$table = 'student';
    $this->db->where('status', '1');
    $this->db->where('org_id',$org_id);
    return $this->db->get($table);
}

function _get_announcement($org_id){
	$table = 'announcement';
    $this->db->where('status', '1');
    $this->db->where('org_id',$org_id);
    $this->db->order_by('id','DESC');
    return $this->db->get($table);
}

function _get_total_teacher_parent($org_id,$designation){
	$table = 'users_add';
    $this->db->where('status', '1');
    $this->db->where('org_id',$org_id);
    $this->db->where('designation',$designation);
    return $this->db->get($table);
}

}