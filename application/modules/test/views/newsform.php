<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add test';
                else 
                    $strTitle = 'Edit test';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'test'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'test/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'test/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'test_title',
                                                        'id' => 'test_title',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'required' => 'required',
                                                        'tabindex' => '1',
                                                        'value' => $news['test_title'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Title<span style="color:red">*</span>', 'test_title', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                     <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'test_description',
                                                        'id' => 'test_description',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '2',
                                                        'required' => 'required',
                                                        'value' => $news['test_description'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Description<span style="color:red">*</span>  ', 'test_description', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      </div>
                     <div class="row">
                      <div class="col-sm-5">
                                    <div class="form-group">
                                      <div class="control-label col-md-4">
                                        <label>Program</label>
                                        <span style="color:red">*</span>
                                      </div>
                                      <div class="col-md-8">
                                        <select name="program_id" id="program_id" class="form-control">
                                        <option value="">Select</option>
                                        <?php if(isset($programs) && !empty($programs))
                                        foreach ($programs as $key => $value):?>
                                          <option <?php if(isset($news['program_id']) && $news['program_id'] == $value['id']) echo "selected"; ?> value="<?php echo $value['id'].','.$value['name'] ?>"><?=$value['name'];?></option>
                                        <?php endforeach; ?>
                                      </select>
                                      </div>
                                      
                                    </div>
                      </div>
                      <div class="col-sm-5">
                                    <div class="form-group">
                                    <?php
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label('Class <span style="color:red">*</span>', 'class_id', $attribute);?>
                                    <div class="col-md-8">
                                      <select class="form-control" id="class_id" required="required" name="class_id" >
                                        <option value="">Select</option>
                                        <?php if(isset($news['class_name']) && !empty($news['class_name'])) { ?>
                                        <option selected value="<?php echo $news['class_id'].','.$news['class_name']; ?>"><?php echo $news['class_name'];?></option>
                                      <?php } ?>
                                      </select>
                                      </div>
                                    </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                                    <div class="form-group">
                                    <?php
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label('Section <span style="color:red">*</span>', 'section_id', $attribute);?>
                                    <div class="col-md-8">
                                      <select class="form-control" id="section_id" required="required" name="section_id" >
                                        <option value="">Select</option>
                                        <?php if(isset($news['section_name']) && !empty($news['section_name'])) { ?>
                                        <option selected value="<?php echo $news['section_id'].','.$news['section_name']; ?>"><?php echo $news['section_name'];?></option>
                                      <?php } ?>
                                      </select>
                                      </div>
                                    </div>
                    </div>
                      <div class="col-sm-5">
                                    <div class="form-group">
                                    <?php
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label('Subject <span style="color:red">*</span>', 'subject_id', $attribute);?>
                                    <div class="col-md-8">
                                      <select class="form-control" id="subject_id" required="required" name="subject_id" >
                                        <option value="">Select</option>
                                        <?php if(isset($news['subject_name']) && !empty($news['subject_name'])) { ?>
                                          <option  selected value="<?php echo $news['subject_id'].','.$news['subject_name']; ?>"><?php echo $news['subject_name'];?></option>
                                        <?php } ?>

                                      </select>
                                      </div>
                                    </div>
                    </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'test_date',
                                                        'id' => 'test_date',
                                                        'class' => 'form-control datetimepicker2',
                                                        'type' => 'text',
                                                        'placeholder' => 'Select Date',
                                                        'tabindex' => '6',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $news['test_date'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Test Date<span style="color:red">*</span>', 'test_date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'test_time',
                                                        'id' => 'test_time',
                                                        'class' => 'form-control datetimepicker4',
                                                        'type' => 'text',
                                                        'placeholder' => 'Select Time',
                                                        'tabindex' => '7',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $news['test_time'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Test Time<span style="color:red">*</span>', 'test_time', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'total_marks',
                                                        'id' => 'total_marks',
                                                        'class' => 'form-control',
                                                        'type' => 'number',
                                                        'required' => 'required',
                                                        'tabindex' => '1',
                                                        'value' => $news['total_marks'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Total Marks<span style="color:red">*</span>', 'total_marks', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?>  <span id="message"></span></div>
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
                        <a href="<?php echo ADMIN_BASE_URL . 'test'; ?>">
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
  $("#program_id").change(function () {
        var program_id = this.value;
       $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>test/get_class",
            data: {'id': program_id },
            async: false,
            success: function(result) {
            $("#class_id").html(result);
          }
        });
  });

  $("#class_id").change(function () {
        var class_id = this.value;
           $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>test/get_section",
            data: {'id': class_id },
            async: false,
            success: function(result) {
            $("#section_id").html(result);
          }
        });
  });

  $("#section_id").change(function () {
        var section_id = this.value;
       $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>test/get_subject",
            data: {'id': section_id },
            async: false,
            success: function(result) {
            $("#subject_id").html(result);
          }
        });
  });

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });



</script>