<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class fee_history extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->create();
    }


    function create() {
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $arr_program = Modules::run('program/_get_by_arr_id_programs',$org_id)->result_array();
        $program = array();

        foreach($arr_program as $row){
            $program[$row['id']] = $row['name'];
        }
        $data['program_title'] = $program;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function print_voucher(){
        $std_voucher_id = $this->uri->segment(4);
        if (is_numeric($std_voucher_id) && $std_voucher_id != 0) {
            $data['news'] = $this->_get_data_from_db($std_voucher_id)->result_array();
        }
        $this->load->view('print',$data);
    }

    function _get_data_from_db($update_id) {
        $query = $this->_get_by_arr_id($update_id);
        foreach ($query->result() as
                $row) {
            $data['std_voucher_id'] = $row->id;
            $data['voucher_id'] = $row->voucher_id;
            $data['section_id'] = $row->section_id;
            $data['section_name'] = $row->section_name;
            $data['class_id'] = $row->class_id;
            $data['class_name'] = $row->class_name;
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['issue_date'] = $row->issue_date;
            $data['due_date'] = $row->due_date;
            $data['std_id'] = $row->std_id;
            $data['std_roll_no'] = $row->std_roll_no;
            $data['std_name'] = $row->std_name;
            $data['parent_name'] = $row->parent_name;
            $data['tution_fee'] = $row->tution_fee;
            $data['transport_fee'] = $row->transport_fee;
            $data['stationary_fee'] = $row->stationary_fee;
            $data['lunch_fee'] = $row->lunch_fee;
            $data['other_fee'] = $row->other_fee;
            $data['total'] = $row->total;
            $data['paid'] = $row->paid;
            $data['remaining'] = $row->remaining;
            $data['pay_date'] = $row->pay_date;
            $data['org_id'] = $row->org_id;
            $data['status'] = $row->status;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $to = $this->input->post('date_to');
        $dTo = explode("/",$to);
        $data['to'] = $dTo[2].'-'.$dTo[1].'-'.$dTo[0];
        $from = $this->input->post('date_from');
        $dFrom = explode("/",$from);
        $data['from'] = $dFrom[2].'-'.$dFrom[1].'-'.$dFrom[0];
        $data['section_id'] = $this->input->post('section_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['program_id'] = $this->input->post('program_id');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;

    }

    function show_history() {
        $data1 = $this->_get_data_from_post();
        $data['fee_history'] = $this->_get_fee_history($data1);
        $data['view_file'] = 'view';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

    function _get_by_arr_id($update_id) {
        $this->load->model('mdl_fee_history');
        return $this->mdl_fee_history->_get_by_arr_id($update_id);
    }

    function _get_fee_history($data){
        $this->load->model('mdl_fee_history');
        return $this->mdl_fee_history->_get_fee_history($data);
    }

}