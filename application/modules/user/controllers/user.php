<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends MX_Controller
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
        $data['news'] = $this->_get_data('id desc');

        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function get(){
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
        $where['users_add.id'] = $update_id;
        //$where['post.lang_id'] = $lang_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['email'] = $row->email;
            $data['phone'] = $row->phone;
            $data['user_address'] = $row->user_address;
            $data['cnic'] = $row->cnic;
            $data['password'] = $row->password;
            $data['gender'] = $row->gender;
            $data['designation'] = $row->designation;
            $data['about'] = $row->about;
            $data['status'] = $row->status;
            //print_r($data);exi();t
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['about'] = $this->input->post('about');
        $data['user_address'] = $this->input->post('user_address');
        $data['cnic'] = $this->input->post('cnic');
        $data['designation'] = $this->input->post('designation');
        $data['gender'] = $this->input->post('gender');
        $data['password'] = $this->input->post('password');
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
                $this->session->set_flashdata('message', 'User'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'user');
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
        redirect(ADMIN_BASE_URL . 'user/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        //$lang_id = $this->uri->segment(5);
        $where['id'] = $update_id;
        //$where['lang_id'] = $lang_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'user/manage/' . '');
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

    function validate (){
    $phone = $this->input->post('phone');

    $query = $this->_get_where_validate($phone);

    if ($query->num_rows() > 0) echo '1';
    else echo '0';
    }

    /////////////// for detail ////////////
    function detail() {
        $update_id = $this->input->post('id');
       // $lang_id = $this->input->post('lang_id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }


    function _get_data($order_by){
        $query = $this->_get($order_by)->result_array();
        if (isset($query) && !empty($query)) {
            foreach ($query as $key => $value){
                $data['id'] = $value['id'];
                $data['name'] = $value['name'];
                $data['email'] = $value['email'];
                $data['phone'] = $value['phone'];
                $data['user_address'] = $value['user_address'];
                $data['cnic'] = $value['cnic'];
                $data['password'] = $value['password'];
                $data['gender'] = $value['gender'];
                $data['designation'] = $value['designation'];
                $data['about'] = $value['about'];
                $data['status'] = $value['status'];
                $data['org_id'] = $value['org_id'];
                $session = $this->_get_session($data['id'],$data['phone'],$data['org_id'])->result_array();
                if (isset($session) && !empty($session)) {
                	
                    $data['login_status'] = $session[0]['login_status'];
                }
                else{
                	$data['login_status'] = 0;
                }
                $data1[] = $data;
            }
        }
        return $data1;
    }

    function logout_user () {
        $user_id = $this->input->post('user_id');
        $org_id = $this->input->post('org_id');
        $username = $this->input->post('username');
        $this->load->model('mdl_user');
        $check = $this->mdl_user->_logout_user($user_id,$org_id,$username);
        if($check >= 1){
            echo "1";
        }
        else{
            echo "0";
        }
    }


    function _getItemById($id) {
        $this->load->model('mdl_user');
        return $this->mdl_user->_getItemById($id);
    }
    function _set_publish($arr_col) {
        $this->load->model('mdl_user');
        $this->mdl_user->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_user');
        $this->mdl_user->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_user');
        $query = $this->mdl_user->_get($order_by);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_user');
        return $this->mdl_user->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_user');
        return $this->mdl_user->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_user');
        $this->mdl_user->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_user');
        $this->mdl_user->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_user');
        $this->mdl_user->_delete($arr_col, $org_id);
    }
    function _get_by_arr_id_teacher() {
        $this->load->model('mdl_user');
        return $this->mdl_user->_get_by_arr_id_teacher();
    }
    function _get_by_arr_id_parent() {
        $this->load->model('mdl_user');
        return $this->mdl_user->_get_by_arr_id_parent();
    }

    function _get_where_validate($phone){
        $this->load->model('mdl_user');
        $query = $this->mdl_user->_get_where_validate($phone);
        return $query;
    }

    function _get_session($id,$username,$org_id){
        $this->load->model('mdl_user');
        return $this->mdl_user->_get_session($id,$username,$org_id);
    }

}