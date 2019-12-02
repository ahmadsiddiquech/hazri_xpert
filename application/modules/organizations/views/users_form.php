<div class="page-content-wrapper">
  <div class="page-content"> 
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div id="contractors_measurements_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h4 class="modal-title">Organizations</h4>
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
          <?php if (empty($update_id)) 
                        $strTitle = 'Add Organizations';
                    else 
                        $strTitle = 'Edit Organizations';
                        echo $strTitle;
             
                 ?>
                            <a href="<?php echo ADMIN_BASE_URL . 'Organizations'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a> 
        </h3>
          
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
           <div class="tab-content" style="margin-top:-30px;">
          <div class="panel panel-default">
            <div class="tab-pane  active" id="tab_2">
              <div class="portlet box green">
                <div class="portlet-title">

                </div>
                <div class="portlet-body form"> 
                  
                  <!-- BEGIN FORM-->

                   <?php
                                    $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal', 'data-parsley-validate' => '', 'novalidate' => '' );
                                    if (empty($update_id)) {
                                        $update_id = 0;
                                    } else {
                                        $hidden = array('hdnId' => $update_id); ////edit case
                                    }
                                    if (isset($hidden) && !empty($hidden))
                                        echo form_open_multipart(ADMIN_BASE_URL . 'organizations/submit/' . $update_id , $attributes, $hidden);
                                    else
                                        echo form_open_multipart(ADMIN_BASE_URL . 'organizations/submit/' . $update_id , $attributes);
                                    ?>

          
                  <div class="form-body">
                  
                    
                        </div>
                    <div class="row" style="margin-top:15px;">
                  
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'org_name',
                                                        'id' => 'org_name',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'required' => 'required',
                                                        'tabindex' => '1',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        'value' => $users['org_name'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Organizations Name<span style="color:red">*</span>', 'org_name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?>  </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'org_phone',
                                                        'id' => 'org_phone',
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'tabindex' => '2',
                                                        'required' => 'required',
                                                        'value' => $users['org_phone']
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Organizations Phone<span style="color:red">*</span>', 'org_phone', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'owner_name',
                                                        'id' => 'owner_name',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '3',
                                                        'required' => 'required',
                                                       'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        'value' => $users['owner_name'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Owner Name<span style="color:red">*</span>', 'owner_name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                       <div class="col-sm-5">
                       <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'owner_phone',
                                                        'id' => 'owner_phone',
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'tabindex' => '4',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $users['owner_phone'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Owner Phone<span style="color:red">*</span>', 'owner_phone', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div> 
                      </div>
                     
                    </div>
                    <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'org_address',
                                                        'id' => 'org_address',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '5',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        'value' => $users['org_address'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Organizations Address', 'org_address', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'org_email',
                                                        'id' => 'org_email',
                                                        'class' => 'form-control',
                                                        'type' => 'email',
                                                        'required' => 'required',
                                                        'tabindex' => '6',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        'value' => $users['org_email'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Organizations Email<span style="color:red">*</span>', 'org_email', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> <span id="message"></span></div>
                        </div>
                      </div>
                      
                      
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                      $data = array(
                                                        'name' => 'join_date',
                                                        'id' => 'join_date',
                                                        'class' => 'form-control datetimepicker2',
                                                        'tabindex' => '7',
                                                        'required' => 'required',
                                                        'value' => $users['join_date'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Join Date <span style="color:red">*</span>', 'join_date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <?php if($update_id != 0) { ?>
                        <input type="hidden" value="true" name="chepi">
                      <?php } else{ ?>
                        <div class="col-sm-5" id="pass">
                        <div class="form-group">
                          <?php
                                                      $data = array(
                                                        'name' => 'password',
                                                        'id' => 'password',
                                                        'class' => 'form-control',
                                                        'type' => 'password',
                                                        'tabindex' => '8',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Password <span style="color:red">*</span>', 'password', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <?php } ?>
                     <div class="col-sm-5">
                                    <div class="form-group">
                                    <?php

                                    $options = array('' => 'Select')+$roles_title ;
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label('Assign Role <span style="color:red">*</span>', 'role_id', $attribute);?>
                                    <div class="col-md-8"><?php echo form_dropdown('role_id', $options, $users['role_id'],  'required="required" class="form-control select2me required" id="role_id" tabindex ="12"'); ?></div>                            </div>
                    </div>
                     
                    </div>
                  </div>
                </div>
                <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                     <div class="col-md-offset-3 col-md-9" style="padding-bottom:15px;">
                        <button type="submit" class="btn btn-primary " id="button1" tabindex="13" style="margin-left:10px;"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'organizations'; ?>">
                         <button type="button"  class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
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

<script type="text/javascript">
  
  $("#org_email").change(function () {
  var org_email = this.value;
  // alert(org_email);
  $.ajax({
      type: 'POST',
      url: "<?php echo ADMIN_BASE_URL?>organizations/validate",
      data: {'org_email':org_email},
      async: false,
      success: function(result) {
        if (result == '1') {
           $("#message").html("<span style='color:red;'>Email Already Taken</span>").show(); 
          document.getElementById("button1").disabled = true;
        }
        else{
          $("#message").html("<span class='fa fa-check' style='color:green;'></span>").show();
          document.getElementById("button1").disabled = false;
        }
      }
  });
});
 
</script> 