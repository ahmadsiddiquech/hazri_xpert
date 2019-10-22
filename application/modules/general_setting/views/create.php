<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div id="contractors_measurements_modal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        Widget settings form goes here
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn green" id="confirm"><i class="fa fa-check"></i>&nbsp;Save changes</button>
                        <button type="button" class="btn default" data-dismiss="modal"><i class="fa fa-undo"></i>&nbsp;Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->

        <div class="content-wrapper">
                <h3>
                    General Setting
                </h3>

                <!-- END PAGE TITLE & BREADCRUMB-->
        </div>
        </div>
      </div> 

    <div class="row">
      <div class="col-md-12">
        <div class="tabbable tabbable-custom boxless">
          <div class="tab-content">
          <div class="panel panel-default" style="margin-top:-30px;">
         
            <div class="tab-pane  active" id="tab_2" >
              <div class="portlet box green ">
                <div class="portlet-title ">
                <br /><br />

                                <div class="portlet-body form" id="gen_setting">
                                 <?php
                                    $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal no-mrg');
									if(!empty($general_settings))
										$update_id = $general_settings['id'];
                                    if (empty($update_id) || $update_id == 0) {
                                        $update_id = 0;
                                        $hidden = array('hdnId' => $update_id); ////edit case
                                    } else {
                                        $hidden = array('hdnId' => $update_id); ////edit case
                                    }
                                    echo form_open_multipart(ADMIN_BASE_URL . 'general_setting/submit/'.$update_id, $attributes, $hidden);
                                    ?>
                                    <!-- BEGIN FORM-->
                                    <div class="form-body">

                                        <div class="container">
                                            <div class="row">
                                                <div class="form-group">
                                                    <?php
													$title = '';
													if(isset($general_settings['building_name'])){$title = $general_settings['building_name'];}
                                                    $data = array(
                                                        'name' => 'building_name',
                                                        'id' => 'building_name',
                                                        'disabled' => 'true',
                                                        'class' => 'form-control validate[required] text-input',
                                                        'value' => $title,
                                                        
                                                    );
                                                    $attribute = array('class' => 'control-label col-md-3');
                                                    ?>
                                                    <?php echo form_label('Bulding Name', 'building_name', $attribute); ?>
                                                    <div class="col-md-4">
                                                        <?php echo form_input($data); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">                                           
                                            <div class="form-group">
                                                <?php
												$address = '';
												if(isset($general_settings['address'])){$address = $general_settings['address'];}
                                                $data = array(
                                                    'name' => 'address',
                                                    'id' => 'address',
                                                    'disabled' => 'true',
                                                    'class' => 'form-control text-input',
                                                    'value' => $address,
                                                );
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('Address', 'address', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                    <?php echo form_input($data); ?>
                                            
                                                </div>
                                            
                                            </div>
                                            </div>

                                            <div class="row">                                           
                                            <div class="form-group">
                                                <?php
                                                $state = '';
                                                if(isset($general_settings['state'])){$state = $general_settings['state'];}
                                                $data = array(
                                                    'name' => 'state',
                                                    'id' => 'state',
                                                    'disabled' => 'true',
                                                    'class' => 'form-control  text-input',
                                                    'value' => $state,
                                                );
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('State', 'state', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                    <?php echo form_input($data); ?>
                                            
                                                </div>
                                            
                                            </div>
                                            </div>
                                            
											<div class="row">                                           
                                            <div class="form-group">
                                                <?php
												$city = '';
												if(isset($general_settings['city'])){$city = $general_settings['city'];}
                                                $data = array(
                                                    'name' => 'city',
                                                    'id' => 'city',
                                                    'disabled' => 'true',
                                                    'class' => 'form-control  text-input',
                                                    'value' => $city,
                                                );
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('City', 'city', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                    <?php echo form_input($data); ?>
                                            
                                                </div>
                                            
                                            </div>
                                            </div>

                                            <div class="row">                                           
                                            <div class="form-group">
                                                <?php
                                                $zip = '';
                                                if(isset($general_settings['zip'])){$zip = $general_settings['zip'];}
                                                $data = array(
                                                    'name' => 'zip',
                                                    'id' => 'zip',
                                                    'disabled' => 'true',
                                                    'class' => 'form-control  text-input',
                                                    'value' => $zip,
                                                );
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('Zip Code', 'zip', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                    <?php echo form_input($data); ?>
                                            
                                                </div>
                                            
                                            </div>
                                            </div>
											<div class="row">                                           
                                            <div class="form-group">
                                                <?php
												$country = '';
												if(isset($general_settings['country'])){$country = $general_settings['country'];}
                                                $data = array(
                                                    'name' => 'country',
                                                    'id' => 'country',
                                                    'disabled' => 'true',
                                                    'class' => 'form-control  text-input',
                                                    'value' => $country,
                                                );
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('Country', 'country', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                    <?php echo form_input($data); ?>
                                            
                                                </div>
                                            
                                            </div>
                                            </div>
											
                                            <div class="row">                                           
                                            <div class="form-group">
                                                <?php
												$phone = '';
												if(isset($general_settings['phone'])){$phone = $general_settings['phone'];}
                                                $data = array(
                                                    'name' => 'phone',
                                                    'id' => 'phone',
                                                    'disabled' => 'true',
                                                    'class' => 'form-control  text-input',
                                                    'value' => $phone,
                                                );
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('Phone', 'phone', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                    <?php echo form_input($data); ?>
                                            
                                                </div>
                                            
                                            </div>
                                            </div>

											<div class="row">                                           
                                            <div class="form-group">
                                                <?php
												$email = '';
												if(isset($general_settings['email'])){$email = $general_settings['email'];}
                                                $data = array(
                                                    'name' => 'email',
                                                    'id' => 'email',
                                                    'disabled' => 'true',
                                                    'class' => 'form-control  text-input',
                                                    'value' => $email,
                                                );
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('Email', 'email', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                    <?php echo form_input($data); ?>
                                            
                                                </div>
                                            
                                            </div>
                                            </div>
											
											<div class="row">                                           
                                            <div class="form-group">
                                                <?php
												$url = '';
												if(isset($general_settings['url'])){$url = $general_settings['url'];}
                                                $data = array(
                                                    'name' => 'url',
                                                    'id' => 'url',
                                                    'disabled' => 'true',
                                                    'class' => 'form-control  text-input',
                                                    'value' => $url,
                                                );
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('URL', 'url', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                    <?php echo form_input($data); ?>
                                            
                                                </div>
                                            
                                            </div>
                                            </div>
                                            
                                            <div class="row">                                           
                                            <div class="form-group">
                                                <?php
                                                $this->load->helper('date');
                                                $attribute = array('class' => 'control-label col-md-3');
                                                echo form_label('Time Zone', 'timezones', $attribute);
                                                ?>
                                                <div class="col-md-4">
                                                <?php 
                                                if (isset($general_settings['timezones']) && !empty($general_settings['timezones']))
                                                        $timezone = $general_settings['timezones'];
                                                else
                                                        $timezone = '';
                                                echo timezone_menu($timezone);
                                                ?>
                                                </div>
                                            
                                            </div>
                                            </div>


                                            <div class="row" > 
                                                <div class="form-group">
                                            <?php
                                            $attribute = array('class' => 'control-label col-md-3');
                                            echo form_label('Date Format', 'date_format', $attribute);
                                            
                                            $this->config->load('general_constants');
                                            $arr_date_format = $this->config->item('Date_Format_Type'); ?>
                                            <div class="col-md-9"><? foreach ($arr_date_format as $key => $format):?>
                                                <div class="margin-bottom-10">
                                                <br>
                                                    <span>
                                                    <?php
													$date_format = '';
													if(isset($general_settings['date_format'])){$date_format = $general_settings['date_format'];}
                                                    $data = array(
                                                        'name' => 'date_format',
                                                        'id' => $format,
                                                        'class' => 'toggle',
                                                         'value' => $key,
                                                    );
                                                    if($date_format == $key)
                                                        $data['checked'] = 'checked';
                                                    $label = $format;
                                                    
                                                    $attribute = array('class' => 'control-label col-md-2');
                                                    echo form_label($label, $label, $attribute);
                                                    ?>
                                                    </span>
                                                    <span> 
                                                    <div class="make-switch radio1 radio-no-uncheck h-30">
                                                        <?php echo form_radio($data); ?>
                                                    </div>
                                                    </span> 
                                                        
                                                 </div>   
                                            
                                            <?php endforeach; ?>
                                                </div>
                                            </div>
                                            </div>



                                            <div class="row" > 
                                            <div class="form-group">
                                            <?php
                                            $attribute = array('class' => 'control-label col-md-3');
                                            echo form_label('Time Format', 'time_format', $attribute);
                                            $this->config->load('general_constants');
                                            $time_format = $this->config->item('time_Format_Type');
                                            ?><div class="col-md-9"><?
                                            foreach ($time_format as $key => $time):
                                            ?>
                                            <div class="margin-bottom-10">
                                                
                                                <br>
                                                    
                                                    <span>
                                                    <?php
													$time_format = '';
													if(isset($general_settings['time_format'])){$time_format = $general_settings['time_format'];}
                                                    $data = array(
                                                        'name' => 'time_format',
                                                        'id' => $time,
                                                        'class' => 'toggle',
                                                         'value' => $key,
                                                    );
                                                    if($time_format == $key)
                                                        $data['checked'] = 'checked';
                                                    $label = $time;
                                                    
                                                    $attribute = array('class' => 'control-label col-md-2');
                                                    echo form_label($label, $label, $attribute);
                                            
                                                    ?>
                                                    </span>
                                                    <span>
                                                    <div class="make-switch radio1 radio-no-uncheck h-30">
                                                        <?php echo form_radio($data); ?>
                                                    </div>
                                                    </span>
                                                 </div>   
                                            
                                            <?php endforeach; ?>
                                                </div>
                                            </div>
                                            
                                            </div>

                                    </div> <!-- end container-->
                                    <div class="form-actions fluid">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-offset-3 col-md-9"  style="margin-bottom:15px;" >
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
<script>
jQuery(document).ready(function() { 
 
//		$.fn.editable.defaults.mode = 'inline';		
	
	 $("#media_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
		
		$('.theme-panel ul li').click(function(){
			var theme = $(this).attr('data-style');
			$('#hdn_theme').val(theme);
            $('ul > li').removeClass("current");
			$("html, body").animate({ scrollTop: "0px" });
		});
		
	$('.theme-panel ul li').removeClass('current');
	$('.theme-panel ul li').each(function(){
		var theme = $(this).attr('data-style');
		var current_theme = $('#hdn_theme').val();
		if(theme == current_theme){
			$(this).addClass('current');
		}
	});
	
});
</script>
