<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_general_setting extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_table() {
        $table = "general_setting";
        return $table;
    }
     function get_table_outlet() {
        $table2 = "outlet";
        return $table2;
    }
    function get($where, $order_by) {
        $table = $this->get_table();
        $this->db->where('parent_id', $where);
        $this->db->where('is_active', 1);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

 function get_theme() {

      $this->db->select('theme'); 
    $this->db->from('general_setting');   
    $this->db->where('id', DEFAULT_OUTLET);
    return $this->db->get();

        /*$table = $this->get_table();
        $this->db->where('parent_id', $where);
        $this->db->where('is_active', 1);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;*/
    }



    function _get_sub_cat($order_by) {
        $table = $this->get_table();
        $this->db->where('parent_id !=', 0);
        $this->db->order_by($order_by);
        $query = $this->db->get($table);
        return $query;
    }

    function _get_sub_cat_by_id($where) {
        $table = $this->get_table();
        $this->db->where('parent_id', $where);
        $this->db->where('is_active', 1);
        $query = $this->db->get($table);
        return $query;
    }

    function _get_sub_cats_ajax($user_id, $cat_id) {
        $this->db->select('catagories.id,catagories.cat_name,catagories.cat_name,catagories.parent_id,user_cat_discount.discount');
        $this->db->from('catagories');
        $this->db->join('user_cat_discount', "catagories.id = user_cat_discount.sub_cat_id AND user_cat_discount.user_id ='" . $user_id . "' ", 'left');
        if ($cat_id == 0)
            $this->db->where('catagories.parent_id !=', 0);
        else
            $this->db->where('catagories.parent_id', $cat_id);
        $this->db->order_by("catagories.parent_id", "asc");
        $query = $this->db->get();
        return $query;
    }

    function _get_sub_cat_type_by_id($where) {
        $table = $this->get_table();
        $this->db->where('id', $where);
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

    function get_where($id) {
        $table = $this->get_table();
        $this->db->where('id', $id);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where_custom($col, $value) {
        $table = $this->get_table();
        $this->db->where($col, $value);
        $query = $this->db->get($table);
        return $query;
    }

    function get_where_custom_join_outlet($col, $outlet_id) {
        $this->db->select('general_setting.*, outlet.*');
        $this->db->from('general_setting');
        $this->db->join('outlet', "outlet.id = general_setting.outlet_id", 'left');
        $this->db->where($col, $outlet_id);
        $query = $this->db->get();
        return $query;
    }

    function _get_records_by_lang_id($limit, $offset, $arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_sub_catagories($arr_col, $order_by) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _insert($data) {
        $table = $this->get_table();
        $this->db->insert($table, $data);
		$insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function _update($arr_col, $data) {
        $table = $this->get_table();
	//	$table2 = $this->get_table_outlet();
        $this->db->where($arr_col);
        $this->db->update($table, $data);


    }

     function _update_setting($data) {
        $table = $this->get_table();
        $this->db->where('outlet_id',DEFAULT_OUTLET);
        $this->db->update($table, $data);


    }

    function _set_active($where) {
        $table = $this->get_table();
        $set_active['is_active'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_active);
    }

    function _set_default($where) {
        $table = $this->get_table();
        $unset_default['is_default'] = 0;
        $this->db->update($table, $unset_default);
        $set_default['is_default'] = 1;
        $set_active['is_active'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_default);
        $this->db->where($where);
        $this->db->update($table, $set_active);
    }

    function _set_in_active($where) {
        $table = $this->get_table();
        $set_in_active['is_active'] = 0;
        $this->db->where($where);
        $this->db->update($table, $set_in_active);
    }

    function _search_catagory($strSearch, $limit, $segment, $where, $order) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->limit($limit, $segment);
        $this->db->where("( `cat_name` LIKE '%" . $strSearch . "%' OR `cat_desc` LIKE '%" . $strSearch . "%' )");
        $this->db->order_by($order);
        return $this->db->get($table);
    }

    function _search_sub_cat($strSearch, $limit, $segment, $where, $order) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->limit($limit, $segment);
        $this->db->where("( `cat_name` LIKE '%" . $strSearch . "%' OR `cat_desc` LIKE '%" . $strSearch . "%' )");
        $this->db->order_by($order);
        return $this->db->get($table);
    }

    function _delete($arr_col) {
        $arr_self_id['id'] = $arr_col['id'];
        $arr_parent_id['parent_id'] = $arr_col['parent_id'];
/////////// TO delete all sub pages
        $table = $this->get_table();
        $this->db->where($arr_parent_id);
        $this->db->delete($table);
/////////// TO delete parent page itself
        $this->db->where($arr_self_id);
        $this->db->delete($table);
    }

    function _get_by_arr_id() {
        $table = $this->get_table();
//        $this->db->where($arr_col);
        return $this->db->get($table);
    }

    function count_where($column, $order) {
        $table = $this->get_table();
        $this->db->where($column, $order);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _count_where_search($strSearch, $column) {
        $table = $this->get_table();
        $this->db->where($column);
        $this->db->where("( `cat_name` LIKE '%" . $strSearch . "%' OR `cat_desc` LIKE '%" . $strSearch . "%' )");
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _count_where_sub_cat_search($strSearch, $column) {
        $table = $this->get_table();
        $this->db->where($column);
        $this->db->where("( `cat_name` LIKE '%" . $strSearch . "%' OR `cat_desc` LIKE '%" . $strSearch . "%' )");
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }

    function _count_where_sub_cat($column, $order) {
        $table = $this->get_table();
        $this->db->where($column, $order);
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

    function _set_home($where) {
        $table = $this->get_table();
        $set_home['is_home'] = 1;
        $this->db->where($where);
        $this->db->update($table, $set_home);
    }

    function _set_not_home($where) {
        $table = $this->get_table();
        $set_not_home['is_home'] = 0;
        $this->db->where($where);
        $this->db->update($table, $set_not_home);
    }

    function _get_front_home_cats($where, $limit) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->limit($limit);
        return $this->db->get($table);
    }

    function _get_front_leftpanel_cats($where, $order_by) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_default_cat($where, $order_by) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _get_cat_details_by_id($where, $order_by) {
        $table = $this->get_table();
        $this->db->where($where);
        $this->db->order_by($order_by);
        return $this->db->get($table);
    }

    function _custom_query($mysql_query) {
        $query = $this->db->query($mysql_query);
        return $query;
    }

    function _getItemById($id) {
        $table = $this->get_table();
        $this->db->where("( id = '" . $id . "'  )");
        $query = $this->db->get($table);
        return $query->row();
    }

    function _get_records($arr_col) {
        $table = $this->get_table();
        $this->db->where($arr_col);
        $query = $this->db->get($table);
        $num_rows = $query->num_rows();
        return $num_rows;
    }
    function _get_holidays(){
        $table= $this->get_table();
        $this->db->select("holidays");
        $query = $this->db->get($table);
        return $query;
    }

}