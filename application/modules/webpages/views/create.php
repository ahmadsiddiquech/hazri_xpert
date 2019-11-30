<div class="page-content-wrapper">
  <div class="page-content"> 
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="contractors_measurements_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body"> Widget settings form goes here </div>
          <div class="modal-footer">
            <button type="button" class="btn green" id="confirm"><i class="fa fa-check"></i>&nbsp;Save changes</button>
            <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;Close</button>
          </div>
        </div>
        <!-- /.modal-content --> 
      </div>
      <!-- /.modal-dialog --> 
    </div>
    <!-- /.modal --> 
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM--> 
    <!-- BEGIN PAGE HEADER-->
    <div class="content-wrapper">
      <h3>
      
          <?php
                    if (empty($update_id)) 
                        $strTitle = 'Add Webpage';
                    else 
                        $strTitle = 'Edit Webpage';
                    
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'webpages'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
    </h3>
      
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content" style="margin-top:-30px;">
          <div class="panel panel-default">
         
            <div class="tab-pane  active" id="tab_2">
              <div class="portlet box green">
                <div class="portlet-title"></div>
                                             <div class="portlet-body form" style="padding-top:15px;">
                                    <!-- BEGIN FORM-->
                                       
                                    <div class="form-body">
                                        <!--<h3 class="form-section">Webpages Information</h3>-->
  <?php 
  $attributes = array('autocomplete' => 'off', 'id' => 'frmWebpages');
  if(empty($update_id))
  {
    $update_id = 0;
  }
  echo form_open(ADMIN_BASE_URL.'webpages/submit/'.$update_id,$attributes); ?>
<div class="row" Description>
    <div class="col-sm-6" >
        <div class="form-group"> 
        <?php
        $data = array(
        'name'        => 'txtPageTitle',
        'maxlength'   => '30',
        'id'          => 'txtPageTitle',
        'class'     => 'form-control form-control1 text-input col-md-9',
        'value'       => $webpage['page_title'],
        'required'   => 'required',
        );
    $attribute = array('class' => 'control-label form-control1 col-md-3');
        echo form_label('Page Title <span class="required" style="color:red">*</span>','txtPageTitle', $attribute);
        echo '<div class="col-md-9" style="margin-bottom:15px;">'.form_input($data).'</div>';
        ?>
        </div>
        <div class="form-group" >
        <?php
        $data = array(
        'name'        => 'txtPageUrl',
        'id'          => 'txtPageUrl',
        'maxlength'   => '60',
        'class'     => 'form-control form-control1',
        'value'       => $webpage['url_slug'],
        'type' => 'text',
        );
    $attribute = array('class' => 'control-label form-control1 col-md-3');
        echo form_label('Page Slug ','txtPageUrl', $attribute);
        echo '<div class="col-md-9" style="margin-bottom:15px;">'.form_input($data).'</div>';
        ?>
        </div>
        <div class="form-group">
        <?php
        $options = array(''=> '---select--') + $rank;
    $attribute = array('class' => 'control-label  col-md-3');
        echo form_label('Page Rank ','lstRank', $attribute);
        echo '<div class="col-md-9">'.form_dropdown('lstRank', $options,$webpage['page_rank'], 'class = "form-control  form-control1 select2me " id = "lstRank"').'</div>';
        ?>
        </div>
    </div>
    <div class="col-sm-6">
      
         <div class="form-group">
                          <?php
                                                        $data = array(
                                                            'name' => 'txtMetaDesc',
                                                            'id' => 'maxlength_textarea',
                                                            'rows' => '11',
                                                            'cols' => '10',
                                                            'class' => 'form-control note-editor',
                                                            'value' => $webpage['meta_description']

                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        echo form_label('Short Description', 'txtMetaDesc', $attribute);
                                                        ?>
                          <div class="col-md-8"> <?php echo form_textarea($data); ?> </div>
                        </div>    
    </div>
</div>
<div class="row"  style="padding-top:5px;">
   

                      <div class="col-lg-12">
                        <div class="form-group">
                            <?php 
                            $attribute = array('class' => 'control-label col-md-2');
                            echo form_label('Long Description', 'txtPageCont', $attribute);
                            ?>
                          <div class="col-md-9" style="float:left; margin-left:135px; margin-bottom:60px;"><textarea class="ckeditor form-control" name="txtPageCont" rows="6"><?php echo $webpage['page_content']?></textarea></div>
                        </div>
                      </div>
                    
</div>                                                                             
  </div>
                                   
                                    
                                </div>
                
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-3 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span><input type="submit" class="btn btn-primary" value="Save">
                        <a href="<?php echo ADMIN_BASE_URL . 'webpages'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
                    </div>
                    <div class="col-md-6"> </div>
                  </div>
                </div>   
  <?php echo form_close(); ?> 
                <!-- END FORM--> 
                
                
                
                
                
               </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<script>
$(document).ready(function() {
	
	////////////////////  FOR TEXT PAGE TITLE ////////////////////////////////////////	
$(document).off("focusout","#txtPageTitle").on("focusout","#txtPageTitle", function(event) {
    //alert('heelo');
		event.preventDefault();
		var page_title = $(this).val();
    var id = <?=$update_id?>;
		$.ajax({
			type: 'POST',
			url: "<?= ADMIN_BASE_URL ?>webpages/check_page_title",
			data: {'page_title': page_title, 'id':id},
			async: false,
			success: function(result) {
				if(result == true){
					toastr.error('Webpage Title already exist.');
					//$("#txtPageTitle").val('');
					$("#txtPageTitle").focus();
				}
			}
		});
	});	
//////////////////////////////////////////////////////////////////////////////////

////////////////////////   FOR TEXTPAGURL   ///////////////////////////////////	
$(document).off("focusout","#txtPageUrl").on("focusout","#txtPageUrl", function(event) {
		event.preventDefault();
		var page_title = $(this).val();
    var id = <?=$update_id?>;
		$.ajax({
			type: 'POST',
			url: "<?= ADMIN_BASE_URL ?>webpages/check_page_url",
			data: {'url_slug': page_title, 'id':id},
			async: false,
			success: function(result) {
				if(result == true){
					toastr.error('Webpage URL already exist.');
					//$("#txtPageUrl").val('');
					$("#txtPageUrl").focus();
				}
			}
		});
	});	
////////////////////////////////////////////////////////////////////////////////	

    $(document).on('keypress', '.wysiwyg', function(){
        $("#hdn_textarea").val( $(".wysiwyg").html() );
    });
    $(document).on('click', '.btn-group', function(){
        $("#hdn_textarea").val( $(".wysiwyg").html() );
    });
});
</script>