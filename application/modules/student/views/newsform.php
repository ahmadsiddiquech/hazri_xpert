<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add student';
                else 
                    $strTitle = 'Edit student';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'student'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'student/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'student/submit/' . $update_id, $attributes);
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
                            $data = array(
                            'name' => 'parent_name',
                            'id' => 'parent_name',
                            'class' => 'form-control',
                            'type' => 'text',
                            'tabindex' => '2',
                            'required' => 'required',
                            'value' => $news['parent_name'],
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                          <?php echo form_label('Parent Name<span style="color:red">*</span>  ', 'parent_name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php

                          $options = array('' => 'Select')+$parent_title ;
                          $attribute = array('class' => 'control-label col-md-4');
                          echo form_label('Select Parent', 'parent_id', $attribute);?>
                          <div class="col-md-8"><?php echo form_dropdown('parent_id', $options, $news['parent_id'],  'class="form-control select2me" id="parent_id" tabindex ="3"'); ?>
                          </div>
                        </div>
                    </div>
                     <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'p_c_no',
                            'id' => 'p_c_no',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '4',
                            'required' => 'required',
                            'value' => $news['p_c_no'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Parent Phone<span style="color:red">*</span> ', 'p_c_no', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'address',
                            'id' => 'address',
                            'class' => 'form-control',
                            'type' => 'text',
                            'tabindex' => '5',
                            'value' => $news['address'],
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                          <?php echo form_label('Address', 'address', $attribute); ?>
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
                            'required' => 'required',
                            'value' => $news['gender'],
                            'tabindex' => '6',
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                          <?php echo form_label('Gender<span style="color:red">*</span>', 'gender', $attribute); ?>
                          <div class="col-md-8"> 
                            <select name="gender" class="form-control">
                              <option <?php if($news['gender'] == 'Male') echo "selected"; ?> value="Male">Male</option>
                              <option <?php if($news['gender'] == 'Female') echo "selected"; ?> value="Female">Female</option>
                              <option <?php if($news['gender'] == 'Other') echo "selected"; ?> value="Other">Other</option>
                            </select>
                      </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'dob',
                            'id' => 'dob',
                            'class' => 'form-control datetimepicker2',
                            'type' => 'text',
                            'tabindex' => '7',
                            'max' => '2016-12-31',
                            'required' => 'required',
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                            'value' => $news['dob'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                          <?php echo form_label('Date of Birth<span style="color:red">*</span>', 'dob', $attribute); ?>

                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    
                    <div class="row">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'addmission_date',
                            'id' => 'addmission_date',
                            'class' => 'form-control datetimepicker2',
                            'type' => 'text',
                            'tabindex' => '8',
                            'required' => 'required',
                            'min' => '2010-12-30',
                            'value' => $news['addmission_date'],
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                          <?php echo form_label('Addmission Date<span style="color:red">*</span>', 'addmission_date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      </div>
                     <div class="row">
                      <div class="col-sm-5">
                      <div class="form-group">
                        <?php

                        $options = array('' => 'Select')+$program_title ;
                        $attribute = array('class' => 'control-label col-md-4');
                        echo form_label('Program <span style="color:red">*</span>', 'program_id', $attribute);?>
                        <div class="col-md-8"><?php echo form_dropdown('program_id', $options, $news['program_id'],  'required="required" class="form-control select2me required" id="program_id" tabindex ="9"'); ?>
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
                            <?php if(isset($class_data) && !empty($class_data)){
                              foreach ($class_data as $key => $class_value): ?>
                              <option <?php if($class_value['id'] == $news['class_id']) echo "selected"; ?> value="<?=$class_value['id'];?>">
                              <?php if(isset($class_value['name']) && !empty($class_value['name'])){
                            echo $class_value['name'];}?>
                              </option>
                            <?php endforeach; } ?>
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
                          <?php if(isset($setion_data) && !empty($setion_data)){
                            foreach ($setion_data as $key => $section_value): ?>
                            <option <?php if($section_value['id'] == $news['section_id']) echo "selected"; ?> value="<?=$section_value['id'];?>">
                            <?php if(isset($section_value['section']) && !empty($section_value['section'])){
                          echo $section_value['section'];}?>
                            </option>
                          <?php endforeach; } ?>
                        </select>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-5">
                    <div class="form-group">
                    <div class="control-label col-md-4">
                      <label>Roll No. <span style="color:red">*</span></label>
                    </div>
                    <div class="col-md-8">
                      <select class="check_roll_no form-control roll_no_list" id="roll_no" required="required" name="roll_no" >
                        <option value="">Select</option>
                        <?php 
                          for ($i=$roll_from; $i <=$roll_to; $i++) { ?>
                          <option <?php if($news['roll_no'] == $i) echo "selected" ?> value="<?=$i;?>"><?=$i;?></option>
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
                        echo form_label('Optional Subject', 'subject_id', $attribute);?>
                        <div class="col-md-8">
                          <select class="subject_id form-control" id="subject_id" name="subject_id" >
                            <option value="">Select</option>
                            <?php if(isset($subject_data) && !empty($subject_data)){
                              foreach ($subject_data as $key => $subject_value): ?>
                              <option <?php if($subject_value['id'] == $news['subject_id']) echo "selected"; ?> value="<?=$subject_value['id'];?>">
                              <?php if(isset($subject_value['name']) && !empty($subject_value['name'])){
                            echo $subject_value['name'];}?>
                              </option>
                            <?php endforeach; } ?>
                          </select>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'tution_fee',
                            'id' => 'tution_fee',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '14',
                            'required' => 'required',
                            'value' => $news['tution_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Tution Fee<span style="color:red">*</span> ', 'tution_fee', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'transport_fee',
                            'id' => 'transport_fee',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '15',
                            'value' => $news['transport_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Transort Fee', 'transport_fee', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                     <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'lunch_fee',
                            'id' => 'lunch_fee',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '16',
                            'value' => $news['lunch_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Lunch Fee', 'lunch_fee', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'stationary_fee',
                            'id' => 'stationary_fee',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '17',
                            'value' => $news['stationary_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Stationary Fee', 'stationary_fee', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                     <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'other_fee',
                            'id' => 'other_fee',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '18',
                            'value' => $news['other_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Other Fee', 'other_fee', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group last">
                                        <label class="control-label col-md-4">Image Upload<span style="color:red">*</span> </label>
                                        <div class="col-md-8">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                                    <?
                                                    if (isset($news['image']) && !empty($news['image'])) {
                                                    ?>
                                                    <img src = "<?php echo base_url() . 'uploads/student/medium_images/' . $news['image'] ?>" />
                                                    <?php
                                                } else {
                                                    ?>
                                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                            </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileupload-new">
                                                        <i class="fa fa-paper-clip"></i> Select image
                                                    </span>
                                                    <span class="fileupload-exists">
                                                        <i class="fa fa-undo"></i> Change
                                                    </span>
                                                    <input type="file" name="news_file" id="news_file" class="default" />
                                                    <input required="" type="hidden" id="hdn_image" value="<?php if(isset($news['image'])) echo $news['image'] ?>" name="hdn_image"/>
                                                </span>
                                                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                                            </div>
                                        </div>
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
                        <a href="<?php echo ADMIN_BASE_URL . 'student'; ?>">
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

   $("#section_id").change(function () {
        section_id = this.value;
       // alert(end);
       $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>student/get_roll_no",
            data: {'id': section_id},
            async: false,
            success: function(result) {
            $(".roll_no_list").html(result);
            }
        });
      });

   $("#section_id").change(function () {
        section_id = this.value;
       // alert(end);
       $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>student/get_subject",
            data: {'id': section_id},
            async: false,
            success: function(result) {
            $(".subject_id").html(result);
            }
        });
      });

   $(".check_roll_no").change(function () {
        var roll_no = this.value;
        var section_id = $(this).parent().parent().parent().parent().find('#section_id').val()
       $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>student/check_roll_no",
            data: {'id': roll_no ,'section_id':section_id},
            async: false,
            success: function(result) {
            if (result == "true") {
              toastr.error('Roll No. already Taken');
              document.getElementById("button1").disabled = true;
            }
            else{
              document.getElementById("button1").disabled = false;
            }
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