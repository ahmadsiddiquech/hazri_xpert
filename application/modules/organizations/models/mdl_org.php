<?php 
/*************************************************
Created By: Waseem Khan
Dated: 03/18/2016

*************************************************/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_org extends CI_Model {

function __construct() {
parent::__construct();
}

function get_table() {
$table = "users";
return $table;
}

function _get($order_by){
$table = $this->get_table();
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}

function _get_with_limit($limit, $offset, $order_by) {
$table = $this->get_table();
$this->db->limit($limit, $offset);
$this->db->order_by($order_by);
$query=$this->db->get($table);
return $query;
}
function _get_where_login($org_email, $password){
$table = $this->get_table();
$this->db->where('org_email', $org_email);
$this->db->where('password', $password);
$this->db->where('status', 1);
$query=$this->db->get($table);
return $query;
}
function _get_where($id){
$table = $this->get_table();
$this->db->where('id', $id);
$query=$this->db->get($table);
return $query;
}
function _get_where_user($id){
$table = $this->get_table();
$this->db->where('role_id', $id);
$query=$this->db->get($table);
return $query;
}
function _get_where_validate($org_email){	
$table = $this->get_table();
$this->db->where('org_email', $org_email);
$query=$this->db->get($table);
return $query;
}

function _getItemById($id) {
$table = $this->get_table();
$this->db->where("( id = '" . $id . "'  )");
$query = $this->db->get($table);
return $query->row();
}

function _get_by_arr_id($arr_col) {
$table = $this->get_table();
$this->db->where($arr_col);
return $this->db->get($table);
}

function _get_zabiha($table , $distance, $longitude, $latitude) {

    /*$result = $this->_custom_query('Select z.*, p.distance_unit * DEGREES(ACOS(COS(RADIANS(p.latpoint)) * COS(RADIANS(z.latitude)) * COS(RADIANS(p.longpoint) - RADIANS(z.longitude))
                                    + SIN(RADIANS(p.latpoint)) * SIN(RADIANS(z.latitude)))) AS distance_in_km 
                                    FROM '.$table.' AS z JOIN ( SELECT  '.$latitude.'  AS latpoint,  '.$longitude.' AS longpoint, '.$distance.' AS radius, 111.045 AS distance_unit
                                   ) AS p ON 1=1  WHERE z.latitude BETWEEN p.latpoint  - (p.radius / p.distance_unit) AND p.latpoint  + (p.radius / p.distance_unit) AND z.longitude
                                   BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint)))) AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint)))) ORDER BY distance_in_km
                                   LIMIT 15');*/

    $result = $this->_custom_query('Select z.*, p.distance_unit * DEGREES(ACOS(COS(RADIANS(p.latpoint)) * COS(RADIANS(z.latitude)) * COS(RADIANS(p.longpoint) - RADIANS(z.longitude))
                                    + SIN(RADIANS(p.latpoint)) * SIN(RADIANS(z.latitude)))) AS distance_in_miles
                                    FROM '.$table.' AS z JOIN ( SELECT  '.$latitude.'  AS latpoint,  '.$longitude.' AS longpoint, '.$distance.' AS radius, 69.0 AS distance_unit
                                   ) AS p ON 1=1  WHERE z.latitude BETWEEN p.latpoint  - (p.radius / p.distance_unit) AND p.latpoint  + (p.radius / p.distance_unit) AND z.longitude
                                   BETWEEN p.longpoint - (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint)))) AND p.longpoint + (p.radius / (p.distance_unit * COS(RADIANS(p.latpoint)))) ORDER BY distance_in_miles
                                   LIMIT 15');
    
    return $result;
}


function _get_where_cols($cols,$order_by){
$table = $this->get_table();
$this->db->where($cols);
$query=$this->db->get($table);
return $query;
}

function _get_where_custom($col, $value, $order_by) {
$table = $this->get_table();
$this->db->where($col, $value);
$query=$this->db->get($table);
return $query;
}

function _insert($data){
$table = $this->get_table();
$this->db->insert($table, $data);
return $this->db->insert_id();
}

function _delete($id) {
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->delete($table);
}

function _update($arr_col, $data) {
$table = $this->get_table();
$this->db->where($arr_col);
$this->db->update($table, $data);
}

function _update_where_cols($cols, $data){
$table = $this->get_table();
$this->db->where($cols);
$this->db->update($table, $data);
}

function _update_id($id, $data){
$table = $this->get_table();
$this->db->where('id', $id);
$this->db->update($table, $data);
}

function _count_where($column, $value) {
$table = $this->get_table();
$this->db->where($column, $value);
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function _count_all() {
$table = $this->get_table();
$query=$this->db->get($table);
$num_rows = $query->num_rows();
return $num_rows;
}

function _get_max() {
$table = $this->get_table();
$this->db->select_max('id');
$query = $this->db->get($table);
$row=$query->row();
$id=$row->id;
return $id;
}

function _custom_query($mysql_query) {
$query = $this->db->query($mysql_query);
return $query;
}

}