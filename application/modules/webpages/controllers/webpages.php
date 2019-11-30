<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Webpages extends MX_Controller
{

function __construct() {

parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

    function index() {
        $this->manage();
    }

    function load_listing() {
        $data['webpages'] = $this->_get('id ASC');
        $this->load->view('webpages_listing',$data);      
}
    function manage() {
        $where['parent_id'] = 0;
//////////////////////pagination//////////////////////////////////////
        $this->load->library('pagination');
        $segment = intval($this->uri->segment(5));
        $config['base_url'] = ADMIN_BASE_URL . 'webpages/manage/';
        $config['total_rows'] = $this->_count_where($where, 'page_type_id asc');
        $config['per_page'] = LIMIT;
        $config['uri_segment'] = 5;
        $config['full_tag_open'] = '<ul class="pagination genral">';
        $config['num_links'] = NUM_LINKS;
        $config['full_tag_close'] = '</ul>';
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
//////////////////////////////////////////////////////////////////////////////////////////
        $data['query'] = $this->_get_records_by_lang_id(LIMIT, $segment, $where, 'is_home desc, id desc');
        $outlet_id = DEFAULT_OUTLET;
        $is_static = 0;
        $data['record'] = $this->_get_where($outlet_id, $is_static)->result_array();
        $data['view_file'] = 'manage';
        $this->load->module('template');
        $this->template->admin($data);
    }


    function create() {
        //session_start();
        $_SESSION['module'] = "webpages";
        $update_id = $this->uri->segment(4);
        if (is_numeric($update_id) && $update_id != 0) {
            $data['webpage'] = $this->_get_data_from_db($update_id);
        } else {
            $data['webpage'] = $this->_get_data_from_post();
        }
        $data['update_id'] = $update_id;
        $data['view_file'] = 'create';
        for ($i = 1;
                $i <= 30;
                $i++) {
            $resultRank[$i] = $i;
        }
        $data['rank'] = $resultRank;
        $this->load->module('template');
        $this->template->admin_form($data);
    }

/////////////// for detail ////////////

    function detail() { 
        $update_id = $this->input->post('id');
        $data['sub_pages_details'] = $this->_get_data_from_db($update_id);
        $data['update_id'] = $update_id;
        $this->load->view('detail', $data);
    }

////////////////////////////////////////////////

    function submit() {
            $update_id = $this->uri->segment(4);
           $data = $this->_get_data_from_post();            
            if ($update_id!= 0) {
                $check_slug = $this->check_slug_edit($data['url_slug'], $update_id);             
                if ($check_slug == 1) {
                    $this->session->set_flashdata('message', 'Webpage Url already extis.');
                     $this->session->set_flashdata('status', 'danger');
                } else {
                    $where['id'] = $update_id;
                 
                    $this->_update($where, $data);
                   $this->session->set_flashdata('message', 'Webpage updated successfully.');
                    $this->session->set_flashdata('status', 'success');
             }
            }
           
            if ($update_id == 0) {
               
                $check_slug = $this->check_slug($data['url_slug']);
                if ($check_slug == 1) {
                   $this->session->set_flashdata('message', 'Webpage Url already extis.');
                    $this->session->set_flashdata('status', 'danger');
                } else {
                    $this->_insert($data);
                    $this->session->set_flashdata('message', 'Webpage saved successfully.');
                     $this->session->set_flashdata('status', 'success');
                }
            }
           // print 'this =====>';exit;
            //print 'this =====>'.ADMIN_BASE_URL . 'webpages';exit;
            redirect(ADMIN_BASE_URL.'webpages');
            exit;

        
    }
    function check_slug($url_slug) {
        $check = $this->_get_by_url_slug($url_slug);
        if ($check > 0)
            return true;
        else
            return false;
    }

    function check_slug_edit($url_slug, $id) {
        $check = $this->_get_by_url_slug_edit($url_slug, $id);
        if ($check > 0)
            return true;
        else
            return false;
    }

////////////////////// START MANAGE SUB WEBPAGES //////////////////////////////////

    function manage_sub_pages() {
        $parent_id = $this->uri->segment(4);
        $name = $this->uri->segment(5);
        $whereParent['id'] = $parent_id;
        $where['parent_id'] = $parent_id;
        $this->load->library('pagination');
        $segment = intval($this->uri->segment(6));
        $config['base_url'] = ADMIN_BASE_URL . 'webpages/manage_sub_pages/' . $parent_id ;
        $config['total_rows'] = $this->_count_where_sub_pages($where, 'page_title asc');
        $config['per_page'] = LIMIT;
        $config['uri_segment'] = 6;
        $config['full_tag_open'] = '<ul class="pagination genral">';
        $config['num_links'] = NUM_LINKS;
        $config['full_tag_close'] = '</ul>';
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        $data['query'] = $this->_get_sub_pages($where, 'page_rank asc');        
        $data['record'] = $this->_get_records($where);
        $query = $this->_get_by_arr_id($whereParent, 'id desc');
        $data['ParentPageDetails'] = $query->row_array();
        $data['view_file'] = 'manage_sub_pages';
        $this->load->module('template');
        $this->template->admin($data);
    }
    
    function create_sub_page() {
        $is_edit = 0;
        $parent_id = $this->uri->segment(4);
        $where['parent_id'] = $parent_id;
        $whereParent['id'] = $parent_id;
        $self_id = $this->uri->segment(5);
        $data['page_title'] = $self_id;
        $data['query'] = $this->_get_sub_pages($where, 'page_rank asc');
        $data['record'] = $this->_get_records($where);
        $query = $this->_get_by_arr_id($whereParent, 'id desc');        
        $data['ParentPageDetails'] = $query->row_array();
        $data['ParentId'] = $parent_id;
        if ($self_id > 0) {
            $data['webpage'] = $this->_get_data_from_db($self_id);          
        } else {
            $data['webpage'] = $this->_get_data_from_post();
        }
        $data['parent_id'] = $parent_id;
        $data['update_id'] = $self_id;
        $data['view_file'] = 'create_sub_page';
        for ($i = 1;
                $i <= 30;
                $i++) {
            $resultRank[$i] = $i;
        }
        $data['rank'] = $resultRank;
        $this->load->module('template');
        $this->template->admin_form($data);
    }


    function submit_sub_page() {
        $update_id = 0;
            $update_id = $this->uri->segment(5);
            $data = $this->_get_data_from_post();
            if ($update_id && $update_id != 0) {
                $where['id'] = $update_id;
                $this->_update($where, $data);
                $this->session->set_flashdata('message', 'Sub page successfully updated');
                 $this->session->set_flashdata('status', 'success');
            }
            if ($update_id  == 0) {
                $this->_insert($data);
                $this->session->set_flashdata('message', 'Sub page successfully saved');
                 $this->session->set_flashdata('status', 'success');

            }
            

         $data['parent_id'] = $this->uri->segment(4);
        // print 'parent id -====>>'.$data['parent_id'];
        redirect(ADMIN_BASE_URL . 'webpages/manage_sub_pages/'.$data['parent_id'] );
    }

    function change_status_sub_pages() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 1)
            $status = 0;
        else
            $status = 1;
        $data = array('is_publish' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
        exit;
    }

////////////////////// END MANAGE SUB WEBPAGES //////////////////////////////////
    function check_page_title(){
        $page_title = $this->input->post('page_title');
        $id = $this->input->post('id');
        $str_where = 'page_title = "'.$page_title.'"';
        if ($id != '') $str_where .= ' and id != '.$id;
        $str_query = ' Select * from webpages where '.$str_where;
        $result = $this->_custom_query($str_query)->num_rows();
        if($result > 0)
            echo true;
        else
            echo false;
    }

    function check_page_url(){
        $url_slug = $this->input->post('url_slug');
        $id = $this->input->post('id');
        $str_where = 'url_slug = "'.$url_slug.'"';
        if ($id != '') $str_where .= ' and id != '.$id;
        $str_query = ' Select * from webpages where '.$str_where;
        $result = $this->_custom_query($str_query)->num_rows();
        if($result > 0)
            echo true;
        else
            echo false;
    }
    
    function delete() {
        $parent_id = $this->input->post('id');
        $where_sub_pages['parent_id'] = $parent_id;
        $result = $this->_delete($where_sub_pages);
        $where_main_page['id'] = $parent_id; 
        $result = $this->_delete($where_main_page);
    }
    function delete_sub_pages() {
        $parent_id = $this->input->post('id');
        $where_sub_pages['id'] = $parent_id;
        $result = $this->_delete($where_sub_pages);
    }
    function set_home_page() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_home($where);
        redirect(ADMIN_BASE_URL . 'webpages');
    }

    function change_top_panel_pages() {
        $update_id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 1) {
            $where['id'] = $update_id;
            $this->_remove_toppanel($where);
            echo "removed";
            exit;
        }else{
        $where['id'] = $update_id;
        $where2['show_in_toppanel'] = 1;
        $record = $this->_get_by_arr_id($where2) -> num_rows();
        if ($record >= 5 ) {
            echo 0;
            exit;   
        }
        else{
            $this->_show_toppanel($where);
             echo "add";
             exit;
        }
          
         
        redirect(ADMIN_BASE_URL . 'webpages');
        }
    }

    function show_toppanel() {
        $update_id = $this->input->post('id');
        $status = $this->input->post('status');
        $where['id'] = $update_id;
        $where2['show_in_toppanel'] = 1;
        $where2['page_type_id'] = 1;
        $record = $this->_get_by_arr_id($where2);
        $where3['is_publish'] = 1;
        $this->load->model('mdl_webpages');
        $record2 = $this->mdl_webpages->_get_static_published_pages($where3);
        $total_records = $record2->num_rows + $record->num_rows;
        if ($total_records < 6) {
            $this->_show_toppanel($where);
            $this->session->set_flashdata('message', 'Page showed in top-panel successfully.');
        } else {
            $this->session->set_flashdata('warning', 'More than 6 pages cannot be showed for top-panel.');
        }
        redirect(ADMIN_BASE_URL . 'webpages');
    }

    function change_footer_panel_pages() {      
        $id = $this->input->post('id');
        $status = $this->input->post('status');
      
        if ($status == 1)
            $status = 0;
        else
            $status = 1;
        $data = array('show_in_footer' => $status);
        print_r($data); exit;
        $status = $this->_update_id($id, $data);
        echo 'ok';
    }
   

    function set_publish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;

        $where2['show_in_toppanel'] = 1;
        $where2['page_type_id'] = 1;
        $record = $this->_get_by_arr_id($where2);

        $where3['is_publish'] = 1;
        $this->load->model('mdl_webpages');
        $record2 = $this->mdl_webpages->_get_static_published_pages($where3);
        $total_records = $record2->num_rows + $record->num_rows;
        if ($total_records < 6) {
            $this->_set_publish($where);
            $this->session->set_flashdata('message', 'Page published successfully.');
        } else {
            $this->session->set_flashdata('warning', 'More than 6 pages cannot be published for top-panel.');
        }
        redirect(ADMIN_BASE_URL . 'webpages');
    }

    function set_unpublish() {
        $update_id = $this->uri->segment(4);
        $where['id'] = $update_id;
        $this->_set_unpublish($where);
        $this->session->set_flashdata('message', 'Page un-published successfully.');
        redirect(ADMIN_BASE_URL . 'webpages');
    }
//////////////////  HELPER FUNCTIONS /////////////////////////
    function _get_data_from_db($update_id) {
        $where['id'] = $update_id;
        
        $query = $this->_get_by_arr_id($where);
        foreach ($query->result() as
                $row) {
            $data['page_title'] = $row->page_title;
            $data['meta_description'] = $row->meta_description;
            $data['page_content'] = $row->page_content;
            $data['page_rank'] = $row->page_rank;
            $data['is_publish'] = $row->is_publish;
            
            $data['url_slug'] = $row->url_slug;
            $data['show_in_toppanel'] = $row->show_in_toppanel;
            $data['is_publish'] = $row->is_publish;
        }
        return $data;
    }

    function _get_data_from_post() {
        $data['page_title'] = $this->input->post('txtPageTitle');
        $page_url = $this->input->post('txtPageUrl');
        $page_title = $this->input->post('txtPageTitle');
        if (empty($page_url)) {
            $url_slug = $page_title;
            $url_slug = url_title($url_slug, '-', true);
        } else {
            $url_slug = $page_url;
            $url_slug = url_title($url_slug, '-', true);
        }
        $data['url_slug'] = $url_slug;
        $data['meta_keywords'] = $this->input->post('txtMetaKW');
        $data['meta_description'] = $this->input->post('txtMetaDesc');
        $data['page_content'] = $this->input->post('txtPageCont');
        $data['page_rank'] = $this->input->post('lstRank');
        $data['parent_id'] = $this->input->post('hdnParentId');
       
        $data['page_type_id'] = 1;
        return $data;
    }

    function _get_data_from_translate_post() {
        $data['id'] = $this->input->post('hdnId');
        $data['page_title'] = $this->input->post('txtPageTitle');
        $page_url = $this->input->post('txtPageUrl');
        $page_title = $this->input->post('txtPageTitle');
        if (empty($page_url)) {
            $url_slug = $page_title;
            $url_slug = url_title($url_slug, '-', true);
        } else {
            $url_slug = $page_url;
            $url_slug = url_title($url_slug, '-', true);
        }
        $data['url_slug'] = $url_slug;
        $data['meta_keywords'] = $this->input->post('txtMetaKW');
        $data['meta_description'] = $this->input->post('txtMetaDesc');
        $data['page_content'] = $this->input->post('txtPageCont');
        $data['page_rank'] = $this->input->post('lstRank');
        $data['parent_id'] = $this->input->post('hdnParentId');
        
        $data['page_type_id'] = 1;
        return $data;
    }

    function _get_data_from_post_multi() {
        $data['id'] = $this->input->post('chkId');
        $data['btn_publish'] = $this->input->post('btnPublish');
        $data['btn_unpublish'] = $this->input->post('btnUnPublish');
        $data['btn_delete'] = $this->input->post('btnDelete');
        return $data;
    }

    function _get_data_from_post_search() {
        $data['page_title'] = $this->input->post('txtSearch');
        return $data;
    }

    function translate() {
        $update_id = $this->uri->segment(4);
      
        $query = Modules::run('lang/_get_lang_record_by_id', $translate_lang_id);
        foreach ($query->result() as
                $lang) {
            $result[$lang->id] = $lang->lang_name;
        }
        $data['languages'] = $result;
        if (!isset($lang_id) || !is_numeric($lang_id)) {
            $lang_id = DEFAULT_LANG; // default_lang_id
            $data['lang_id'] = $lang_id;
        } else {
            $data['lang_id'] = $lang->id;
        }


        if (is_numeric($update_id) && is_numeric($lang_id)) {
            $data['webpage'] = $this->_get_data_from_db($update_id, $lang_id);
            //print_r($data['webpage']);
        } else {
            $data['webpage'] = $this->_get_data_from_post();
        }
        $data['update_id'] = $update_id;
        $data['view_file'] = 'page_translate_form';
        $this->load->module('template');
        $this->template->admin($data);
    }

    function translate_submit() {

        $this->load->library('form_validation');
        $this->form_validation->set_rules('txtPageTitle', 'Page Title', 'required|xss_clean');
        $this->form_validation->set_rules('txtMetaKW', 'Meta Keywords', 'required|xss_clean');
        $this->form_validation->set_rules('txtMetaDesc', 'Meta Description', 'required|xss_clean');
        $this->form_validation->set_rules('txtPageCont', 'Page Contents', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_translate_post();
            if (is_numeric($update_id)) {

                $this->_insert($data);
                $this->session->set_flashdata('message', 'Page translated successfully.');
            }
            redirect(ADMIN_BASE_URL . 'webpages');
        }
    }

    function change_status() {
        $id = $this->input->post('id');
        $status = $this->input->post('status');
        if ($status == 1)
            $status = 0;
        else
            $status = 1;
        $data = array('is_publish' => $status);
        $status = $this->_update_id($id, $data);
        echo $status;
    }

///////////////////////////     HELPER FUNCTIONS    ////////////////////
    
    function landingPageWidgetsById($url_slug){
            $this->load->model('mdl_webpages');
            return $this->mdl_webpages->_get_about_us($url_slug);  
    }
    
    function _get_about_us($url_slug){
            $this->load->model('mdl_webpages');
            return $this->mdl_webpages->_get_about_us($url_slug);  
    }
    
    function _get_mission($url_slug){
            $this->load->model('mdl_webpages');
            return $this->mdl_webpages->_get_mission($url_slug);  
    }
    
    function _get_menu_pages($outlet_id){
            $this->load->model('mdl_webpages');
            return $this->mdl_webpages->_get_menu_pages($outlet_id)->result_array();  
    }

    function _get_records_by_lang_id($limit, $offset, $arr_col, $order_by) {
        $this->load->model('mdl_webpages');
        return $this->mdl_webpages->_get_records_by_lang_id($limit, $offset, $arr_col, $order_by);
    }

    function _get_sub_pages($arr_col, $order_by) {
        $this->load->model('mdl_webpages');
        return $this->mdl_webpages->_get_sub_pages($arr_col, $order_by);
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_webpages');
        return $this->mdl_webpages->_get_by_arr_id($arr_col);
    }

    function _get($order_by) {
        $this->load->model('mdl_webpages');
        $query = $this->mdl_webpages->get($order_by);
        return $query;
    }
    function _get_toppanel_pages() {
        $where['show_in_toppanel'] = 1;
        $this->load->model('mdl_webpages');
        $query = $this->mdl_webpages->_get_toppanel_pages($where, 'page_rank asc');
        return $query;
    }

    function _get_footerpanel_pages() {
        $this->load->model('mdl_webpages');
        $where['parent_id'] = 0;
        $where['show_in_footer'] = 1;
        $where['is_publish'] = 1;
        $where['outlet_id'] = DEFAULT_OUTLET;
        $query = $this->mdl_webpages->_get_footerpanel_pages($where, 'page_rank asc');
        return $query;
    }

    function _get_page_content_by_url_slug($url_slug) {
        $this->load->model('mdl_webpages');
        $where['url_slug'] = $url_slug;
        $query = $this->mdl_webpages->_get_page_content_by_url_slug($where, 'page_rank asc');
        return $query;
    }

    function _get_home_page_contents() {
        $this->load->model('mdl_webpages');
        $query = $this->mdl_webpages->_get_home_page_contents();
        return $query;
    }

    function _get_with_limit($limit, $offset, $order_by) {
        $this->load->model('mdl_webpages');
        $query = $this->mdl_webpages->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function _get_where($id, $is_static) {
        $this->load->model('mdl_webpages');
        $query = $this->mdl_webpages->get_where($id, $is_static);
        return $query;
    }

    function _get_where_custom($col, $value) {
        $this->load->model('mdl_webpages');
        $query = $this->mdl_webpages->get_where_custom($col, $value);
        return $query;
    }

    function _insert($data) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_insert($data);
    }

    function _update($arr_col, $data) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_update($arr_col, $data);
    }

    function _update_id($id, $data) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_update_id($id, $data);
    }

    function _delete($arr_col) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_delete($arr_col);
    }

    function _set_home($arr_col) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_set_home($arr_col);
    }

    function _set_publish($arr_col) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_set_publish($arr_col);
    }

    function _set_unpublish($arr_col) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_set_unpublish($arr_col);
    }

/////////////////////////toppanel///////////////////
    function _show_toppanel($arr_col) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_show_toppanel($arr_col);
    }

    function _remove_toppanel($arr_col) {
        $this->load->model('mdl_webpages');
        $this->mdl_webpages->_remove_toppanel($arr_col);
    }

///////////////////////footer///////////////////////
    

    function _search_page($strSearch, $limit, $segment, $where, $order) {
        $this->load->model('mdl_webpages');
        return $this->mdl_webpages->_search_page($strSearch, $limit, $segment, $where, $order);
    }

    function _count_where($column, $value) {
        $this->load->model('mdl_webpages');
        $count = $this->mdl_webpages->count_where($column, $value);
        return $count;
    }
    
    function _count_where_sub_pages($column, $order) {
        $this->load->model('mdl_webpages');
        $count = $this->mdl_webpages->_count_where_sub_pages($column, $order);
        return $count;
    }

    function _count_where_search($strSearch, $column) {
        $this->load->model('mdl_webpages');
        $count = $this->mdl_webpages->_count_where_search($strSearch, $column);
        return $count;
    }

    function _get_by_url_slug($url_slug) {
        $this->load->model('mdl_webpages');
        $check = $this->mdl_webpages->_get_by_url_slug($url_slug);
        return $check;
    }

    function _get_by_url_slug_edit($url_slug, $id) {
        $this->load->model('mdl_webpages');
        $check = $this->mdl_webpages->_get_by_url_slug_edit($url_slug, $id);
        return $check;
    }

    function _get_max() {
        $this->load->model('mdl_webpages');
        $max_id = $this->mdl_webpages->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_webpages');
        $query = $this->mdl_webpages->_custom_query($mysql_query);
        return $query;
    }

    function _get_records($arr_col) {
        $this->load->model('mdl_webpages');
        return $this->mdl_webpages->_get_records($arr_col);
    }

}