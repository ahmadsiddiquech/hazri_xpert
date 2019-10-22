<div class="content-wrapper">

    <h3>
    <?php
    if (empty($update_id)) 
    $strTitle = 'Add Mosque';
    else 
    $strTitle = 'Edit Mosque';
    echo $strTitle;
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'outlet'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
    </h3>

    <div class="panel panel-default">
        <div class="panel-body"> 
        <?php
        $attributes = array('autocomplete' => 'off', 'id' => 'form_sample_1', 'class' => 'form-horizontal');
        if (empty($update_id)) {
			$update_id = 0;
        } else {
			$hidden = array('hdnId' => $update_id); ////edit case
        }
        if (isset($hidden) && !empty($hidden))
			echo form_open_multipart(ADMIN_BASE_URL . 'outlet/submit/' . $update_id , $attributes, $hidden);
        else
			echo form_open_multipart(ADMIN_BASE_URL . 'outlet/submit/' . $update_id , $attributes);
        ?>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtBuildingName',
                'id' => 'txtBuildingName',
                'class' => 'form-control',
                'type' => 'text',
                'required' => 'required',
                'value' => $outlet['building_name']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Mosque Name <span class="required" style="color:red">*</span>', 'txtBuildingName', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtPhone',
                'id' => 'txtPhone',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['phone']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Phone   ', 'txtPhone', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtAddress',
                'id' => 'txtAddress',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['address']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Address   ', 'txtAddress', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtEmail',
                'id' => 'txtEmail',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['email']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Email   ', 'txtEmail', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtCity',
                'id' => 'txtCity',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['city']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('City    ', 'txtCity', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtUrl',
                'id' => 'txtUrl',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['url']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Url   ', 'txtUrl', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtState',
                'id' => 'txtState',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['state']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('State   ', 'txtState', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtLatitude',
                'id' => 'txtLatitude',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['latitude']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Latitude   ', 'txtLatitude', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtZip',
                'id' => 'txtZip',
                'class' => 'form-control',
                'type' => 'number',
                'pattern' => '[0-9]*',
                'maxlength' => '5',
                'value' => $outlet['zip']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Zip', 'txtZip', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtLongitude',
                'id' => 'txtLongitude',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['longitude']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Longitude   ', 'txtLongitude', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
        </div>
 
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $data = array(
                'name' => 'txtCountry',
                'id' => 'txtCountry',
                'class' => 'form-control',
                'type' => 'text',
                'value' => $outlet['country']
                );
                $attribute = array('class' => 'control-label col-md-4');
                ?>
                <?php echo form_label('Country   ', 'txtCountry', $attribute); ?>
                <div class="col-md-8">
                <?php echo form_input($data); ?>
                </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $options = array('' => 'Select')+$package_title;
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Package Title', '  package_id', $attribute);?>
                <div class="col-md-8"><?php echo form_dropdown('package_id', $options, $package_data['package_id'], 'class="form-control select2me" id="package_id"');?></div></div></div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group last">
                <label class="control-label col-md-4">Image Upload </label>
                <div class="col-md-8">
                <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                <?
                $filename =  './uploads/outlet/small_images/' . $outlet['image'];
                if (isset($outlet['image']) && !empty($outlet['image']) && file_exists($filename)) {
                ?>
                <img src = "<?php echo base_url() . 'uploads/outlet/medium_images/' . $outlet['image'] ?>" />
                <?php
                } else {
                ?>
                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                <?php
                }
                ?>
                </div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;">
                </div>
                <div>
                <span class="btn default btn-file">
                <span class="fileupload-new">
                <i class="fa fa-paper-clip"></i> Select image
                </span>
                <span class="fileupload-exists">
                <i class="fa fa-undo"></i> Change
                </span>
                <input type="file" name="outlet_file" id="outlet_file" class="default" />
                <input type="hidden" id="hdn_image" value="<?= $outlet['image'] ?>" name="hdn_image"/>
                </span>
                <a href="#" class="btn red fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                </div>
                </div>
                </div>
                </div>                                                    
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                <?php
                $options = array('' => 'Select')+$is_reg;
                $attribute = array('class' => 'control-label col-md-4');
                echo form_label('Package Type', 'is_registred', $attribute);?>
                <div class="col-md-8"><?php echo form_dropdown('is_registred', $options, $package_data['is_registred'], 'class="form-control select2me" id="is_registred"'); ?></div></div>
            </div>
        </div>

		<div class="row">
            <div class="col-md-6">
            <div class="col-md-offset-4 col-md-10">
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
            <a href="<?php echo ADMIN_BASE_URL . 'outlet'; ?>">
            <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
            </a>
            </div>
            </div>
        </div>

        <?php echo form_close(); ?> 
		</div>
    </div>
</div>

<script>
$(document).ready(function() {
	$("#outlet_file").change(function() {
		var img = $(this).val();
		var replaced_val = img.replace("C:\\fakepath\\", '');
		$('#hdn_image').val(replaced_val);
	});
});
</script>