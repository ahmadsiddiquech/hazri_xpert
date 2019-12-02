<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add subjects';
                else 
                    $strTitle = 'Edit subjects';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'subjects'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'subjects/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'subjects/submit/' . $update_id, $attributes);
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
                          <div class="col-md-8"> <?php echo form_input($data); ?>  <span id="message"></span></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                                    <div class="form-group">
                                    <?php
                                    $options = array('' => 'Select')+$program_title ;
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label('Select Program <span style="color:red">*</span>', 'program_id', $attribute);?>
                                    <div class="col-md-8"><?php echo form_dropdown('program_id', $options, $news['program_id'],  ' required="required"class="form-control select2me required" id="program_id" tabindex ="2"'); ?></div>                            </div>
                    </div>
                      </div>
                    <div class="row">
                       <div class="col-sm-5">
                                    <div class="form-group">
                                    <?php
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label('Class <span style="color:red">*</span>', 'class_id', $attribute);?>
                                    <div class="col-md-8">
                                      <select class="form-control" id="class_id" required="required" name="class_id" >
                                        <option value="">Select</option>
                                        <?php if(isset($news['class_name']) && !empty($news['class_name'])) { ?>
                                        <option selected value="<?php echo $news['class_id']; ?>"><?php echo $news['class_name'];?></option>
                                        <?php } ?>
                                      </select>
                                      </div>
                                    </div>
                    </div>
                     <div class="col-sm-5">
                                    <div class="form-group">
                                    <?php
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label('Section <span style="color:red">*</span>', 'section_id', $attribute);?>
                                    <div class="col-md-8">
                                      <select class="form-control" id="section_id" required="required" name="section_id" >
                                        <option value="">Select</option>
                                        <?php if(isset($news['section_name']) && !empty($news['section_name'])) { ?>
                                        <option selected value="<?php echo $news['section_id']; ?>"><?php echo $news['section_name'];?></option>
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

                                    $options = array('' => 'Select')+$teacher_title ;
                                    $attribute = array('class' => 'control-label col-md-4');
                                    echo form_label('Select Teacher <span style="color:red">*</span>', 'teacher_id', $attribute);?>
                                    <div class="col-md-8"><?php echo form_dropdown('teacher_id', $options, $news['teacher_id'],  'required="required" class="form-control select2me required" id="teacher_id" tabindex ="5"'); ?></div>                            </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 's_type',
                                                        'id' => 's_type',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'tabindex' => '6',
                                                        'value' => $news['s_type'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Type<span style="color:red">*</span>', 's_type', $attribute); ?>
                          <div class="col-md-8"> 
                            <select name="s_type" required="required" class="form-control">
                              <option value="">Select</option>
                              <option value="Mandatory"<?php if($news['s_type']=='Mandatory') echo "selected"?>>Mandatory</option>
                              <option value="Optional"<?php if($news['s_type']=='Optional') echo "selected"?>>Optional</option>
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
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'subjects'; ?>">
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
            url: "<?php echo ADMIN_BASE_URL?>student/get_class",
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
            url: "<?php echo ADMIN_BASE_URL?>student/get_section",
            data: {'id': class_id },
            async: false,
            success: function(result) {
            $("#section_id").html(result);
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