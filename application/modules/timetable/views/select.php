<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        
      <h3>Timetable Record<a href="timetable/create"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<b>Add Timetable</b></button></a></h3>            
            
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">
         
            <div class="tab-pane  active" >
              <div class="portlet box green ">
                
                <div class="portlet-body form " style="padding-top:15px;"> 
                <form method="POST" action="timetable/manage">
                <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                <div class="col-sm-5">
                    <div class="form-group">
                    <?php
                    $options = array('' => 'Select')+$program_title ;
                    $attribute = array('class' => 'control-label col-md-4');
                    echo form_label('Select Program <span style="color:red">*</span>', 'program_id', $attribute);?>
                    <div class="col-md-8"><?php echo form_dropdown('program_id', $options, '1',  ' required="required"class="form-control select2me required" id="program_id" tabindex ="2"'); ?></div>                            
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
            url: "<?php echo ADMIN_BASE_URL?>timetable/get_class",
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
            url: "<?php echo ADMIN_BASE_URL?>timetable/get_section",
            data: {'id': class_id },
            async: false,
            success: function(result) {
            $("#section_id").html(result);
          }
        });
  });
</script>