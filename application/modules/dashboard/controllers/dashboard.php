<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MX_Controller
{

function __construct() {
parent::__construct();
//print '<br>this ===>';

Modules::run('site_security/is_login');
//print '<br>this ===>';//exit;
}

function index(){

	//print '<br>this =index==>';exit;
 	 $data['view_file'] = 'home';
	 $this->load->module('template');
	 $config=array();
	$ci = & get_instance();

	 $ci->load->library('session');
	 $user_data = $ci->session->userdata('user_data');
	 $data['organization'] = $user_data['user_name'];
     $data['program'] = $this->get_total_program();
	 $data['student'] = $this->get_total_student();
	 $data['announcement'] = $this->get_announcement();
	 $data['teacher'] = $this->get_total_teacher_parent('Teacher');
	 $data['parent'] = $this->get_total_teacher_parent('Parent');
	 $this->template->admin($data);
	 }

     function get_total_program(){
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        return $this->_get_total_program($org_id)->num_rows();
    }

    function get_total_student(){
    	$user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        return $this->_get_total_student($org_id)->num_rows();
    }

    function get_announcement(){
    	$user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        return  $this->_get_announcement($org_id)->result_array();
    }

    function get_total_teacher_parent($designation){
    	$user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        return $this->_get_total_teacher_parent($org_id,$designation)->num_rows();
    }


//==========================helper=========================


    function _get_total_student($org_id){
    	$this->load->model('mdl_dash');
    	return $this->mdl_dash->_get_total_student($org_id);
    }

    function _get_total_program($org_id){
        $this->load->model('mdl_dash');
        return $this->mdl_dash->_get_total_program($org_id);
    }

    function _get_announcement($org_id){
    	$this->load->model('mdl_dash');
    	return $this->mdl_dash->_get_announcement($org_id);
    }

    function _get_total_teacher_parent($org_id,$designation){
    	$this->load->model('mdl_dash');
    	return $this->mdl_dash->_get_total_teacher_parent($org_id,$designation);
    }

}