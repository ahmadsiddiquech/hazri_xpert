<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Roles extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('template');
    }

	function index(){ $this->manage_record();}

    function manage_record() {
        $arrWhere['outlet_id'] = DEFAULT_OUTLET;
        $data['roles'] = $this->_get_by_arr_id($arrWhere)->result_array();
		$data['view_file'] = 'roles';
        $this->load->module('template');
        $this->template->admin($data);
    }    
    
    function create() {
		$arr_roles = array();
		$outlets = array();
        $data = array();
		$user_data = $this->session->userdata('user_data');  
        
        $update_id = $this->uri->segment(4);
         if ($update_id && $update_id != 0) {
            $data['roles_admin'] = $this->_get_data_from_db($update_id);
            
        }
       

		$result = Modules::run('roles_outlet/_get_where_custom','emp_id',$user_data['user_id']);
		foreach($result->result() as $row){

			$outlet = Modules::run('outlet/_get_where',$row->outlet_id)->row();
			$outlets[$outlet->id] = $outlet->building_name; 
		}

		$roles =  $this->_get_where_custom('outlet_id',DEFAULT_OUTLET)->result_array();
       // print_r($roles);
     $roles_admin=  array('');
        if (is_array($roles) && count($roles) > 0)
    		foreach($roles as $row){
    			$arr_roles[$row['id']] = $row['role'];
    		}
		$arr_outlets = Modules::run('outlet/_get','id');
		$outlets = array();
		foreach($arr_outlets->result() as $row){
			$outlets[$row->id] = $row->building_name;

		}

       // echo "update id..........".$update_id; exit();
        $data['update_id'] = $update_id;
		$data['stations'] = $outlets;
		$data['outlet_id'] = DEFAULT_OUTLET;
		$data['outlets'] = $outlets;
		$data['roles'] = $arr_roles;
        $data['view_file'] = 'rolesform';
        $this->template->admin_form($data);
    }

/////////////////////////////////////////////////////////////////////////////

    function _get_data_from_post() {
        $data['role'] = $this->input->post('title');
        $data['outlet_id'] = $this->input->post('station');
		//echo'<pre>'; print_r($data); echo'</pre>';
		//exit;
		return $data;
      
    }

    function _get_data_from_db($update_id) {
		$row = $this->_get_where($update_id)->row();
        $data['role'] = $row->role; 
        $data['outlet_id'] = $row->outlet_id;
		return $data;
	}

    function submit() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $update_id = $this->uri->segment(4);
            $data = $this->_get_data_from_post();
			//Modules::run('site_security/has_permission',$data['outlet_id']);
			
            if ($update_id) {
                $this->_update($update_id, $data);
                $this->session->set_flashdata('message', 'roles '.DATA_UPDATED);                                        
                $this->session->set_flashdata('status', 'success');
				//echo 2;
            } 
			else {
				$where['role'] = $data['role'];
				$where['outlet_id'] = $data['outlet_id'];
            	$checkRole = $this->_get_by_arr_id($where);
				if ($checkRole->num_rows == 0) {
                $id = $this->_insert($data);
                    $this->session->set_flashdata('message', 'roles'.' '.DATA_SAVED);                                       
                    $this->session->set_flashdata('status', 'success');
				   //echo 1;
				}
				else
				{
                    $this->session->set_flashdata('status', 'error');
					
				}
            }

        }
        redirect(ADMIN_BASE_URL . 'roles');
    }
	
	function get_roles(){
		$outlet_id = $this->input->post('station');
		$controller = $this->router->fetch_class();
		$roles = $this->_get_where_custom('outlet_id',$outlet_id)->result();
		$temp = array();
		
		foreach($roles as $key=>$row){
			$temp[$key]['id'] = $row->id;
			$temp[$key]['role'] = $row->role;
			$temp[$key]['outlet_id'] = $row->outlet_id;
		}
		$data['roles'] = $temp;
        $this->load->view('roles-details', $data);
	}
	function get_roles_dropdown(){
		$roles = array();
		$outlet_id = DEFAULT_OUTLET;
		$result = Modules::run('roles/_get_where_custom','outlet_id',$outlet_id); 
		foreach($result->result() as $row){
			if($row->role != 'portal admin')
				$roles[$row->id] = $row->role;
		}
		$html = '';
		$html.= '<div class="form-group">';
               $options = array('' => '--select--') + $roles;
                $attribute = array('class' => 'control-label col-md-4');
                $html .= form_label('Role<span class="required">*</span>', 'lstRoles', $attribute); 
                $html .= '<div class="col-md-8">';
                $html .=   form_dropdown('lstRoles',$options , '', 'class = "form-control select2me" data-placeholder="Select Role...", id="lstRoles" required=1'); 
        $html .= '</div>
            </div>';
			
		echo $html;
   }
function roles_load_listing() {
       $id = DEFAULT_OUTLET;
        $data['roles'] = $this->_get_where_outlet($id)->result_array();
        $this->load->view('roles_load_listing',$data);      
}
	function edit_role() {
		$outlet_id = DEFAULT_OUTLET;
		Modules::run('site_security/has_permission',$outlet_id);

		$role_id = $this->input->post('role_id');
		$user_data = $this->session->userdata('user_data');
		$result = Modules::run('roles_outlet/_get_where_custom','emp_id',$user_data['user_id']);
		foreach($result->result() as $row){
			$outlet = Modules::run('outlet/_get_where',$row->outlet_id)->row();
			$outlets[$outlet->id] = $outlet->name;
		}
		$data['role'] = $this->_get_where($role_id)->row();
		$roles = $this->_get('id asc')->result();
		foreach($roles as $row){
			$arr_roles[$row->id] = $row->role;
		}
		
		$data['role_id'] = $role_id;
		$data['outlet_id'] = $outlet_id;
		$data['outlets'] = $outlets;
		$data['roles'] = $arr_roles;
		$this->load->view('edit-role-details', $data);
    }

	
	function delete_role(){
		$outlet_id = DEFAULT_OUTLET;
      $id =  $this->input->post('id');
		Modules::run('site_security/has_permission',$outlet_id);
     $result =   Modules::run('users/_get_where_user',$id)->num_rows();

       if ($result > 0) {
          echo  1 ;

       }
       else
       {
		$where['id'] = $id;
		$this->_delete($where);
        }
	}

////////////////////// GENERAL FUNCTIONS //////////////////////
    function _get($order_by) {
        $this->load->model('mdl_roles');
        $query = $this->mdl_roles->get($order_by);
        return $query;
    }

    function _get_with_limit($limit, $offset, $order_by) {
        $this->load->model('mdl_roles');
        $query = $this->mdl_roles->get_with_limit($limit, $offset, $order_by);
        return $query;
    }

    function _get_where($id) {
        $this->load->model('mdl_roles');
        $query = $this->mdl_roles->get_where($id);
		
        return $query;
    }
    function _get_where_outlet($id) {
        $this->load->model('mdl_roles');
        $query = $this->mdl_roles->_get_where_outlet($id);
        
        return $query;
    }

    function _get_where_custom($col, $value) {
        $this->load->model('mdl_roles');
        $query = $this->mdl_roles->get_where_custom($col, $value);
        return $query;
    }

    function _get_by_arr_id($arr_col) {
        $this->load->model('mdl_roles');
        return $this->mdl_roles->_get_by_arr_id($arr_col);
    }

    function _insert($data) {
        $this->load->model('mdl_roles');
        return $this->mdl_roles->_insert($data);
    }

    function _update($id, $data) {
        $this->load->model('mdl_roles');
        return $this->mdl_roles->_update($id, $data);
    }

    function _delete($arr_col) {
        $this->load->model('mdl_roles');
        $this->mdl_roles->_delete($arr_col);
    }

    function _get_max() {
        $this->load->model('mdl_roles');
        $max_id = $this->mdl_roles->get_max();
        return $max_id;
    }

    function _custom_query($mysql_query) {
        $this->load->model('mdl_roles');
        $query = $this->mdl_roles->_custom_query($mysql_query);
        return $query;
    }

    function _get_recordes() {
        $this->load->model('mdl_roles');
        return $this->mdl_roles->_get_recordes();
    }
	function _get_where_cols($where) {
        $this->load->model('mdl_roles');
        $query = $this->mdl_roles->get_where_cols($where);
        return $query;
    }

}