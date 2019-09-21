<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


$outlet1 = str_replace('www.','',$_SERVER['HTTP_HOST']);
if($outlet1 == 'ds-pc' || $outlet1 == 'localhost')
{
	 //for local manual setting
	$config['cache_dir'] = APPPATH.'cache/d/';
}
else
{
	// for live
	$outlet2 = substr($outlet1, 0, -4);
	$config['cache_dir'] = APPPATH.'cache/'.$outlet2.'/';
}
	$config['cache_default_expires'] = 0;
?>