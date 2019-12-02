<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        
      <h3>Fee History</h3>             
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">
         
            <div class="tab-pane  active" >
              <div class="portlet box green ">
                
                <div class="portlet-body form " style="padding-top:15px;"> 
                <form method="POST" action="fee_history/show_history">
                <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                <div class="col-sm-5">
                    <div class="form-group">
                    <?php
                    $options = array('' => 'Select')+$program_title ;
                    $attribute = array('class' => 'control-label col-md-4');
                    echo form_label('Select Program <span style="color:red">*</span>', 'program_id', $attribute);?>
                    <div class="col-md-8"><?php echo form_dropdown('program_id', $options, '1',  ' required="required"class="form-control select2me required" id="program_id" tabindex ="1"'); ?></div>                            
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
                        </select>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div class="row" style="padding-top: 20px">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'date_from',
                            'id' => 'date_from',
                            'class' => 'form-control datetimepicker2',
                            'type' => 'text',
                            'tabindex' => '4',
                            'placeholder' => 'Select date from',
                            'required' => 'required',
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                          <?php echo form_label('From<span style="color:red">*</span>', 'dob', $attribute); ?>

                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'date_to',
                            'id' => 'date_to',
                            'class' => 'form-control datetimepicker2',
                            'type' => 'text',
                            'tabindex' => '5',
                            'placeholder' => 'Select date to',
                            'required' => 'required',
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>
                          <?php echo form_label('To<span style="color:red">*</span>', 'dob', $attribute); ?>

                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    
                </div>
                </div>


                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px; padding-top: 30px;">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Select</button>
                      </div>
                    </div>
                  </div>
                </div>
                </form>
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
</script>