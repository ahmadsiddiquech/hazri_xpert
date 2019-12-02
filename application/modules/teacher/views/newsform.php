<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add teacher';
                else 
                    $strTitle = 'Edit Teacher';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'teacher'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
       </h3>             
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">
         
            <div class="tab-pane  active" >
              <div class="portlet box green ">
                
                <div class="portlet-body form " style="padding-top:15px;"> 
                  
                  <!-- BEGIN FORM-->
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'teacher/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'teacher/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'name',
                                                        'id' => 'name',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'required' => 'required',
                                                        'tabindex' => '1',
                                                        'value' => $news['name'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Name<span style="color:red">*</span>', 'name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5" id="pass">
                        <div class="form-group">
                          <?php
                                                      $data = array(
                                                        'name' => 'password',
                                                        'id' => 'password',
                                                        'class' => 'form-control',
                                                        'type' => 'password',
                                                        'tabindex' => '9',
                                                        'required' => 'required',
                                                        'value' => $news['password'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                        'required' => 'required'
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Password<span style="color:red">*</span>', 'password', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      </div>
                    <div class="row">
                     <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'phone',
                                                        'id' => 'phone',
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'tabindex' => '3',
                                                        'required' => 'required',
                                                        'value' => $news['phone'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Phone<span style="color:red">*</span> ', 'phone', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> <span id="message"></span></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'email',
                                                        'id' => 'email',
                                                        'class' => 'form-control',
                                                        'type' => 'email',
                                                        'tabindex' => '4',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $news['email'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Email<span style="color:red">*</span>', 'email', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                     <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'user_address',
                                                        'id' => 'user_address',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '5',
                                                        'required' => 'required',
                                                        'value' => $news['user_address'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Address<span style="color:red">*</span> ', 'user_address', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'cnic',
                                                        'id' => 'cnic',
                                                        'class' => 'form-control',
                                                        'pattern' => '[0-9]{13}',
                                                        'title' => 'Enter 13 Digit CNIC',
                                                        'tabindex' => '6',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $news['cnic'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('CNIC<span style="color:red">*</span>', 'cnic', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'about',
                                                        'id' => 'about',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '7',
                                                        'value' => $news['about'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('About ', 'about', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'gender',
                                                        'id' => 'gender',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '8',
                                                        'value' => $news['gender'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Gender<span style="color:red">*</span>', 'gender', $attribute); ?>
                          <div class="col-md-8"> 
                            <select name="gender" required="required" class="form-control">
                              <option value="">Select</option>
                              <option value="Male" <?php if($news['gender']=='Male') echo "selected"; ?>>Male</option>
                              <option value="Female" <?php if($news['gender']=='Female') echo "selected"; ?>>Female</option>
                              <option value="Other" <?php if($news['gender']=='Other') echo "selected"; ?>>Other</option>
                            </select>
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
                       <span style="margin-left:40px"></span> <button type="submit" id="button1" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'teacher'; ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        </a> </div>
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
</div>
</div>


<script>

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });

  $("#phone").change(function () {
  var phone = this.value;
  // alert(org_email);
  $.ajax({
      type: 'POST',
      url: "<?php echo ADMIN_BASE_URL?>teacher/validate",
      data: {'phone':phone},
      async: false,
      success: function(result) {
        if (result == '1') {
           $("#message").html("<span style='color:red;'>Number Already Taken</span>").show(); 
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