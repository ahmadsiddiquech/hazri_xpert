<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class user_log extends MX_Controller
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
        $data['news'] = $this->_get_org('users.id desc');
        $data['view_file'] = 'org_list';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function manage() {
        $org_id = $this->uri->segment(4);
        $query = $this->_get('users_sessions.id desc',$org_id)->result_array();
        if (isset($query) && !empty($query)) {

            foreach ($query as $key => $value) {
                $data1['id'] = $value['id'];
                $data1['username'] = $value['username'];
                $data1['name'] = $value['name'];
                $data1['user_id'] = $value['user_id'];
                $data1['device_name'] = $value['device_name'];
                $data1['login_date'] = $value['login_date_time'];
                $data1['logout_date'] = $value['logout_date_time'];
                $data1['login_status'] = $value['login_status'];
                $data1['org_name'] = $value['org_name'];
                $data1['org_id'] = $value['org_id'];
                $data2[] = $data1;
            }
        }
        $data['news'] = $data2;
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }


    function _get_data_from_db($update_id) {
        $where['users_sessions.id'] = $update_id;
        //$where['post.lang_id'] = $lang_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['std_id'] = $row->std_id;
            $data['std_name'] = $row->std_name;
            $data['std_roll_no'] = $row->std_roll_no;
            $data['leave_type'] = $row->leave_type;
            $data['leave_duration'] = $row->leave_duration;
            $data['parent_id'] = $row->parent_id;
            $data['section_id'] = $row->section_id;
            $data['parent_name'] = $row->parent_name;
            $data['section_name'] = $row->section_name;
            $data['reason'] = $row->reason;
            $data['date'] = $row->date;
            $data['leave_start'] = $row->leave_start;
            $data['status'] = $row->status;
        }
        if(isset($data))
            return $data;
    }

    function change_status () {
        $user_id = $this->input->post('user_id');
        $org_id = $this->input->post('org_id');
        $log_id = $this->input->post('log_id');
        $status = $this->input->post('status');
        $this->load->model('mdl_user_log');
        $check = $this->mdl_user_log->_change_status($user_id,$org_id,$log_id,$status);

        if($check == 1){
            echo "true";
        }
        else{
            echo "false";
        }
    }


    function _getItemById($id) {
        $this->load->model('mdl_user_log');
        return $this->mdl_user_log->_getItemById($id);
    }
    function _get($order_by,$org_id) {
        $this->load->model('mdl_user_log');
        $query = $this->mdl_user_log->_get($order_by,$org_id);
        return $query;
    }

    function _get_org($order_by) {
        $this->load->model('mdl_user_log');
        $query = $this->mdl_user_log->_get_org($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_user_log');
        return $this->mdl_user_log->_get_by_arr_id($arr_col);
    }

}