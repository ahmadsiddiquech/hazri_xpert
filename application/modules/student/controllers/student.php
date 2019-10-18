<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Student extends MX_Controller
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
        $data['news'] = $this->_get('student.id desc');
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
            $data['class_data'] = $this->_get_class($data['news']['program_id'])->result_array();
            $data['setion_data'] = $this->_get_section($data['news']['class_id'],$data['news']['program_id'])->result_array();
            $roll_data = $this->_get_roll($data['news']['section_id'],$data['news']['class_id'],$data['news']['program_id'])->result_array();
            $data['roll_from'] = $roll_data[0]['roll_from'];
            $data['roll_to'] = $roll_data[0]['roll_to'];
            $data['subject_data'] = $this->_get_subject($data['news']['section_id'],$data['news']['class_id'],$data['news']['program_id'])->result_array();
        } else {
            $data['news'] = $this->_get_data_from_post();
        }
        $data['update_id'] = $update_id;
        $arr_parent = Modules::run('user/_get_by_arr_id_parent')->result_array();
        $arr_program = Modules::run('program/_get_by_arr_id_programs',$org_id)->result_array();
        $program = array();
        $parent = array();


        foreach($arr_program as $row){
            $program[$row['id']] = $row['name'];   
        }
        foreach($arr_parent as $row){
            $parent[$row['id']] = $row['name'];   
        }
        $data['program_title'] = $program;
        $data['parent_title'] = $parent;
        $data['view_file'] = 'newsform';
        $this->load->module('template');
        $this->template->admin($data);
    }
    function get_roll_no(){
        $sec_id = $this->input->post('id');
        $arr_roll = Modules::run('sections/_get_by_arr_id_roll',$sec_id)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
            for ($i=$arr_roll[0]['roll_from']; $i <=$arr_roll[0]['roll_to'] ; $i++) { 
                $html.='<option value='.$i.'>'.$i.'</option>';
            }
        echo $html; 
    }

    function get_class(){
        $program_id = $this->input->post('id');
        $arr_class = Modules::run('classes/_get_by_arr_id_program',$program_id)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_class as $key => $value) {
            $html.='<option value='.$value['id'].'>'.$value['name'].'</option>';
        }
        echo $html;
    }
    function get_subject(){
        $section_id = $this->input->post('id');
        $arr_subject = Modules::run('subjects/_get_by_arr_id_subject',$section_id)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_subject as $key => $value) {
            $html.='<option value='.$value['subject_id'].'>'.$value['subject_name'].'</option>';
        }
        echo $html;
    }

    function get_section(){
        $class_id = $this->input->post('id');
        $arr_class = Modules::run('sections/_get_by_arr_id_class',$class_id)->result_array();
        $html='';
        $html.='<option value="">Select</option>';
        foreach ($arr_class as $key => $value) {
            $html.='<option value='.$value['id'].'>'.$value['section'].'</option>';
        }
        echo $html;
    }

    function check_roll_no () {
        $roll_no = $this->input->post('id');
        $section_id = $this->input->post('section_id');
        $this->load->model('mdl_student');
        $check = $this->mdl_student->check_roll_no($roll_no,$section_id);
        if($check->num_rows()!=0){
            echo "true";
        }
        else{
            echo "false";
        }
    }

    function _get_data_from_db($update_id) {
        $where['student.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        $subject_id = $this->_get_subject_by_arr_id($update_id)->result_array();
        if(isset($subject_id) && !empty($subject_id)){
            $data['subject_id'] = $subject_id[0]['subject_id'];
            $data['subject_name'] = $subject_id[0]['subject_name'];
        }
        else{
            $data['subject_id'] = '';
        }
        $parent_id = $this->_get_parent_by_arr_id($update_id)->result_array();
        if(isset($parent_id) && !empty($parent_id)){
            $data['parent_id'] = $parent_id[0]['parent_id'];
        }
        else{
            $data['parent_id'] = '';
        }
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['name'] = $row->name;
            $data['parent_name'] = $row->parent_name;
            $data['p_c_no'] = $row->p_c_no;
            $data['gender'] = $row->gender;
            $data['dob'] = $row->dob;
            $data['address'] = $row->address;
            $data['addmission_date'] = $row->addmission_date;
            $data['class_name'] = $row->class_name;
            $data['class_id'] = $row->class_id;
            $data['program_name'] = $row->program_name;
            $data['program_id'] = $row->program_id;
            $data['section_name'] = $row->section_name;
            $data['section_id'] = $row->section_id;
            $data['roll_no'] = $row->roll_no;
            $data['tution_fee'] = $row->tution_fee;
            $data['transport_fee'] = $row->transport_fee;
            $data['lunch_fee'] = $row->lunch_fee;
            $data['stationary_fee'] = $row->stationary_fee;
            $data['other_fee'] = $row->other_fee;
            $data['image'] = $row->image;
            $data['status'] = $row->status;
            $data['org_id'] = $row->org_id;
        }
        if(isset($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['name'] = $this->input->post('name');
        $data['parent_name'] = $this->input->post('parent_name');
        $data['parent_id'] = $this->input->post('parent_id');
        $data['p_c_no'] = $this->input->post('p_c_no');
        $data['dob'] = $this->input->post('dob');
        $data['gender'] = $this->input->post('gender');
        $data['address'] = $this->input->post('address');
        $data['addmission_date'] = $this->input->post('addmission_date');
        $data['class_id'] = $this->input->post('class_id');
        $data['program_id'] = $this->input->post('program_id');
        $data['section_id'] = $this->input->post('section_id');
        $data['subject_id'] = $this->input->post('subject_id');
        $data['roll_no'] = $this->input->post('roll_no');
        $data['transport_fee'] = $this->input->post('transport_fee');
        $data['tution_fee'] = $this->input->post('tution_fee');
        $data['stationary_fee'] = $this->input->post('stationary_fee');
        $data['lunch_fee'] = $this->input->post('lunch_fee');
        $data['other_fee'] = $this->input->post('other_fee');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;

    }

    function submit() {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            // print_r($data);exit();
            $user_data = $this->session->userdata('user_data');
            if ($update_id != 0) {
                $itemInfo = $this->_getItemById($update_id);
                $actual_img_old = FCPATH . 'uploads/student/actual_images/' . $itemInfo->image;
                $medium_img_old = FCPATH . 'uploads/student/medium_images/' . $itemInfo->image;
                $large_img_old = FCPATH . 'uploads/student/large_images/' . $itemInfo->image;
                if (isset($_FILES['news_file']['name']) && !empty($_FILES['news_file']['name'])) {
                    if (file_exists($actual_img_old))
                        unlink($actual_img_old);
                    if (file_exists($medium_img_old))
                        unlink($medium_img_old);
                    if (file_exists($large_img_old))
                        unlink($large_img_old);
                    $this->upload_image($update_id,$user_data['user_id']);
                }
                $this->_update($update_id,$user_data['user_id'], $data);
            }
            else
            {
                $id = $this->_insert($data);
                $this->upload_image($id,$user_data['user_id']);
            }
                $this->session->set_flashdata('message', 'student'.' '.DATA_SAVED);										
		        $this->session->set_flashdata('status', 'success');
            
            redirect(ADMIN_BASE_URL . 'student');
    }


    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $itemInfo = $this->_getItemById($delete_id);
        $file = $itemInfo->image;
        unlink('./uploads/student/medium_images/' . $file);
        unlink('./uploads/student/large_images/' . $file);
        unlink('./uploads/student/actual_images/' . $file);
        $this->_delete($delete_id, $org_id);
    }

    function set_publish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'student/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'student/manage/' . '');
    }


    function upload_image($nId, $org_id) {
        $upload_image_file = $this->input->post('hdn_image');
        if(isset($upload_image_file) && !empty($upload_image_file)){
            $upload_image_file = str_replace(' ', '_', $upload_image_file);
            $file_name = 'student_' . $nId.'_'.$org_id . '_' . $upload_image_file;
        }
        else{
            $file_name = '';
        }
        $config['upload_path'] = './uploads/student/actual_images';
        $config['allowed_types'] = '*';
        $config['max_size'] = '20000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (isset($_FILES['news_file'])) {
            $this->upload->do_upload('news_file');
        }
        $upload_data = $this->upload->data();

        /////////////// Large  Image ////////////////
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = true;
        $config['width'] = 500;
        $config['height'] = 400;
        $config['new_image'] = './uploads/student/large_images';
        $this->load->library('image_lib');
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        /////////////  Medium Size /////////////////// 
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = true;
        $config['width'] = 300;
        $config['height'] = 200;
        $config['new_image'] = './uploads/student/medium_images';
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();

        ////////////////////// Small Size ////////////////
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = 100;
        $config['height'] = 100;
        $config['new_image'] = './uploads/student/small_images';
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        $data = array('image' => $file_name);
        // $where['id'] = $nId;
        $rsItem = $this->_update($nId, $org_id, $data);
        if ($rsItem)
            return true;
        else
            return false;
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

    function get_subect_teacher_name($update_id){
        $where['student.id'] = $update_id;
        return $this->_get_subject_teacher_detail($where)->result_array();
    }

    /////////////// for detail ////////////
    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $data['subject'] = $this->get_subect_teacher_name($update_id);
        $this->load->view('detail', $data);
    }
	
    function _getItemById($id) {
        $this->load->model('mdl_student');
        return $this->mdl_student->_getItemById($id);
    }


    function _set_publish($arr_col) {
        $this->load->model('mdl_student');
        $this->mdl_student->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_student');
        $this->mdl_student->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_student');
        return $this->mdl_student->_get($order_by);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_by_arr_id($arr_col);
    }


    function _insert($data) {
        $this->load->model('mdl_student');
        return $this->mdl_student->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_student');
        $this->mdl_student->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_student');
        $this->mdl_student->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_student');
        $this->mdl_student->_delete($arr_col, $org_id);
    }

    function _get_subject_by_arr_id($update_id){
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_subject_by_arr_id($update_id);
    }
    function _get_parent_by_arr_id($update_id){
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_parent_by_arr_id($update_id);
    }

    function _get_by_arr_id_section($section_id){
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_by_arr_id_section($section_id);
    }

    function _get_class($program_id){
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_class($program_id);
    }

    function _get_section($class_id,$program_id){
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_section($class_id,$program_id);
    }
    function _get_roll($section_id,$class_id,$program_id){
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_roll($section_id,$class_id,$program_id);
    }
    function _get_subject($section_id,$class_id,$program_id){
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_subject($section_id,$class_id,$program_id);
    }

    function _get_subject_teacher_detail($where){
        $this->load->model('mdl_student');
        return $this->mdl_student->_get_subject_teacher_detail($where);
    }
}