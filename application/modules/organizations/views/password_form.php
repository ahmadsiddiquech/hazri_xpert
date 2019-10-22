<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="row">
      <div class="col-md-12">
            <div class="tab-pane  active" id="tab_2">
              <div class="portlet box green">
                <div class="portlet-title">
                </div>
                <div class="portlet-body form"> 
                  
                  <!-- BEGIN FORM-->
                  <?php
                                    $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal' , 'data-parsley-validate' => '', 'novalidate' => '');
                                    if (empty($update_id)) {
                                        $update_id = 0;
                                    } else {
                                        $hidden = array('hdnId' => $update_id); ////edit case
                                    }
                                    if (isset($hidden) && !empty($hidden))
                                        echo form_open_multipart(ADMIN_BASE_URL . 'organizations/change_pass/' . $update_id , $attributes, $hidden);
                                    else
                                        echo form_open_multipart(ADMIN_BASE_URL . 'organizations/change_pass/' . $update_id , $attributes);
                                    ?>
                  <div class="form-body" style="margin-top:15px">
                   
                    
                    <div class="row">
                   
                       <div class="col-sm-12">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'org_email',
                                                        'id' => 'org_email',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'value' => $users['org_email'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        'readonly'=>'true',
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Email ', 'org_email', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      
                       <div class="col-sm-12">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'password',
                                                        'id' => 'password',
                                                        'class' => 'form-control',
                                                        'type' => 'password',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('New Password <span class="required" style="color:red">*</span>', 'password', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
              
                  
                </div>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-2" style="margin-left:100px;">
                     <div class="col-md-offset-3 col-md-3" style="padding-bottom:15px; margin-left:75px;">
                        <button type="submit" class="btn btn-primary " style="margin-left:10px;"><i class="fa fa-check"></i>&nbsp;Save</button>
                    </div>
                  </div>
                  </div>
                  </div>
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


<script>
  $('#form_sample_1').parsley();
    jQuery(document).ready(function() {
        // binds form submission and fields to the validation engine
        //  jQuery("#frmNews").validationEngine();
    });
    /*$('#txtNewsDate').datetimepicker({
     timepicker:false,
     });*/
<?php
if (!empty($update_id)) {
    ?>
        $("#lstLanguage").css("pointer-events", "none");
        $("#lstLanguage").css("cursor", "default");
    <?php
        }
        ?>
      $(document).ready(function() {
        $("#zabiha_res_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });
</script>