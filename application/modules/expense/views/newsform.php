<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add expense';
                else 
                    $strTitle = 'Edit expense';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'expense'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                            echo form_open_multipart(ADMIN_BASE_URL . 'expense/submit/' . $update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'expense/submit/' . $update_id, $attributes);
                        ?>
                  <div class="form-body">
                    
               <div class="row" style="margin-top:15px;">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'title',
                            'id' => 'title',
                            'class' => 'form-control',
                            'type' => 'text',
                            'required' => 'required',
                            'tabindex' => '1',
                            'value' => $news['title'],
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>  
                          <?php echo form_label('Title <span style="color:red">*</span>', 'title', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'description',
                            'id' => 'description',
                            'class' => 'form-control',
                            'type' => 'text',
                            'required' => 'required',
                            'tabindex' => '2',
                            'value' => $news['description'],
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>  
                          <?php echo form_label('Description <span style="color:red">*</span>', 'description', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>
                      <div class="row" style="margin-top:15px;">
                       <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'date',
                            'id' => 'date',
                            'class' => 'form-control datetimepicker2',
                            'required' => 'required',
                            'tabindex' => '3',
                            'value' => $news['date'],
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>  
                          <?php echo form_label('Date <span style="color:red">*</span>', 'date', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'amount',
                            'id' => 'amount',
                            'class' => 'form-control',
                            'type' => 'number',
                            'required' => 'required',
                            'tabindex' => '4',
                            'value' => $news['amount'],
                            'data-parsley-maxlength'=>TEXT_BOX_RANGE
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                            ?>  
                          <?php echo form_label('Amount <span style="color:red">*</span>', 'amount', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?></div>
                        </div>
                      </div>
                      </div>


                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'expense'; ?>">
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

    $(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });



</script>