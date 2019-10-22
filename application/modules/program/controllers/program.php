<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Program extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->manage();
    }

    function manage() {
        $data['news'] = $this->_get('id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function create() {
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        
        $data['update_id'] = $update_id;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
    

    function _get_data_from_db($update_id) {
        $where['program.id'] = $update_id;
        //$where['post.lang_id'] = $lang_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['status'] = $row->status;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['name'] = $this->input->post('name');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;

    }

    function submit() {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            $user_data = $this->session->userdata('user_data');
            if ($update_id != 0) {

                $id = $this->_update($update_id,$user_data['user_id'], $data);
            }
            else
            {
                $id = $this->_insert($data);
            }
                $this->session->set_flashdata('message', 'program'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'program');
        }
    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->_delete($delete_id, $org_id);
    }

    function set_publish() {
        $update_id = $this->uri->segment(4);
        //$lang_id = $this->uri->segment(5);
        $where['id'] = $update_id;
        //$where['lang_id'] = $lang_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'program/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        //$lang_id = $this->uri->segment(5);
        $where['id'] = $update_id;
        //$where['lang_id'] = $lang_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'program/manage/' . '');
    }

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == PUBLISHED)
            $status = UN_PUBLISHED;
        else
            $status = PUBLISHED;
        $data = array('status' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
    }

    /////////////// for detail ////////////
    function detail() {
        $update_id = $this->input->post('id');
       // $lang_id = $this->input->post('lang_id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

///////////////////////////     HELPER FUNCTIONS    ////////////////////
    function _getItemById($id) {
        $this->load->model('mdl_program');
        return $this->mdl_program->_getItemById($id);
    }

    function _set_publish($arr_col) {
        $this->load->model('mdl_program');
        $this->mdl_program->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_program');
        $this->mdl_program->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_program');
        $query = $this->mdl_program->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_program');
        return $this->mdl_program->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_program');
        return $this->mdl_program->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_program');
        $this->mdl_program->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_program');
        $this->mdl_program->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_program');
        $this->mdl_program->_delete($arr_col, $org_id);
    }

    function _get_by_arr_id_programs($org_id){
        $this->load->model('mdl_program');
        return $this->mdl_program->_get_by_arr_id_programs($org_id);
    }
}