<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        
      <h3>Attendance Record</h3>             
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">
         
            <div class="tab-pane  active" >
              <div class="portlet box green ">
                
                <div class="portlet-body form " style="padding-top:15px;"> 
                <form method="POST" action="attendance/submit">
                <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                <div class="col-sm-5">
                    <div class="form-group">
                    <?php
                    $options = array('' => 'Select')+$program_title ;
                    $attribute = array('class' => 'control-label col-md-4');
                    echo form_label('Select Program <span style="color:red">*</span>', 'program_id', $attribute);?>
                    <div class="col-md-8"><?php echo form_dropdown('program_id', $options, $news['program_id'],  ' required="required"class="form-control select2me required" id="program_id" tabindex ="2"'); ?></div>                            
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
                        <?php if(isset($news['class_name']) && !empty($news['class_name'])){
                        echo $news['class_name'];}?></option>
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
                          <?php if(isset($news['section_name']) && !empty($news['section_name'])){
                          echo $news['section_name'];}?></option></option>
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