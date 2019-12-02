<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add Timetable Subject';
                else 
                    $strTitle = 'Edit Timetable Subject';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'timetable/subjects/'.$this->uri->segment('4');?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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

                        // print_r($news);exit();
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        } else {
                            $hidden = array('hdnId' => $update_id, 'hdnActive' => $news['status']); ////edit case
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'timetable/submit_subject_edit/' . $this->uri->segment('4').'/'. $this->uri->segment('5'), $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'timetable/submit_subject_edit/' . $this->uri->segment('4').'/'. $this->uri->segment('5'), $attributes);
                        ?>
                  <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'subject_name',
                                                        'id' => 'subject_name',
                                                        'class' => 'form-control',
                                                        'type' => 'text',
                                                        'readonly' => 'true',
                                                        'required' => 'required',
                                                        'tabindex' => '1',
                                                        'value' => $news['subject_name'],
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                                                        
                          <?php echo form_label('Subject Name<span style="color:red">*</span>', 'subject_name', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?>  <span id="message"></span></div>
                        </div>
                      </div>
                      </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'start_time',
                                                        'id' => 'start_time',
                                                        'class' => 'form-control',
                                                        'type' => 'time',
                                                        'placeholder' => 'Select Time',
                                                        'tabindex' => '6',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $news['start_time'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('Start Time<span style="color:red">*</span>', 'start_date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div><div class="col-sm-5">
                        <div class="form-group">
                          <?php
                                                        $data = array(
                                                        'name' => 'end_time',
                                                        'id' => 'end_time',
                                                        'class' => 'form-control',
                                                        'type' => 'time',
                                                        'placeholder' => 'Select Time',
                                                        'tabindex' => '6',
                                                        'required' => 'required',
                                                        'data-parsley-maxlength'=>TEXT_BOX_RANGE,
                                                       'value' => $news['end_time'],
                                                        );
                                                        $attribute = array('class' => 'control-label col-md-4');
                                                        ?>
                          <?php echo form_label('End Time<span style="color:red">*</span>', 'end_time', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
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
                        <a href="<?php echo ADMIN_BASE_URL . 'timetable/subjects/'.$this->uri->segment('4'); ?>">
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
