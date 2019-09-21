<?php  error_reporting(0); ?>
<div class="container" style="padding:0 5px; 0 0;">
<!-- Panel For Add post -->

<div class="panel panel-default">
    <div class="panel-body">
        <h4 style="color:black;">  Post An Add</h4>
    </div>
</div>
<?php
   $attributes = array('autocomplete' => 'off', 'id' => 'fileupload', 'class' => 'form-horizontal');
        if (empty($update_id)) {
			$update_id = 0;
        } else {
			$hidden = array('hdnId' => $update_id); ////edit case
        }
        if (isset($hidden) && !empty($hidden))
			echo form_open_multipart(ADMIN_BASE_URL . 'front/add_post_action/' . $update_id , $attributes, $hidden);
        else
			echo form_open_multipart(ADMIN_BASE_URL . 'front/add_post_action/' . $update_id , $attributes);
?>
<div class="row">
<div class="row general-class">
        <div class="col-lg-8">
          <div class="form-group">
          <?php
          $options = array('' => 'Select') + $post_main_cats;
          $attribute = array('class' => 'control-label col-md-4');
          echo form_label('Category', '  category_id', $attribute);?>
          <div class="col-md-8"><?php echo form_dropdown('category_id', $options, $items['category_id'], 'class="form-control select2me " id="lstCat" onchange="get_sub_category()" required');?></div>
          </div>
        </div>
</div>
</div>

<!-- sub cat Drop down start -->
<div class="row">
    <div class="row general-class">
    <div class="col-lg-8 catts">
        <div class="form-group">
        <?php
        $options = array('' => 'Select') + $post_sub_cats;
        $attribute = array('class' => 'control-label col-md-4 ');
        echo form_label('Sub Category-', '  lstCatsub', $attribute);?>
        <div class="col-md-8"><?php echo form_dropdown('lstCatsub', $options, $items['lstCatsub'], 'class="form-control select2me" id="lstCatsub" onchange="get_feature()"'); ?></div>
        </div>
    </div>
    </div>
</div>

<div class="panel panel-default inner_item_feature">
<div class="panel-body">
      <div id='item_feature'></div>
</div>
</div>

	
    <div id="InputsWrapper">
    	<div class="container">
        <div class="row col-lg-12">
            <div class="form-group">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-group col-lg-12">
                    	<label class="control-label col-lg-8 ">Select file to Upload</label>
                        <span class="input-group-btn">
                            <span class="uneditable-input">
                                <i class="fa fa-file fileupload-exists"></i>
                                <span class="fileupload-preview"><?php if(isset($document['file']) && !empty($document['file'])){ echo $document['file'];}?></span>
                            </span>
                        </span>
                        <button class="btn btn-default pull-right AddMoreFileBox" type="button">Add Image <i class="fa fa-plus"></i></button>
                        <span class="btn default btn-file">
                            <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                            <input type="file" id ="document_file_1" class="document_file default" name="document_file[]"  extension= "docx|doc|pdf|ppt|jpg|jpeg|xls|xlsx" field_count="1" />
							<?php echo form_input(array('name' => 'hdn_document[]', 'type' => 'hidden', 'id' => 'hdn_document_1'));?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="form-actions fluid no-mrg">
    <div class="row">
        <div class="col-md-6">
        <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
        <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
        <a href="">
        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
        </a> </div>
        </div>
    <div class="col-md-6"> </div>
    </div>
</div>
 <?php echo form_close(); ?> 

    <!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
</div>
<script>
$(document).ready(function() {
	var MaxInputs       = 20; //maximum input boxes allowed
	var InputsWrapper   = $("#InputsWrapper"); //Input boxes wrapper ID
	var AddButton       = $(".AddMoreFileBox"); //Add button ID
	var x = InputsWrapper.length; //initlal text box count
	var FieldCount = 1; //to keep track of text box added 2

	var label_1 = 'Select file';
	var label_2 = 'Change';

	$(AddButton).click(function (e)  //on add input button click
	{
	if(x <= MaxInputs) //max input box allowed
	{
		FieldCount++; //text box added increment
		$(InputsWrapper).append('<div class="container"><div class="row col-lg-12"><div class="form-group"><div class="fileupload fileupload-new" data-provides="fileupload"><div class="input-group col-lg-12"><label class="control-label col-lg-8 ">Select file to Upload</label><div class=""<span class="input-group-btn"><span class="uneditable-input"><i class="fa fa-file fileupload-exists"></i><span class="fileupload-preview"></span></span></span><span class="btn default btn-file"><span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span><span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span><input type="file" id="document_file_'+FieldCount+'" class="document_file default" name="document_file[]" extension="docx|doc|pdf|ppt|jpg|jpeg|xls|xlsx" field_count="'+FieldCount+'"><input type="hidden" name="hdn_document[]" value="" id="hdn_document_'+FieldCount+'"></span></div></div></div></div></div>');
		x++; //text box increment
	}
	return false;
	});
	
	$("body").on("click",".removeclass", function(e){ //user click on remove text
	if( x >= 1 ) {
		$(this).parent().parent('div').remove(); //remove text box
		x--; //decrement textbox
	}
	return false;
	}) 
	///////////////////////////////////////////////////////////////////////////////


})
</script>
<script type="text/javascript">
function get_sub_category(){
        cat_id = $("#lstCat").val();
        if (cat_id == '') {
        $( "#item_feature" ).empty();
        };
        $.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>catagories/get_sub_category_dropdown",
        data: {'id': cat_id},
        async: false,
        success: function(result) {
        $('.catts').html(result);
        }
});
// get_feature();
}
function get_feature(){
    cat_id = $("#lstCat").val();
    sub_category_id = $("#lstCatsub").val();
    if (sub_category_id == '' )
    {
    sub_category_id = 0;
    $( "#item_feature" ).empty();
    return false;
}
$.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>category_feature/getfeature_category",
        data: {'item_id':<?=$update_id?>, 'category_id': cat_id, 'sub_category_id':  sub_category_id},
        async: false,
        success: function(result) {
			//alert(result);
        $('#item_feature').html(result);
        }
});
}
</script>