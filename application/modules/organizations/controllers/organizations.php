<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Organizations extends MX_Controller
{

function __construct() {
parent::__construct();
//Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');
}

function index(){
        $this->manage_record();
 }

function manage_record() {
    $user_data = $this->session->userdata('user_data');
    $permission = Modules:: run('permission/check',$user_data['role_id']);
    if($permission == 'true')
    {
        $data['users_rec'] = $this->_get()->result_array();
        $data['view_file'] = 'users_listing';
        $this->load->module('template');
        $this->template->admin($data);
    }
    else
    {
        redirect(ADMIN_BASE_URL.'post');
    }
        
}

function create(){      
    $user_data = $this->session->userdata('user_data');
    $permission = Modules:: run('permission/check',$user_data['role_id']);
    if($permission == 'true')
    {
        $update_id = $this->uri->segment(4);
         if ($update_id && $update_id != 0) {

            $data['users'] = $this->_get_data_from_db($update_id);
            
            
        } else {
            $data['users'] = $this->_get_data_from_post();
        }
    
        $data['update_id'] = $update_id;  
        $arrWhere['outlet_id'] = DEFAULT_OUTLET;
        $arr_roles = Modules::run('roles/_get_by_arr_id',$arrWhere)->result_array();
        $roles = array();
        foreach($arr_roles as $row){
            $roles[$row['id']] = $row['role'];
            
        }
       
        $data['roles_title'] = $roles;
        
        $data['view_file'] = 'users_form';
        $this->load->module('template');
        $this->template->admin($data);
    }
    else
    {
        redirect(ADMIN_BASE_URL.'post');
    }
}

    function submit() {
        $update_id = $this->uri->segment(4);
        $data = $this->_get_data_from_post();

        if ($update_id && $update_id != 0){
            $where['id'] = $update_id;
            $this->_update($where, $data);
        }
        else{
            $id = $this->_insert($data);
        }

        $this->session->set_flashdata('message', 'organizations'.' '.DATA_SAVED);
        $this->session->set_flashdata('status', 'success');
        redirect(ADMIN_BASE_URL . 'organizations');
    }

    function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['org_name'] = $row->org_name;
            $data['org_phone'] = $row->org_phone;
            $data['owner_name'] = $row->owner_name;
            $data['owner_phone'] = $row->owner_phone;
            $data['org_address'] = $row->org_address;
            $data['org_email'] = $row->org_email;
            $data['password'] = $row->password;
            $data['join_date'] = $row->join_date;
            $data['status'] = $row->status;
            $data['role_id'] = $row->role_id;
        }
        return $data;
    }
function change_password() {
    $update_id = $this->input->post('id');
    $data['users'] = $this->_get_data_from_db($update_id);
    $data['update_id'] = $update_id;
    $this->load->view('password_form', $data);
}

function validate (){
    $org_email = $this->input->post('org_email');

    $query = $this->_get_where_validate($org_email);

    if ($query->num_rows() > 0) echo '1';
    else echo '0';
}

function _get_data_from_post() {
        $data['org_name'] = $this->input->post('org_name');
        $data['org_phone'] = $this->input->post('org_phone');
        $data['owner_phone'] = $this->input->post('owner_phone');
        $data['owner_name'] = $this->input->post('owner_name');
        $data['org_address'] = $this->input->post('org_address');
        $data['org_email'] = $this->input->post('org_email');
        $data['join_date'] = $this->input->post('join_date');
        $chepi = $this->input->post('chepi');
        if($chepi == ''){
            $data['password'] =  $this->hashpassword($this->input->post('password'));
        }
        $data['role_id'] = $this->input->post('role_id');

     
        return $data;
    }

function delete(){
        $id = $this->input->post('id');
        $this->load->model('mdl_org');
        $this->mdl_org->_delete($id);
    }
    function change_pass() {  
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post_password();
            
            if ($update_id && $update_id != 0) {
                    $where['id'] = $update_id;
                   
                    $this->_update($where, $data);
                        
                        $this->session->set_flashdata('message', 'Password'.' '.'updated successfully');                                     
                        $this->session->set_flashdata('status', 'success');
                    
                }
        
            redirect(ADMIN_BASE_URL . 'organizations');
    }

    function hashpassword($password) {
        return md5($password);
    }
function _get_data_from_post_password() {
        $data['org_email'] = $this->input->post('org_email');
        $data['password'] =  $this->hashpassword($this->input->post('password'));
        return $data;
    }
    
    function load_listing() {
        
        $data['users_rec'] = $this->_get_by_arr_id($where)->result_array();
        $this->load->view('users_load_listing',$data);      
}
function change_status_event() {
    $id = $this->input->post('id');
    $status = $this->input->post('status');
    echo $status; 
    if ($status == 1)
      {  echo "one";
        $status = 0; }
    else
         {  echo "two";
        $status = 1; }
    $data = array('status' => $status);
    $status = $this->_update_status_event($id, $data);
    echo $status;
    exit;
}



 /////////////// for detail ////////////
function detail() {
    $update_id = $this->input->post('id');
    $data['users_res'] = $this->_get_data_from_db($update_id);
    $data['update_id'] = $update_id;
    $this->load->view('detail', $data);
}

////////////////////////////////////////////////
function _get($order_by='id asc'){
$this->load->model('mdl_org');
$query = $this->mdl_org->_get($order_by);
return $query;
}

function _get_with_limit($limit, $offset, $order_by='id asc') {
$this->load->model('mdl_org');
$query = $this->mdl_org->_get_with_limit($limit, $offset, $order_by);
return $query;
}

function _getItemById($id) {
$this->load->model('mdl_org');
return $this->mdl_org->_getItemById($id);
}

function _get_by_arr_id($arr_col) {
$this->load->model('mdl_org');
return $this->mdl_org->_get_by_arr_id($arr_col);
}

function _get_zabiha($table , $distance, $longitude, $latitude) {
$this->load->model('mdl_org');
return $this->mdl_org->_get_zabiha($table , $distance, $longitude, $latitude);
}

function _get_where($id){
$this->load->model('mdl_org');
$query = $this->mdl_org->_get_where($id);
return $query;
}

function _get_where_login($username , $password){
$this->load->model('mdl_org');
$query = $this->mdl_org->_get_where_login($username,$password);
return $query;
}

function _get_where_user($id){
$this->load->model('mdl_org');
$query = $this->mdl_org->_get_where_user($id);
return $query;
}
function _get_where_validate($org_email){
$this->load->model('mdl_org');
$query = $this->mdl_org->_get_where_validate($org_email);
return $query;
}

function _get_where_cols($cols,$order_by='id asc'){
$this->load->model('mdl_org');
$query = $this->mdl_org->_get_where_cols($cols,$order_by);
return $query;
}

function _get_where_custom($col, $value,$order_by='id asc') {
   // print '<br>this =====controler ====>>';exit;
$this->load->model('mdl_org');
$query = $this->mdl_org->_get_where_custom($col, $value,$order_by);
return $query;
}
function _update_status_event($id, $data) {
    $this->load->model('mdl_org');
    $this->mdl_org->_update_id($id, $data);
}
function _insert($data, $type){
$this->load->model('mdl_org');
return $this->mdl_org->_insert($data);
}

function _update_status_news($id, $data) {
    $this->load->model('mdl_org');
    $this->mdl_org->_update_id($id, $data);
}

function _update($arr_col, $data) {
$this->load->model('mdl_org');
$this->mdl_org->_update($arr_col, $data);
}

function _update_where_cols($cols, $data){
$this->load->model('mdl_org');
$this->mdl_org->_update_where_cols($cols, $data);
}



function _count_where($column, $value) {
$this->load->model('mdl_org');
$count = $this->mdl_org->_count_where($column, $value);
return $count;
}

function _get_max() {
$this->load->model('mdl_org');
$max_id = $this->mdl_org->_get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_org');
$query = $this->mdl_org->_custom_query($mysql_query);
return $query;
}

}