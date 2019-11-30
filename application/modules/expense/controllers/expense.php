
<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Expense extends MX_Controller
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
        $where['expense.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['title'] = $row->title;
            $data['description'] = $row->description;
            $data['amount'] = $row->amount;
            $data['date'] = $row->date;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['date'] = $this->input->post('date');
        $data['amount'] = $this->input->post('amount');
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
                $this->session->set_flashdata('message', 'expense'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'expense');
        }
    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->_delete($delete_id, $org_id);
    }

    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

    function _getItemById($id) {
        $this->load->model('mdl_expense');
        return $this->mdl_expense->_getItemById($id);
    }

    function _set_publish($arr_col) {
        $this->load->model('mdl_expense');
        $this->mdl_expense->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_expense');
        $this->mdl_expense->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_expense');
        $query = $this->mdl_expense->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_expense');
        return $this->mdl_expense->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_expense');
        return $this->mdl_expense->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_expense');
        $this->mdl_expense->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_expense');
        $this->mdl_expense->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_expense');
        $this->mdl_expense->_delete($arr_col, $org_id);
    }

    function _get_by_arr_id_programs($org_id){
        $this->load->model('mdl_expense');
        return $this->mdl_expense->_get_by_arr_id_programs($org_id);
    }
}