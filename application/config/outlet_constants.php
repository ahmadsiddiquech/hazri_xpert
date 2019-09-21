<?php
////////////////// Default Language and Outlet constant ///////////////
$config=array();
$ci = & get_instance();
$ci->load->library('session');
require_once( BASEPATH . 'database/DB' . EXT );

$db = & DB();
$outlet_data = $ci->session->userdata('outlet_data');
$user_data = $ci->session->userdata('user_data');

$strHost = $_SERVER['SERVER_NAME'];
$chack = false;
if(isset($outlet_data) && $outlet_data != NULL){
	define('DEFAULT_OUTLET',$outlet_data['outlet_id']);
	define('DEFAULT_OUTLET_NAME', $outlet_data['outlet_name']);
	define('DEFAULT_LANG', 1);
	define('DEFAULT_THEME', 'a');
	$chack = true;
}
else{
		$row = $db->get_where('outlet', array('url' => $strHost))->row();
		if (isset($row) && !empty($row)){
			define('DEFAULT_OUTLET', $row->id);
			define('DEFAULT_OUTLET_NAME', $row->building_name);
			define('DEFAULT_LANG', $row->id);
			define('DEFAULT_URL', $strHost);
			define('DEFAULT_LONGITUDE', $row->longitude);
			define('DEFAULT_LATITUDE', $row->latitude);
		}else{
			print '<h2>Invalid URL! Contact to administrator.</h2>'.$strHost; exit; 
		}
}
	
	{
	    $where4['outlet_id'] = DEFAULT_OUTLET;
	    $db->where($where4);
	    $row4 = $db->get('general_setting')->row();

		if(count($row4) > 0){
			define('DEFAULT_CURRENCY_CODE', 'GBP');
			define('DEFAULT_THEME', $row4->theme);
			define('DEFAULT_LOGO', $row4->image);
			if ($row4->date_format > 0)
				define('DEFAULT_DATE_FORMAT', $row4->date_format);
			else 
				define('DEFAULT_DATE_FORMAT', 1);
			if ($row4->time_format > 0)
				define('DEFAULT_TIME_FORMAT', $row4->time_format);
			else 
				define('DEFAULT_TIME_FORMAT', 1);
			
		}else{
			define('DEFAULT_CURRENCY', 14);
			
			define('DEFAULT_LOGO', 'logo_1_logo.png');
			define('DEFAULT_COUNTRY', 235);
			define('DEFAULT_THEME', 'a');
			define('DEFAULT_DATE_FORMAT', 1);
			define('DEFAULT_TIME_FORMAT', 1);
		
		}
	}