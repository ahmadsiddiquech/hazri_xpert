<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add timetable';
                else 
                    $strTitle = 'Edit timetable';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'timetable'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'timetable/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'timetable/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
               
                     <div class="row" style="margin-top:15px;">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <div class="control-label col-md-4">
                            <label>Program</label>
                            <span style="color:red">*</span>
                          </div>
                          <div class="col-md-8">
                            <select name="program_id" id="program_id" class="form-control" >
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
                              $data = array(
                              'name' => 'day',
                              'id' => 'day',
                              'class' => 'form-control',
                              'type' => 'text',
                              'tabindex' => '5',
                              'value' => $news['day'],
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Day<span style="color:red">*</span>', 'day', $attribute); ?>
                          <div class="col-md-8"> 
                            <select name="day" required="required" class="form-control check_day">
                              <option value="">Select</option>
                              <option value="Monday" <?php if($news['day']=='Monday') echo "selected"; ?>>Monday</option>
                              <option value="Tuesday" <?php if($news['day']=='Tuesday') echo "selected"; ?>>Tuesday</option>
                              <option value="Wednesday" <?php if($news['day']=='Wednesday') echo "selected"; ?>>Wednesday</option>
                              <option value="Thursday" <?php if($news['day']=='Thursday') echo "selected"; ?>>Thursday</option>
                              <option value="Friday" <?php if($news['day']=='Friday') echo "selected"; ?>>Friday</option>
                              <option value="Saturday" <?php if($news['day']=='Saturday') echo "selected"; ?>>Saturday</option>
                            </select>
                      </div>
                        </div>
                      </div>
                      </div>
                    <hr>
                    <div class="row" id="inputbox" style="padding-left: 90px; padding-bottom: 30px">
                    </div>
                    
                </div>
                </div>



                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" id="button1" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'timetable'; ?>">
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

  $("#section_id").change(function () {
        var section_id = this.value;
           $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>timetable/get_subject",
            data: {'id': section_id },
            async: false,
            success: function(result) {
            $("#inputbox").html(result);
          }
        });
  });

  $(".check_day").change(function () {
        var day = this.value;
        var section_id = $(this).parent().parent().parent().siblings().find('#section_id').val()
        // alert(day);
       $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>timetable/check_day",
            data: {'day': day ,'section_id':section_id},
            async: false,
            success: function(result) {
            if (result == 1) {
              toastr.error('Timetable for this day already generated');
              document.getElementById("button1").disabled = true;
            }
            else{
              document.getElementById("button1").disabled = false;
            }
            }
        });
      });
</script>