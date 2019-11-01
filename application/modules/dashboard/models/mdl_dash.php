<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_dash extends CI_Model {

function __construct() {
parent::__construct();
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