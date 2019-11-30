<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sections extends MX_Controller
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
        $data['news'] = $this->_get('sections.id desc');
        $data['view_file'] = 'news';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function std_list() {
        $section_id = $this->uri->segment(4);
        if (is_numeric($section_id) && $section_id != 0) {
            $data['news'] = $this->_get_std_list($section_id);
        }
        $data['view_file'] = 'std_list';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function create() {
        $update_id = $this->uri->segment(4);
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        if (is_numeric($update_id) && $update_id != 0) {
            $data['news'] = $this->_get_data_from_db($update_id);
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        
       $data['update_id'] = $update_id;
       $arr_program = Modules::run('program/_get_by_arr_id_programs',$org_id)->result_array();
        $arr_teacher = Modules::run('user/_get_by_arr_id_teacher')->result_array();
        $program = array();
        $teacher = array();

        foreach($arr_program as $row){
            $program[$row['id']] = $row['name'];   
        }
        foreach($arr_teacher as $row){
            $teacher[$row['id']] = $row['name'];
        }
       
        $data['program_title'] = $program;
        $data['teacher_title'] = $teacher;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
    
    function _get_data_from_db($update_id) {
        $where['sections.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['section'] = $row->section;
            $data['teacher_id'] = $row->teacher_id;
            $data['teacher_name'] = $row->teacher_name;
            $data['class_id'] = $row->class_id;
            $data['program_id'] = $row->program_id;
            $data['program_name'] = $row->program_name;
            $data['class_name'] = $row->class_name;
            $data['roll_to'] = $row->roll_to;
            $data['roll_from'] = $row->roll_from;
            $data['org_id'] = $row->org_id;
            $data['status'] = $row->status;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['section'] = $this->input->post('name');
        $data['teacher_id'] = $this->input->post('teacher_id');
        $data['class_id'] = $this->input->post('class_id');
        $data['program_id'] = $this->input->post('program_id');
        $data['roll_to'] = $this->input->post('roll_to');
        $data['roll_from'] = $this->input->post('roll_from');
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
                $this->session->set_flashdata('message', 'sections'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'sections');
        }

    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $this->_delete($delete_id, $org_id);
    }

    function set_publish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'sections/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'sections/manage/' . '');
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
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }



    function _getItemById($id) {
        $this->load->model('mdl_sections');
        return $this->mdl_sections->_getItemById($id);
    }
    function _set_publish($arr_col) {
        $this->load->model('mdl_sections');
        $this->mdl_sections->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_sections');
        $this->mdl_sections->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_sections');
        return $this->mdl_sections->_get($order_by);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_sections');
        return $this->mdl_sections->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_sections');
        return $this->mdl_sections->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_sections');
        $this->mdl_sections->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_sections');
        $this->mdl_sections->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_sections');
        $this->mdl_sections->_delete($arr_col, $org_id);
    }
    
    function _get_records($arr_col) {
        $this->load->model('mdl_sections');
        return $this->mdl_sections->_get_records($arr_col);
    }

    function _get_by_arr_id_roll($id) {
        $this->load->model('mdl_sections');
        return $this->mdl_sections->_get_by_arr_id_roll($id);
    }

    function _get_by_arr_id_class($class_id){
        $this->load->model('mdl_sections');
        return $this->mdl_sections->_get_by_arr_id_class($class_id);
    }

    function _get_std_list($section_id) {
        $this->load->model('mdl_sections');
        return $this->mdl_sections->_get_std_list($section_id);
    }
}