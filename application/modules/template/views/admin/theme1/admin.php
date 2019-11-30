<?php $this->load->view('admin/theme1/header');?>
<?php $this->load->view('admin/theme1/left_panel');?>

<!-- PAGE CONTENT PANEL STARTS HERE-->
<section>
<?php 
 	if(!isset($view_file)){
			$view_file = '';
		}
	
 	if(!isset($module)){
			$module = $this->uri->segment(2);
		}
		
	$path = $module.'/'.$view_file;
	
	$this->load->view($path);
 ?>
</section>

<!-- PAGE CONTENT PANEL ENDS HERE-->
<?php $this->load->view('admin/theme1/footer');?>
