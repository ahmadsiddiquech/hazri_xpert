<div class="page-content-wrapper">
  <div class="page-content"> 
    <div class="content-wrapper">
      <h3>
        <?php 
        if (empty($update_id)) 
                    $strTitle = 'Add installment';
                else 
                    $strTitle = 'Create Installment';
                    echo $strTitle;
                    ?>
                    <a href="<?php echo ADMIN_BASE_URL . 'installment/std_voucher/'.$voucher_id.'/'.$class;?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                        <?php
                        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
                        if (empty($update_id)) {
                            $update_id = 0;
                        }
                        if (isset($hidden) && !empty($hidden))
                            echo form_open_multipart(ADMIN_BASE_URL . 'installment/submit_std_voucher/'.'$voucher_id/'.'$class'.$update_id, $attributes, $hidden);
                        else
                            echo form_open_multipart(ADMIN_BASE_URL . 'installment/submit_std_voucher/'.$voucher_id.'/'.$class.'/'.$update_id, $attributes);
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
                          <?php echo form_label('Student Name', 'std_name', $attribute); ?>
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
                          <?php echo form_label('Parent Name', 'parent_name', $attribute); ?>
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
                            'tabindex' => '3',
                            'readonly' => 'readonly',
                            'value' => $news['tution_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Tution Fee', 'total', $attribute); ?>
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
                            'tabindex' => '4',
                            'readonly' => 'readonly',
                            'value' => $news['transport_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Transport Fee', 'total', $attribute); ?>
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
                            'tabindex' => '5',
                            'readonly' => 'readonly',
                            'value' => $news['lunch_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Lunch Fee', 'total', $attribute); ?>
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
                            'tabindex' => '6',
                            'readonly' => 'readonly',
                            'value' => $news['stationary_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Stationary Fee', 'total', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
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
                            'tabindex' => '7',
                            'readonly' => 'readonly',
                            'value' => $news['other_fee'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Other Fee', 'total', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'total',
                            'id' => 'total',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '8',
                            'readonly' => 'readonly',
                            'value' => $news['total'],
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Total Fee', 'total', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <?php
                            $data = array(
                            'name' => 'n_of_i',
                            'id' => 'n_of_i',
                            'class' => 'form-control',
                            'type' => 'number',
                            'tabindex' => '9',
                            'required' => 'required',
                            'placeholder' => 'Total No of Installments',
                            );
                            $attribute = array('class' => 'control-label col-md-4');
                          ?>
                          <?php echo form_label('Installments', 'n_of_i', $attribute); ?>
                          <div class="col-md-8"> <?php echo form_input($data); ?> </div>
                        </div>
                      </div>
                  </div>
                  <!-- <div class="row"><div class="col-sm-5">
<div class="col-md-4"><b>Due Date</b></div><div class="col-md-8"><input class="form-control" type="date" name="due_date[]"></div></div><div class="col-sm-5"><div class="col-md-4"><b>Due Date</b></div><div class="col-md-8"><input class="form-control" type="date" name="due_date[]"></div></div></div> -->
                  <div class="row" id="inputbox" style="padding-left: 90px; padding-bottom: 30px">
                  </div>
                  <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <span style="margin-left:40px"></span> <button type="submit" id="button1" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'installment/std_voucher/'.$voucher_id.'/'.$class; ?>">
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
  $(document).ready(function(){
    $("#n_of_i").keyup(function () {
        var no = this.value;
        if (no <= 0) {
          var html = ''
          $("#inputbox").html(html);
        }
        else{
          for (var i = 1; i <= no; i++) {
            var html = '<div class="row"><div class="col-md-4" style="padding-left:60px;">Due Date<input class="form-control" required type="date" name="due_date[]"></div></div>'
            $("#inputbox").append(html);
          }
        }
    });
  });
</script>