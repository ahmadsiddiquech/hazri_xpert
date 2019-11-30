<?php 
/*************************************************
Created By: Waseem Khan
Dated: 18-08-2015
version: 1.0
*************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends MX_Controller
{

function __construct() {
parent::__construct();
}

//////////////////////////////////////// LOGIN ///////////////////////////////////////////

function index(){
	 $this->load->view('login_form');

}
function submit_login(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('txtUserName', 'Username', 'required|trim|xss_clean');
	$this->form_validation->set_rules('txtPassword', 'Passwords', 'required|trim|xss_clean|callback_pword_check');
	{
		 
		
		$org_email = $this->input->post('txtUserName', TRUE);
		$password = md5($this->input->post('txtPassword', TRUE));

		//print " password ".$password;exit;
				$row = Modules::run('organizations/_get_where_login',$org_email, $password )->row();
				
				if (empty($row)) {
					//echo "Invalid user name........."; exit();
					redirect(ADMIN_BASE_URL);
					exit();
				}
				
	    $where['emp_id'] = $row->id;
		$where1['emp_id'] = $row->id;
		$role_id = $row->role_id;		
		//$result = Modules::run('roles/_get_where',$role_id)->row();
		
		$data['user_id'] = $row->id;
		$data['role_id'] = $row->role_id; 
		// $data['name'] = $row->user_name;
		//$data['role'] = $result->role;
		$data['org_email'] = $row->org_email;
		$data['user_name'] = $row->org_name;
		// $data['outlet_id'] =$row->outlet_id;
		
		//$data['is_supperadmin'] = 1;//$row->is_supperadmin;
	   
		$this->session->set_userdata('user_data', $data);
		$user_data = $this->session->userdata('user_data');
		//echo "Here after.2222........".ADMIN_BASE_URL.'dashboard'; exit();
		
		$current_date = date('Y-m-d');
		if($row->role_id == 1){
			redirect(ADMIN_BASE_URL.'organizations');
		}	else{
			redirect(ADMIN_BASE_URL.'dashboard');
		}
	}
}

function pword_check($txtPassword){
	$password = Modules::run('site_security/make_hash',$txtPassword);
	$org_email = $this->input->post('txtUserName',TRUE);
	$result = Modules::run('organizations/_pword_check',$org_email,$password);
	if ($result == FALSE){
		$this->form_validation->set_message('pword_check', 'The username or password you have entered is incorrect.');
		return FALSE;
	}else{
		return TRUE;
	}

}

/////////////////////////////// FORGOT PASSWORD ///////////////////////////////////////

function forgot_password(){
	$data['view_file'] = 'forgot_password';
	$this->load->module('template');
	$this->template->admin_login($data);
}

function get_captcha(){
	echo Modules::run("site_security/get_captcha");	
}

function submit_forgot_pword(){
	$this->load->library('form_validation');
	$this->form_validation->set_rules('txtCode', 'Security code', 'required|trim|xss_clean');
	$this->form_validation->set_rules('txtEmail', 'Email', 'required|trim|xss_clean|valid_email|callback_email_n_code_check');
	if ($this->form_validation->run($this) == FALSE){
		$this->forgot_password();
	}
	else{
		
			
		$email = $this->input->post('txtEmail');
		$query = Modules::run("organizations/_get_where_custom",'email',$email);
		$result = $query->row();	
	   echo 'Dear '.$result->name.'<br><br>Please <a href="'.ADMIN_BASE_URL.'login/reset_password/'.$result->email.'/'.$result->code.'">reset your password</a>.';
	   exit;

	    $this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);

        $this->email->from(ADMIN_EMAIL,ADMIN_NAME);
        $this->email->to($result->email,$result->name);
        $this->email->subject("Reset your password.");
        $this->email->message('Dear '.$result->name.'<br><br>Please <a href="'.ADMIN_BASE_URL.'login/reset_password/'.$result->email.'/'.$result->code.'">reset you password</a>.');
		$chk = $this->email->send();
		if($chk){
			$this->session->set_flashdata('success','Email has been sent.');
			redirect(ADMIN_BASE_URL.'login/forgot_password');
		}else{
			 echo 'fail to sent!';
			}
		}
}

function email_n_code_check($txtEmail){
	
	$security_code = $this->input->post('txtCode');
	$rndChar = $this->input->post('hdn_code');
	$query = Modules::run("organizations/_get_where_custom",'email',$txtEmail);
	$result = $query->row();
	if (!isset($result->email)){
		$this->form_validation->set_message('email_n_code_check', 'This email doesn\'t exist.');
		return FALSE;
	}
	else if($rndChar != $security_code){
		$this->form_validation->set_message('email_check', 'Incorrect security code.');
		return FALSE;
	}
	else{
		return true;
	}

}

/////////////////////// RESET PASSWORD ///////////////////////
function reset_password(){
	$data['email'] = $this->uri->segment(4);
	$data['code'] = $this->uri->segment(5);	
	$this->session->set_userdata($data);
	$data['view_file'] = 'reset_password';
	$this->load->module('template');
	$this->template->admin_login($data);
}

function submit_reset_pword(){
	$this->session->userdata('email');
	$this->load->library('form_validation');
	$this->form_validation->set_rules('txtNewPassword', 'New Password', 'required|trim|xss_clean');
	$this->form_validation->set_rules('txtConfPassword', 'Confrim Password', 'required|trim|xss_clean|callback_password_check');
	if ($this->form_validation->run($this) == FALSE){
		$this->reset_password();
	}
	else{
		$where['email'] = $this->session->userdata('email');
		$where['code'] = $this->session->userdata('code');
		$password = $this->input->post('txtNewPassword');
		$data['password'] = Modules::run('site_security/make_hash',$password);
		$result = Modules::run("organizations/_update_where",$where,$data);
		if($result){
			$data['code'] = Modules::run("site_security/get_encrypt_code");
			$email['email'] = $this->session->userdata('email');
			Modules::run("organizations/_update_where",$email,$data);
			$this->session->unset_userdata($where);
			redirect(ADMIN_BASE_URL.'login/success');
		}
		else{
			echo'fail to reset password!';
		}
	}
}

function password_check($txtEmail){
	$new_password = $this->input->post('txtNewPassword');
	$conf_password = $this->input->post('txtConfPassword');
	if($new_password != $conf_password){
		$this->form_validation->set_message('password_check', 'Password doesn\'t match.');
		return FALSE;
	}
	else{
		return true;
	}

}

function success(){
	$data['view_file'] = 'success';
	$this->load->module('template');
	$this->template->admin_login($data);
}

function logout(){
	//session_destroy();
//session_write_close();
	//$outlet_data = $this->session->userdata('outlet_data');
	//print '<br> session data ===>>';print_r($outlet_data);

	$this->session->unset_userdata('user_data');
	$this->session->unset_userdata('outlet_data');
	//$outlet_data = $this->session->userdata('outlet_data');
	//print '<br> session data ===>>';print_r($outlet_data);
	//exit;
	$this->index();
	
}

}