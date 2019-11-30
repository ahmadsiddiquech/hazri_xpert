<div class="col-md-9 col-sm-7 col-xs-7 genral table-header-form">Translate Post</div>
    <?php
		echo anchor(ADMIN_BASE_URL.'post', 'Back', array('class' => 'btn btn-default btn-info btn-xs pull-right back-button', 'role' => 'button'));
        ?>
<div class="col-xs-12 col-sm-12 col-md-12" style="padding:0px;">
<?php
		echo validation_errors('<p style="color:red;">','</p>');
?>
<div style="clear:both;"></div>
	<?php 
	$attributes = array('autocomplete' => 'off', 'id' => 'frmNews');
	$hidden = array('hdnId' => $update_id,'hdnImage' => $news['image'],'hdnType' => $news['type']);
	echo form_open(ADMIN_BASE_URL.'post/translate_submit/'.$update_id,$attributes, $hidden); 
	?>
<div class="row">
	<div class="col-sm-6">
        <div class="form-group">
		<?php
            $data = array(
                      'name'        => 'txtNewsTitle',
                      'id'          => 'txtNewsTitle',
                      'class'   	=> 'form-control validate[required] text-input',
                      'value'       => $news['news_title'],
                    );
            echo form_label('Title <span class="red" style="color:red;">*</span>','txtNewsTitle');
            echo form_input($data);
        ?>
        </div>
    </div>
    <div class="col-sm-6">
		<?php if(!empty($languages))
            {
                ?>
        <div class="form-group">
		 <?php
            //print_r($languages);
            $options = array('0'=> '---select--') + $languages;
            echo form_label('Language <span class="red" style="color:red;">*</span>','lstLanguage'); echo br();
            echo form_dropdown('lstLanguage', $options,$lang_id, 'class = "form-control" id = "lstLanguage"');
         ?>
        </div>
        <?
            }
            ?>
    </div>
</div>
<!--<div class="form-group">
<?php
	$data = array(
              'name'        => 'txtShortDesc',
              'id'          => 'txtShortDesc',
			  'rows'          => '5',
			  'cols'          => '10',
              'class'   	=> 'form-control',
              'value'       => $news['short_desc'],
            );
	echo form_label('Short Description','txtShortDesc');
	echo form_textarea($data);
?>
</div>-->
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
		<?php
            $data = array(
                      'name'        => 'txtLongDesc',
                      'id'          => 'txtLongDesc',
                      'rows'          => '5',
                      'cols'          => '10',
                      'class'   	=> 'ckeditor',
                      'value'       => $news['long_desc'],
                    );
            echo form_label('Description <span class="red" style="color:red;">*</span>','txtLongDesc');
            echo form_textarea($data);
        ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
		<?php
            $data = array(
                      'name'        => 'txtNewsDate',
                      'id'          => 'txtNewsDate',
                      'class'   	=> 'form-control validate[required]',
                      'value'       => $news['new_date'],
                    );
            echo form_label('Date <span class="red" style="color:red;">*</span>','txtNewsDate');
            echo form_input($data);
        ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
<?php
	$data = array(
              'name'        => 'btnSubmit',
              'id'          => 'btnSubmit',
              'class'   	=> 'btn btn-primary',
              'value'       => 'Save',
            );
	echo form_submit($data);
 	echo form_close();?>
        </div>
    </div>
</div>
<script>
	jQuery(document).ready(function(){
		// binds form submission and fields to the validation engine
		jQuery("#frmNews").validationEngine();
	});
		
</script>
<script>
		CKEDITOR.replace('txtLongDesc',
						{
							filebrowserBrowseUrl :'<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/browser/default/browser.html?Connector=<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/connectors/php/connector.php',
							filebrowserImageBrowseUrl : '<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector=<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/connectors/php/connector.php',
							filebrowserFlashBrowseUrl :'<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector=<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/connectors/php/connector.php',
							filebrowserUploadUrl  :'<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/connectors/php/upload.php?Type=File',
							filebrowserImageUploadUrl : '<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
							filebrowserFlashUploadUrl : '<?=$this->config->base_url()?>/static/admin/theme1/js/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
						});
$('#txtNewsDate').datetimepicker({
	timepicker:false,
	<?php $date = Modules::run('outlet/_get_date_format_id'); 
	if($date==1)
	{
	 ?>
	format:'Y/m/d'
	<? }
	elseif($date==2)
	{
	 ?>
	format:'m/d/Y'
	<? }
	elseif($date==3)
	{
	?>
	format:'d/m/Y'
	<? } ?>
});
<?php
if(!empty($update_id))
{
	?>
	$("#lstLanguage").css("pointer-events", "none");
	$("#lstLanguage").css("cursor", "default");
	<?php
}
?>
</script>