<table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($roles)) {
									$sr_no = 0;
                                    foreach ($roles as $row) {
										
										if($row['role'] != 'portal admin')
										{
											$sr_no++;
                                        ?>
                                        <tr class="odd gradeX" id="Row_<?=$row['id']; ?>">
                                            <td><?php echo $sr_no;?></td>        
                                            <td><?php echo $row['role']?></td>
                                            <td>
                                            <?php
												$permission_url = ADMIN_BASE_URL . 'permission/manage/'.$row['id'].'/'.DEFAULT_OUTLET;
												echo anchor('javascript:;', '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn', 'id' => 'role_edit', 'rel' => $row['id'], 'title' => 'Edit Role'));echo '&nbsp;'; 
                                                echo anchor('javascript:;', '<i class="fa fa-times"></i>', array('class' => 'action_delete btn red c-btn', 'id' => 'role_delete', 'rel' => $row['id'], 'title' => 'Delete Role'));	;echo '&nbsp;'; 
												 echo anchor($permission_url, '<img src=" '.base_url().'static/admin/theme1/images/security_hover.png" alt="security_hover.png" >', array('class' => '','title' => 'Permissions'));
												?>
                                                <span id="del_roles_<?=$row['id']?>" style="color:#F60; display:none;"><i class="fa fa-spinner fa-spin" style="font-size:20px;"></i></span>
                                                
                                            </td>
                                        </tr>
                                    <?php }
										}
                                    ?>    
                                <?php } ?>
                            </tbody>
                        </table>
        
 <script>
 $(document).ready(function() {
	$('#sample_1').dataTable(
	{
		"aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
		"iDisplayLength": 10,
		"aoColumns": [
		null,
		null,
		{"bSortable": false},
		]
	}
	);

	toastr.options = {
		"closeButton": true,
		"debug": false,
		"positionClass": "toast-top-right",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
	}
});
 </script>