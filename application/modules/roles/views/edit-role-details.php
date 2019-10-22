					<?php
					$attributes = array('id' => 'roles_form', 'class' => 'form-horizontal no-mrg');
					echo form_open_multipart('', $attributes);
					$data = array(
						'name' => 'hdn_role_id',
						'class' => 'hdn_role_id',
						'id' => 'hdn_role_id',
						'value'=>$role_id,
						'type' => 'hidden',
					);
					if(!empty($update_id)){
						$data['value'] = $update_id;	
					}
					echo form_input($data);
					?>
                        <div class="row">
	                        <div class="col-sm-6">
                        		<div class="form-group">
                                    <?php
                                    $data = array(
                                        'name' => 'title',
                                        'id' => 'title',
                                        'class' => 'form-control',
                                        'type' => 'text',
										'value'=> $role->role,
                                        'required' => '1',
										'tabindex'=>2
                                    );
                                    $attribute = array('class' => 'control-label col-md-4');
                                    ?>
                                    <?php echo form_label('Title <span class="required">*</span>', 'title', $attribute); ?>
                                    <div class="col-md-8">
                                        <?php echo form_input($data); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions fluid">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn green" tabindex="16"><i class="fa fa-check"></i>&nbsp;Submit</button>
                                            <a href="<?php echo ADMIN_BASE_URL . 'roles'; ?>">
                                                <button type="button" class="btn default" tabindex="17"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
						<?php echo form_close(); ?>
