<?php



if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects extends MX_Controller

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

        $data['news'] = $this->_get('subject.id desc');

        $data['view_file'] = 'news';

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

        $arr_teacher = Modules::run('user/_get_by_arr_id_teacher')->result_array();

        $arr_program = Modules::run('program/_get_by_arr_id_programs',$org_id)->result_array();

        // print_r($arr_roles);exit();

        $teacher = array();

        $program = array();



        foreach($arr_teacher as $row){

            $teacher[$row['id']] = $row['name'];

            

        }



        foreach($arr_program as $row){

            $program[$row['id']] = $row['name'];

        }

       

        $data['teacher_title'] = $teacher;

        $data['program_title'] = $program;

        $data['view_file'] = 'newsform';

        $this->load->module('template');

        $this->template->admin($data);

    }



    function _get_data_from_db($update_id) {

        $where['subject.id'] = $update_id;

        //$where['post.lang_id'] = $lang_id;

        $query = $this->_get_by_arr_id($where);

        foreach ($query->result() as

                $row) {

            $data['id'] = $row->id;

            $data['name'] = $row->name;

            $data['section_id'] = $row->section_id;

            $data['section_name'] = $row->section_name;

            $data['class_id'] = $row->class_id;

            $data['class_name'] = $row->class_name;

            $data['program_id'] = $row->program_id;

            $data['program_name'] = $row->program_name;

            $data['teacher_id'] = $row->teacher_id;

            $data['teacher_name'] = $row->teacher_name;

            $data['s_type'] = $row->s_type;

            $data['org_id'] = $row->org_id;

            $data['status'] = $row->status;

        }

        if(isset($data))

            return $data;

    }

    

    function _get_data_from_post() {

        $data['name'] = $this->input->post('name');

        $data['section_id'] = $this->input->post('section_id');

        $data['class_id'] = $this->input->post('class_id');

        $data['program_id'] = $this->input->post('program_id');

        $data['teacher_id'] = $this->input->post('teacher_id');

        $data['s_type'] = $this->input->post('s_type');

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

                $this->session->set_flashdata('message', 'subjects'.' '.DATA_SAVED);										

		        $this->session->set_flashdata('status', 'success');

            

            redirect(ADMIN_BASE_URL . 'subjects');

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

        redirect(ADMIN_BASE_URL . 'subjects/manage/' . '');

    }



    function set_unpublish() {

        $update_id = $this->uri->segment(4);

        //$lang_id = $this->uri->segment(5);

        $where['id'] = $update_id;

        //$where['lang_id'] = $lang_id;

        $this->_set_unpublish($where);

        $this->session->set_flashdata('message', 'Post un-published successfully.');

        redirect(ADMIN_BASE_URL . 'subjects/manage/' . '');

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

	

    function _getItemById($id) {

        $this->load->model('mdl_subject');

        return $this->mdl_subject->_getItemById($id);

    }



    function _set_publish($arr_col) {

        $this->load->model('mdl_subject');

        $this->mdl_subject->_set_publish($arr_col);

    }



    function _set_unpublish($arr_col) {

        $this->load->model('mdl_subject');

        $this->mdl_subject->_set_unpublish($arr_col);

    }



    function _get($order_by) {

        $this->load->model('mdl_subject');

        $query = $this->mdl_subject->_get($order_by);

        return $query;

    }



    function _get_by_arr_id($arr_col) {

        $this->load->model('mdl_subject');

        return $this->mdl_subject->_get_by_arr_id($arr_col);

    }

    

    function _insert($data) {

        $this->load->model('mdl_subject');

        return $this->mdl_subject->_insert($data);

    }



    function _update($arr_col, $org_id, $data) {

        $this->load->model('mdl_subject');

        $this->mdl_subject->_update($arr_col, $org_id, $data);

    }



    function _update_id($id, $data) {

        $this->load->model('mdl_subject');

        $this->mdl_subject->_update_id($id, $data);

    }



    function _delete($arr_col, $org_id) {       

        $this->load->model('mdl_subject');

        $this->mdl_subject->_delete($arr_col, $org_id);

    }



    function _custom_query($mysql_query) {

        $this->load->model('mdl_subject');

        $query = $this->mdl_subject->_custom_query($mysql_query);

        return $query;

    }

    function _get_by_arr_id_subject($section_id) {

        $this->load->model('mdl_subject');

        return $this->mdl_subject->_get_by_arr_id_subject($section_id);

    }

    function _get_subject($section_id) {

        $this->load->model('mdl_subject');

        return $this->mdl_subject->_get_subject($section_id);

    }



    function _get_subject_class($class_id){

        $this->load->model('mdl_subject');

        return $this->mdl_subject->_get_subject_class($class_id);

    }

    function _get_subject_section($section_id){

        $this->load->model('mdl_subject');

        return $this->mdl_subject->_get_subject_section($section_id);

    }

    function _get_subject_teacher($subject_id,$org_id) {

        $this->load->model('mdl_subject');

        return $this->mdl_subject->_get_subject_teacher($subject_id,$org_id);

    }



}