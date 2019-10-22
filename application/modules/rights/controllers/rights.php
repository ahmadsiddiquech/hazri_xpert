<?php 
/*************************************************
Created By: Imran Haider
Dated: 01-01-2014
version: 1.0
*************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rights extends MX_Controller
{

function __construct() {
parent::__construct();
Modules::run('site_security/is_login');
//Modules::run('site_security/has_permission');

}

	function index(){
		$this->_empty_table();
		$this->load->library('controllerlist');
		$rights = $this->controllerlist->getControllers();
		/*print "<br> this ======>>>";
		print"<pre>";
		print_r($rights);
		print"</pre>";
		print "<br> this ======>>>";
		exit;*/
		$arr_rights = '';
		foreach($rights as $ctrl => $methods){
			foreach($methods as $method1){
				$_score = substr($method1,0,1); 
				if($_score != '_'){
					$arr_rights[$ctrl][] = $method1;
				}
			} 
		}
		
		foreach($arr_rights as $ctrl=>$methods){
			if($ctrl!='rights')
			{
				$parent_id = '';
				$query = $this->_get_where_custom('right',$ctrl);
				$parent = $query->row();
				
				if(count($parent) == 0){
					$parent_data['right'] = $ctrl;
					//$parent_data['outlet_id'] = DEFAULT_OUTLET;
					$parent_id = $this->_insert($parent_data);
				}else{
					$parent_id = $parent->id;
				}
				foreach($methods as $key=>$method){
					$data['right'] = $method; 
					$data['parent_id'] = $parent_id; 
					$chk_right = $this->_count_where_cols($data);
					if($chk_right == 0){
						$right_id = $this->_insert($data);
					}
				}
			}
		}
		$query = Modules::run('roles/_get_where_custom','role','portal admin');
		$result = $query->row();
		Modules::run('permission/submit',$this->rights(),$result->id,DEFAULT_OUTLET);
		
	}

	function rights(){
		$query = $this->_get_where_custom('parent_id',0);
		foreach($query->result() as $parent){
			$query2 = $this->_get_where_custom('parent_id',$parent->id);
			$arr_rights[] = $parent->id.'_0';
			foreach($query2->result() as $right){
				$arr_rights[] = $right->id.'_'.$parent->id;
			}
		}
		return $arr_rights;
	}
	///////////////////////// GENERAL FUNCTIONS //////////////////

	function _empty_table(){
	$this->load->model('mdl_rights');
	$this->mdl_rights->_empty_table();
	}

	function _get($order_by){
	$this->load->model('mdl_rights');
	$query = $this->mdl_rights->get($order_by);
	return $query;
	}
	
	function _get_with_limit($limit, $offset, $order_by) {
	$this->load->model('mdl_rights');
	$query = $this->mdl_rights->get_with_limit($limit, $offset, $order_by);
	return $query;
	}
	
	function _get_where($id){
	$this->load->model('mdl_rights');
	$query = $this->mdl_rights->get_where($id);
	return $query;
	}
	
	function _get_where_in($arr){
	$this->load->model('mdl_rights');
	$query = $this->mdl_rights->get_where_in($arr);
	return $query;
	}
	
	function _get_where_custom($col, $value) {
	$this->load->model('mdl_rights');
	$query = $this->mdl_rights->get_where_custom($col, $value);
	return $query;
	}
	
	function _insert($data){
	$this->load->model('mdl_rights');
	return $this->mdl_rights->_insert($data);
	}
	
	function _update($id, $data){
	$this->load->model('mdl_rights');
	$this->mdl_rights->_update($id, $data);
	}
	
	function _delete($id){
	$this->load->model('mdl_rights');
	$this->mdl_rights->_delete($id);
	}
	
	function _count_where($column, $value) {
	$this->load->model('mdl_rights');
	$count = $this->mdl_rights->count_where($column, $value);
	return $count;
	}
	
	function _count_where_cols($where) {
	$this->load->model('mdl_rights');
	$count = $this->mdl_rights->count_where_cols($where);
	return $count;
	}
	
	function _get_max() {
	$this->load->model('mdl_rights');
	$max_id = $this->mdl_rights->get_max();
	return $max_id;
	}
	
	function _custom_query($mysql_query) {
	$this->load->model('mdl_rights');
	$query = $this->mdl_rights->_custom_query($mysql_query);
	return $query;
	}

}