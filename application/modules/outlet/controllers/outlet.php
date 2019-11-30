<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Outlet extends MX_Controller
{

function __construct() {
    //echo 'this abc=====>>';exit;
	parent::__construct();
	Modules::run('site_security/is_login');
	//Modules::run('site_security/has_permission');
}

function index(){
        $data['outlet'] = $this->_get_all_details('id')->result_array();
        $data['view_file'] = 'outlet';
        $this->load->module('template');
        $this->template->admin($data);
	
}
function delete(){
        $id = $this->input->post('id');
        $this->load->model('mdl_outlet');
        $this->mdl_outlet->_delete($id);
    }

function create(){	
        $update_id = $this->uri->segment(4);

         if (is_numeric($update_id) && $update_id != 0) {

            $data['outlet'] = $this->_get_data_from_db($update_id);
        } else {
            $data['outlet'] = $this->_get_data_from_post();
        }
        
        $package = Modules::run('package/_get', 'id asc');
        $arr_package = array();
        foreach($package->result() as $row){
            $arr_package[$row->id]=$row->title;
        }
		$data['package_title'] = $arr_package;
        $data['is_reg'] = $this->_get_enum('is_registred');
        $data['update_id'] = $update_id;
        $data['view_file'] = 'outletform';
        $this->load->module('template');
        $this->template->admin_form($data);
}

function submit() {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('txtBuildingName', 'Bulding Name', 'required|xss_clean');
    if ($this->form_validation->run() == FALSE) {
            $this->create();
        }else {
	        $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();

            if (is_numeric($update_id) && $update_id != 0) {
                $where['id'] = $update_id;
                $itemInfo = $this->_getItemById($update_id);
                $actual_img_old = FCPATH . ACTUAL_OUTLET_IMAGE_PATH . $itemInfo->image;
                $small_img_old = FCPATH . SMALL_OUTLET_IMAGE_PATH . $itemInfo->image;
                $medium_img_old = FCPATH . MEDIUM_OUTLET_IMAGE_PATH . $itemInfo->image;
                $large_img_old = FCPATH . LARGE_OUTLET_IMAGE_PATH . $itemInfo->image;
                $this->_update($where, $data);
                if (isset($_FILES['outlet_file']['name']) && $_FILES['outlet_file']['name'] != '') {
                    if (file_exists($actual_img_old))
                        unlink($actual_img_old);
                    if (file_exists($small_img_old))
                        unlink($small_img_old);
                    if (file_exists($medium_img_old))
                        unlink($medium_img_old);
                    if (file_exists($large_img_old))
                        unlink($large_img_old);
                    $this->upload_image($update_id);
                }
                $this->load->library('session');
                $this->session->set_flashdata('message', 'Mosque'.' '.DATA_UPDATED);                                     
                $this->session->set_flashdata('status', 'success');
            }
		else {
			                                     
			$data = $this->_get_data_from_post();
            $id = $this->_insert($data);
			$this->upload_image($id);
    		$data['outlet'] = $this->_get()->result_array();
            $data['view_file'] = 'outlet';
            $this->load->module('template');
            $this->template->admin($data);
            }
            $this->load->library('session');
            $this->session->set_flashdata('message', 'Mosque'.' '.DATA_SAVED);                                     
            $this->session->set_flashdata('status', 'success');
        }		 
        redirect(ADMIN_BASE_URL . 'outlet');
    }

    function load_listing() 
        {
            $data['outlet'] = $this->_get('id ASC')->result_array();
            $this->load->view('outlet_listing',$data);       
        }

   function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['building_name'] = $row->building_name;
            $data['address'] = $row->address;
            $data['country'] = $row->country;
            $data['city'] = $row->city;
            $data['state'] = $row->state;
            $data['zip'] = $row->zip;
            $data['email'] = $row->email;
            $data['phone'] = $row->phone;
            $data['url'] = $row->url;
            $data['longitude'] = $row->longitude;
            $data['latitude'] = $row->latitude;
            $data['distance'] = $row->distance;
            $data['image'] = $row->image;
           // print_r($data); exit();
        }
        return $data;
    }

    function detail() 
    {
        $update_id = $this->input->post('id');
        $data['mosque'] = $this->_get_data_from_db($update_id);
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

   function _get_data_from_post() {
        $data['type'] = 'mosque';
        $data['building_name'] = $this->input->post('txtBuildingName');
        $data['address'] = $this->input->post('txtAddress');
        $data['country'] = $this->input->post('txtCountry');
        $data['city'] = $this->input->post('txtCity');
        $data['state'] = $this->input->post('txtState');
        $data['zip'] = $this->input->post('txtZip');
        $data['email'] = $this->input->post('txtEmail');
        $data['url'] = $this->input->post('txtUrl');
        $data['phone'] = $this->input->post('txtPhone');
        $data['longitude'] = $this->input->post('txtLongitude');
        $data['latitude'] = $this->input->post('txtLatitude');
        $data['distance'] = $this->input->post('txtDistance');
        $data['image'] = $this->input->post('hdn_image');
        $data['package_type'] = $this->input->post('package_id');
        $data['is_registred'] = $this->input->post('is_registred');

        
        return $data;
    }

/////////////////////////Image Upload//////////////////////////////
        function upload_image($nId) {
        $upload_image_file = $this->input->post('hdn_image');
        $upload_image_file = str_replace(' ', '_', $upload_image_file);
        $file_name = 'post_' . $nId . '_' . $upload_image_file;
        $config['upload_path'] = ACTUAL_OUTLET_IMAGE_PATH;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '20000';
        $config['max_width'] = '0';
        $config['max_height'] = '0';
        $config['file_name'] = $file_name;
        $this->load->library('upload');
        $this->upload->initialize($config);
        //delete existing image
//      print_r($config);
/*      print_r($_FILES['outlet_file']);
      exit;*/
        if (isset($_FILES['outlet_file'])) {
            $this->upload->do_upload('outlet_file');
        }
        $upload_data = $this->upload->data();

        /////////////// Large Image ////////////////
        $config['source_image'] = $upload_data['full_path'];
        $config['image_library'] = 'gd2';
        $config['maintain_ratio'] = true;
        $config['width'] = 500;
        $config['height'] = 400;
        $config['new_image'] = LARGE_OUTLET_IMAGE_PATH;
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
        $config['new_image'] = MEDIUM_OUTLET_IMAGE_PATH;
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
        $config['new_image'] = SMALL_OUTLET_IMAGE_PATH;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
        $this->image_lib->clear();
        $data = array('image' => $file_name);
        $where['id'] = $nId;
        $rsItem = $this->_update($where, $data);
        if ($rsItem)
            return true;
        else
            return false;
    }

    function delete_images() {
        $file = $this->input->post('image');
        $nId = $this->input->post('id');
        $this->load->helper("file");
        unlink(SMALL_OUTLET_IMAGE_PATH . $file);
        unlink(MEDIUM_OUTLET_PATH . $file);
        unlink(LARGE_OUTLET_IMAGE_PATH . $file);
        unlink(ACTUAL_OUTLET_IMAGE_PATH . $file);
        $data = array('image' => "");
        $where['id'] = $nId;
        $this->_update($where, $data);
        return true;
    }


////////////////////////////////////////////////
function _get_enum($field){
        $type = $this->db->query( "SHOW COLUMNS FROM outlet WHERE Field = '{$field}'" )->row( 0 )->Type;
        preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
        $enum = explode("','", $matches[1]);
        $records = array();
        foreach ($enum as $value) {
                $records[$value] = $value;
            }
        return $records;
    }


function _get_contact($outlet_id){
$this->load->model('mdl_outlet');
return $this->mdl_outlet->_get_contact($outlet_id);  
}
function _get_all_details($order_by) {
        $this->load->model('mdl_outlet');
        $query = $this->mdl_outlet->_get_all_details($order_by);
        return $query;
    }
function _getItemById($id) {
$this->load->model('mdl_outlet');
return $this->mdl_outlet->_getItemById($id);
}

function _get($order_by='id asc'){
$this->load->model('mdl_outlet');
$query = $this->mdl_outlet->_get($order_by);
return $query;
}

function _get_by_arr_id($arr_col) {
$this->load->model('mdl_outlet');
return $this->mdl_outlet->_get_by_arr_id($arr_col);
}
function _get_with_limit($limit, $offset, $order_by='id asc') {
$this->load->model('mdl_outlet');
$query = $this->mdl_outlet->_get_with_limit($limit, $offset, $order_by);
return $query;
}

function _get_where($id){
   // print 'this ======111>'; 
$this->load->model('mdl_outlet');
//print 'this ======111>';exit;
$query = $this->mdl_outlet->_get_where($id);
return $query;
}

function _get_where_cols($cols,$order_by='id asc'){
$this->load->model('mdl_outlet');
$query = $this->mdl_outlet->_get_where_cols($cols,$order_by);
return $query;
}

function _get_where_custom($col, $value,$order_by='id asc') {
$this->load->model('mdl_outlet');
$query = $this->mdl_outlet->_get_where_custom($col, $value,$order_by);
return $query;
}

function _insert($data){
$this->load->model('mdl_outlet');
return $this->mdl_outlet->_insert($data);
}

function _update($id, $data){
$this->load->model('mdl_outlet');
$this->mdl_outlet->_update($id, $data);
}

function _update_where_cols($cols, $data){
$this->load->model('mdl_outlet');
$this->mdl_outlet->_update_where_cols($cols, $data);
}

function _delete($id){
$this->load->model('mdl_outlet');
$this->mdl_outlet->_delete($id);
}

function _count_where($column, $value) {
$this->load->model('mdl_outlet');
$count = $this->mdl_outlet->_count_where($column, $value);
return $count;
}

function _get_max() {
$this->load->model('mdl_outlet');
$max_id = $this->mdl_outlet->_get_max();
return $max_id;
}

function _custom_query($mysql_query) {
$this->load->model('mdl_outlet');
$query = $this->mdl_outlet->_custom_query($mysql_query);
return $query;
}

}