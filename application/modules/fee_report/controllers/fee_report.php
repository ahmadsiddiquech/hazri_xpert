<?php
if ( ! defined('BASEPATH')) 
    exit('No direct script access allowed');
class fee_report extends MX_Controller
{

    function __construct() {
        parent::__construct();
        Modules::run('site_security/is_login');
    }

    function index() {
        $this->create();
    }

    function show_report() {
        $data1 = $this->_get_data_from_post();
        $date = explode("/",$data1['month']);
        $startDate = $date[0].'/'.$date[1].'/01';
        $endDate = $date[0].'/'.$date[1].'/31';
        $data['report'] = $this->_get_report_data($data1['program_id'],$data1['class_id'],$data1['section_id'],$startDate,$endDate,$data1['org_id'])->result_array();

        $this->load->view('news',$data);
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
    
    function _get_data_from_post() {
        $data['month'] = $this->input->post('month');
        $data['section_id'] = $this->input->post('section_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['program_id'] = $this->input->post('program_id');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;
    }

    function _get_report_data($program_id,$class_id,$section_id,$startDate,$endDate,$org_id){
        $this->load->model('mdl_fee_report');
        return $this->mdl_fee_report->_get_report_data($program_id,$class_id,$section_id,$startDate,$endDate,$org_id);  
    }

}