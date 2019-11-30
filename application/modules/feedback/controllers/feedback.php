<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Feedback extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->get();
    }

    function get(){
        $data['news'] = $this->_get('id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function conversation(){
        $id = $this->uri->segment(4);
        // print_r($id);exit();
        $data['conversation'] = $this->_get_conversation($id);
        $data['view_file'] = 'conversation';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function _get_data_from_db($update_id) {
        $where['feedback.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);

        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['teacher_name'] = $row->teacher_name;
            $data['parent_name'] = $row->parent_name;
            $data['std_name'] = $row->std_name;
            $data['message'] = $row->message;
            $data['date_time'] = $row->date_time;
            $data['user_type'] = $row->user_type;
        }
        if(isset($data))
            return $data;
    }
    
    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

    function _get($order_by) {
        $this->load->model('mdl_feedback');
        return $this->mdl_feedback->_get($order_by);
    }

    function _get_conversation($id) {
        $this->load->model('mdl_feedback');
        return $this->mdl_feedback->_get_conversation($id);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_feedback');
        return $this->mdl_feedback->_get_by_arr_id($arr_col);
    }

}