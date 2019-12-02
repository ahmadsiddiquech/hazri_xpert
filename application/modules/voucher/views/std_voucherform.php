<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add voucher';
                else 
                    $strTitle = 'Edit Student voucher';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'voucher/std_voucher/'.$voucher_id.'/'.$class;?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'voucher/submit_std_voucher/'.'$voucher_id/'.'$class'.$update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'voucher/submit_std_voucher/'.$voucher_id.'/'.$class.'/'.$update_id, $attributes);
                        ?>
                  <div class="form-body">
                     <div class="row" style="margin-top:15px;">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                              $data = array(
                              'name' => 'std_name',
                              'id' => 'std_name',
                              'class' => 'form-control',
                              'type' => 'text',
                              'required' => 'required',
                              'readonly' => 'readonly',
                              'tabindex' => '1',
                              'value' => $news['std_name'],
                              'data-parsley-maxlength'=>TEXT_BOX_RANGE
                              );
                              $attribute = array('class' => 'control-label col-md-4');
                              ?>
                          <?php echo form_label('Student Name<span style="color:red">*</span>', 'std_name', $attribute); ?>
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
                            'readonly' => 'readonly',
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
                          <?php echo form_label('Transport Fee', 'transport_fee', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
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
                      <div class="row">
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
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'previous_fee',
                            'id' => 'previous_fee',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '18',
                            'readonly' => 'readonly',
                            'value' => $news['previous_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Previous Fee', 'previous_fee', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'total',
                            'id' => 'total',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '18',
                            'readonly' => 'readonly',
                            'value' => $news['total'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Total Fee', 'total', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                        <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'paid',
                            'id' => 'paid',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '18',
                            'value' => $news['paid'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Paid Fee', 'paid', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'remaining',
                            'id' => 'remaining',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '18',
                            'readonly' => 'readonly',
                            'value' => $news['remaining'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Remaining Fee', 'remaining', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      </div>
                  </div>
                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" id="button1" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'voucher/std_voucher/'.$voucher_id.'/'.$class; ?>">
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
            url: "<?php echo ADMIN_BASE_URL?>voucher/get_class",
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
            url: "<?php echo ADMIN_BASE_URL?>voucher/get_section",
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
            url: "<?php echo ADMIN_BASE_URL?>voucher/get_subject",
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