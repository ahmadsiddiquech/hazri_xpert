<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add installment';
                else 
                    $strTitle = 'Edit installment';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'installment'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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

                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'installment/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'installment/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                     <div class="row" style="margin-top: 15px;">
                      <div class="col-sm-5">
                                    <div class="form-group">
                                      <div class="control-label col-md-4">
                                        <label>Program</label>
                                        <span style="color:red">*</span>
                                      </div>
                                      <div class="col-md-8">
                                        <select name="program_id" id="program_id" class="form-control" <?php
                                        if (isset($update_id) && !empty($update_id)) {
                                          echo "disabled";
                                        }
                                        ?>>
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
                                      <select class="form-control" id="class_id" required="required" name="class_id" <?php
                                        if (isset($update_id) && !empty($update_id)) {
                                          echo "disabled";
                                        }
                                        ?>>
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
                                      <select class="form-control" id="section_id" required="required" name="section_id" <?php
                                        if (isset($update_id) && !empty($update_id)) {
                                          echo "disabled";
                                        }
                                        ?>>
                                        <option value="">Select</option>
                                        <?php if(isset($news['section_name']) && !empty($news['section_name'])) { ?>
                                        <option selected value="<?php echo $news['section_id'].','.$news['section_name']; ?>"><?php echo $news['section_name'];?></option>
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
                                                        'name' => 'issue_date',
                                                        'id' => 'issue_date',
                                                        'class' => 'form-control datetimepicker2',
                                                        'type' => 'text',
                                                        'placeholder' => 'Select Date',
                                                        'tabindex' => '6',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $news['issue_date'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Issue Date<span style="color:red">*</span>', 'issue_date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'due_date',
                                                        'id' => 'due_date',
                                                        'class' => 'form-control datetimepicker2',
                                                        'type' => 'text',
                                                        'placeholder' => 'Select Date',
                                                        'tabindex' => '6',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $news['due_date'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Due Date<span style="color:red">*</span>', 'due_date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                  </div>
                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" id="button1" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Submit</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'installment'; ?>">
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
            url: "<?php echo ADMIN_BASE_URL?>installment/get_class",
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
            url: "<?php echo ADMIN_BASE_URL?>installment/get_section",
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
            url: "<?php echo ADMIN_BASE_URL?>installment/get_subject",
            data: {'id': section_id },
            async: false,
            success: function(result) {
            $("#subject_id").html(result);
          }
        });
  });
</script>