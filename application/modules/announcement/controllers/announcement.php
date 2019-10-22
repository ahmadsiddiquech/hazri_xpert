<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Announcement extends MX_Controller
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
        $where['announcement.id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['id'] = $row->id;
            $data['title'] = $row->title;
            $data['description'] = $row->description;
            $data['start_date'] = $row->start_date;
            $data['end_date'] = $row->end_date;
            $data['image'] = $row->image;
            $data['status'] = $row->status;
        }
        if(isset($data) && !empty($data))
            return $data;
    }
    
    function _get_data_from_post() {
        $data['title'] = $this->input->post('title');
        $data['description'] = $this->input->post('description');
        $data['start_date'] = $this->input->post('start_date');
        $data['end_date'] = $this->input->post('end_date');
        $user_data = $this->session->userdata('user_data');
        $data['org_id'] = $user_data['user_id'];
        return $data;

    }

    function submit() {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
            $user_data = $this->session->userdata('user_data');
            $org_id = $user_data['user_id'];
            if ($update_id != 0) {
                $itemInfo = $this->_getItemById($update_id, $org_id);
                $actual_img_old = FCPATH . 'uploads/announcement/actual_images/' . $itemInfo->image;
                $medium_img_old = FCPATH . 'uploads/announcement/medium_images/' . $itemInfo->image;
                $large_img_old = FCPATH . 'uploads/announcement/large_images/' . $itemInfo->image;
                if (isset($_FILES['news_file']['name']) && !empty($_FILES['news_file']['name'])) {
                    if (file_exists($actual_img_old))
                        unlink($actual_img_old);
                    if (file_exists($medium_img_old))
                        unlink($medium_img_old);
                    if (file_exists($large_img_old))
                        unlink($large_img_old);
                    $this->upload_image($update_id,$org_id);
                }
                $this->_update($update_id,$user_data['user_id'], $data);

            }
            else{
                $id = $this->_insert($data);
                $this->upload_image($id,$user_data['user_id']);
                $users = $this->_get_all_users($org_id)->result_array();
                if (isset($users) && !empty($users)) {
                    foreach ($users as $key => $value) {
                        if ($value['user_type'] == 'Parent') {
                            $data2['notif_for'] = 'Parent';
                        }
                        elseif ($value['user_type'] == 'Teacher') {
                            $data2['notif_for'] = 'Teacher';
                        }
                        $data2['user_id'] = $value['id'];
                        $data2['notif_title'] = $data['title'];
                        $data2['notif_description'] = $data['description'];
                        $data2['notif_type'] = 'announcement';
                        $data2['notif_sub_type'] = 'announcement';
                        $data2['type_id'] = $id;
                        date_default_timezone_set("Asia/Karachi");
                        $data2['notif_date'] = date('Y-m-d H:i:s');
                        $data2['org_id'] = $data['org_id'];
                        $nid = $this->_notif_insert_data($data2);
                        if (isset($value['fcm_token']) && !empty($value['fcm_token'])) {
                            $fcm_token[] = $value;
                            Modules::run('front/send_notification',$fcm_token,$nid,$data2['notif_title'],$data2['notif_description']);
                            unset($fcm_token);
                        }
                    }
                }
            }
            $this->session->set_flashdata('message', 'announcement'.' '.DATA_SAVED);
	        $this->session->set_flashdata('status', 'success');
            redirect(ADMIN_BASE_URL . 'announcement');
        }
    function delete() {
        $delete_id = $this->input->post('id');
        $user_data = $this->session->userdata('user_data');
        $org_id = $user_data['user_id'];
        $itemInfo = $this->_getItemById($delete_id, $org_id);
        $file = $itemInfo->image;
        unlink('./uploads/announcement/medium_images/' . $file);
        unlink('./uploads/announcement/large_images/' . $file);
        unlink('./uploads/announcement/actual_images/' . $file);
        $this->_delete($delete_id, $org_id);
    }

    function set_publish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_publish($where);
        $this->session->set_flashdata('message', 'Post published successfully.');
        redirect(ADMIN_BASE_URL . 'announcement/manage/' . '');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Post un-published successfully.');
        redirect(ADMIN_BASE_URL . 'announcement/manage/' . '');
    }
/////////////////////////Image Upload//////////////////////////////
    function upload_image($nId, $org_id) {
        $upload_image_file = $this->input->post('hdn_image');
        if(isset($upload_image_file) && !empty($upload_image_file)){
            $upload_image_file = str_replace(' ', '_', $upload_image_file);
            $file_name = 'announcement_' . $nId.'_'.$org_id . '_' . $upload_image_file;
        }
        else{
            $file_name ='';
        }
        $config['upload_path'] = './uploads/announcement/actual_images';
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
        $config['new_image'] = './uploads/announcement/large_images';
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
        $config['new_image'] = './uploads/announcement/medium_images';
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
        $config['new_image'] = './uploads/announcement/small_images';
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        $data = array('image' => $file_name);
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

    /////////////// for detail ////////////
    function detail() {
        $update_id = $this->input->post('id');
        $data['user'] = $this->_get_data_from_db($update_id);
        $this->load->view('detail', $data);
    }

///////////////////////////     HELPER FUNCTIONS    ////////////////////

    function _getItemById($id, $org_id) {
        $this->load->model('mdl_announcement');
        return $this->mdl_announcement->_getItemById($id, $org_id);
    }
    function _set_publish($arr_col) {
        $this->load->model('mdl_announcement');
        $this->mdl_announcement->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_announcement');
        $this->mdl_announcement->_set_unpublish($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_announcement');
        return $this->mdl_announcement->_get($order_by);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_announcement');
        return $this->mdl_announcement->_get_by_arr_id($arr_col);
    }
    function _insert($data) {
        $this->load->model('mdl_announcement');
        return $this->mdl_announcement->_insert($data);
    }

    function _update($arr_col, $org_id, $data) {
        $this->load->model('mdl_announcement');
        $this->mdl_announcement->_update($arr_col, $org_id, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_announcement');
        $this->mdl_announcement->_update_id($id, $data);
    }

    function _delete($arr_col, $org_id) {       
        $this->load->model('mdl_announcement');
        $this->mdl_announcement->_delete($arr_col, $org_id);
    }

    function _notif_insert_data($data2){
        $this->load->model('mdl_announcement');
        return $this->mdl_announcement->_notif_insert_data($data2);
    }

    function _get_all_users($org_id){
        $this->load->model('mdl_announcement');
        return $this->mdl_announcement->_get_all_users($org_id);
    }

    function _get_teacher_token($teacher_id,$org_id){
    $this->load->model('mdl_front');
    return $this->mdl_front->_get_teacher_token($teacher_id,$org_id);
    }

    function _get_parent_token($parent_id,$org_id){
        $this->load->model('mdl_front');
        return $this->mdl_front->_get_parent_token($parent_id,$org_id);
    }
}