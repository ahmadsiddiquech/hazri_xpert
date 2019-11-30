
<?php
/*************************************************
Created By: Waseem Khan
Date: 11-08-2015
version: 1.0
*************************************************/

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_webpages extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "webpages";
        return $table;
    }

	function _get_about_us($url_slug='about-us') {
        $table = $this->get_table();
        $this->db->where('url_slug = "'.$url_slug.'"');
        return $this->db->get($table);
    }
	
	function _get_mission($url_slug='our-mission') {
        $table = $this->get_table();
        $this->db->where('url_slug = "'.$url_slug.'"');
        return $this->db->get($table);
    }
	
	function _get_menu_pages($outlet_id=DEFAULT_OUTLET) {
        $table = $this->get_table();
        $this->db->select('id, page_title, url_slug');
		$this->db->where('outlet_id = '.$outlet_id);
       	return  $this->db->get($table);
   		//echo "<pre>";print_r($abc);
    }

    function get($order_by) {
        $table = $this->get_table();
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function get_with_limit($limit, $offset, $order_by) {
        $table = $this->get_table();
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where($id, $is_static=1) {
        $table = $this->get_table();
        if ($is_static==0)
            $this->db->where('is_static = 0');

        $this->db->where('outlet_id', $id);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where_custom($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function _get_records_by_lang_id($limit, $offset, $arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

	function _count_where_sub_pages($column, $order) {
        $table = $this->get_table();
        $this->db->where('is_static = 0');
        $this->db->where($column, $order);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _get_sub_pages($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
         $this->db->where('is_static = 0');
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
    }

    function _update($arr_col, $data) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->update($table, $data);
    }
    function _update_id($id, $data) {      
        $table = $this->get_table();
        $this->db->where('id',$id);
        $this->db->update($table, $data);
    }

    function _set_home($where) {
        $table = $this->get_table();
        $unset_home['is_home'] = 0;
        $this->db->update($table, $unset_home);
        $set_home['is_home'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_home);
    }

    function _set_publish($where) {
        $table = $this->get_table();
        $set_publish['is_publish'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_publish);
    }

    function _set_unpublish($where) {
        $table = $this->get_table();
        $set_un_publish['is_publish'] = 0;
        $this->db->where($where);
        $this->db->update($table, $set_un_publish);
    }

/////////////////////////toppanel///////////////////
    function _show_toppanel($where) {
        $table = $this->get_table();
        $show_top['show_in_toppanel'] = 1;
        $this->db->where($where);
        $this->db->update($table, $show_top);
    }

    function _remove_toppanel($where) {
        $table = $this->get_table();
        $remove_top['show_in_toppanel'] = 0;
        $this->db->where($where);
        $this->db->update($table, $remove_top);
    }

///////////////////////footer///////////////////////
    function _show_footer($where) {
        $table = $this->get_table();
        $show_footer['show_in_footer'] = 1;
        $this->db->where($where);
        $this->db->update($table, $show_footer);
    }

    function _remove_footer($where) {
        $table = $this->get_table();
        $remove_footer['show_in_footer'] = 0;
        $this->db->where($where);
        $this->db->update($table, $remove_footer);
    }

    function _search_page($strSearch, $limit, $segment, $where, $order) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->limit($limit, $segment);
        $this->db->where("( `page_title` LIKE '%" . $strSearch . "%' OR `page_content` LIKE '%" . $strSearch . "%' )");
        $this->db->order_by($order);
        return $this->db->get($table);
    }
    
	function _delete($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->delete($table);
    }

    function _get_by_arr_id($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        return $this->db->get($table);
    }

    


    function _get_static_published_pages($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->where("page_type_id != 1 ");
        return $this->db->get($table);
    }

    function count_where($column, $value) {
        $table = $this->get_table();
        $this->db->where($column, $value);
        $this->db->where('is_static = 0');
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _count_where_search($strSearch, $column) {
        $table = $this->get_table();
        $this->db->where($column);
        $this->db->where("( `page_title` LIKE '%" . $strSearch . "%' OR `page_content` LIKE '%" . $strSearch . "%' )");
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _get_by_url_slug($url_slug) {
        $table = $this->get_table();
        $this->db->where("( `page_title` = '" . $url_slug . "' OR `url_slug` = '" . $url_slug . "' )");
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _get_by_url_slug_edit($url_slug, $id) {
        $table = $this->get_table();
        $this->db->where("( (`page_title` = '" . $url_slug . "' OR `url_slug` = '" . $url_slug . "') AND id != '" . $id . "'  )");
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function count_all() {
        $table = $this->get_table();
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function get_max() {
        $table = $this->get_table();
        $this->db->select_max('id');
        $query = $this->db->get($table);
        $row = $query->row();
        $id = $row->id;
        return $id;
    }

    function _get_toppanel_pages($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col, false);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_footerpanel_pages($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_page_content_by_url_slug($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_home_page_contents() {
        $table = $this->get_table();
       // $this->db->where($arr_col);
        return $this->db->get($table);
    }

    function _custom_query($mysql_query) {
        $query = $this->db->query($mysql_query);
        return $query;
    }

    function _get_records($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }


}