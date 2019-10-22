<!-- Page content-->
<?php // print_r($roles); exit; ?>
<div class="content-wrapper">
    <h3> Roles<a href="roles/create"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->



        <div class="row">
							
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                    <!-- <div width="50px">
                    	<?php // echo form_dropdown('search_station', $stations,'', 'class="form-control select2me" data-placeholder="Select Station" id="search_station"'); ?>
                    </div> -->
                    
                    <table id="datatable1" class="table table-striped table-hover ">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th width='2%'>S.No</th>
                        <th>Title</th>
                        <th class="" style="width:200px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>

                        <tbody class="courser table-body">
                        <?php
                        $i = 0;
                        if (isset($roles)) { foreach ($roles as $row) {
							$i++;
							$edit_url = ADMIN_BASE_URL . 'roles/create/' . $row['id']; 
                            if($row['role'] =='portal admin'){ $i++; continue; }
							?>
							<tr id="Row_<?=$row['id']?>" class="odd gradeX">
							<td class="sr"><?php echo $i;?></td>
							<td><?php echo $row['role']?></td>
							<td class="table_action action">
							<!-- <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a> -->
							<!--<a class="fancybox btn yellow c-btn" data-target="#myModal" data-toggle="modal" href="#description_<?= $row['id'] ?>" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>-->
							<?php
                            $permission_url = ADMIN_BASE_URL . 'permission/manage/'.$row['id'].'/'.$row['outlet_id'].'/'.$row['role'];

							echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Roles'));
							
echo anchor($permission_url, '<i class="fa fa-eye"></i>', array('class' => '','title' => 'Permissions'));
echo anchor('javascript:;', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 
                            'rel' => $row['id'], 'title' => 'Delete Role'));

                            ?>
							</td>
							</tr>
							<?php 
                        } }
                        ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    


<script>
$(document).ready(function() {
    $("#roles_listing").load( "<?= ADMIN_BASE_URL ?>roles/get_roles",{'station':<?=DEFAULT_OUTLET?>});
    $(document).off('change',"#search_station").on('change',"#search_station",function(){
        var station = $(this).val();
        $("#roles_listing").load('<?php ADMIN_BASE_URL?>roles/get_roles',{'station':station});
    });
    
    /*$("#search_outlet").change(function(){
        $("#roles_listing").load( "<? //= ADMIN_BASE_URL ?>roles/get_roles");
    });*/
});

    $(document).on("submit","form#roles_form", function(event){
        event.preventDefault();
        $("#role_spinners").show();
        $.ajax({
            type: "POST",
            url:  "<?= ADMIN_BASE_URL ?>roles/submit",
            data: $("#roles_form").serialize(),
            success: function(type){ 
                $("#role_spinners").hide();
                $("#roles_listing").load( "<?= ADMIN_BASE_URL ?>roles/get_roles",function() {
                //var outlet_text = $("#outlet option:selected").text();
                //$('#search_outlet option').filter(function() { return $(this).text() == outlet_text; }).attr('selected',true);
                    $('form#roles_form').find(":input").val('');
                    if(type == 1)
                        var message = 'Role Saved Successfully.';
                    if(type == 2)
                        var message = 'Role Updated Successfully.';
                    if(type == 3)
                    {
                        var message = 'Role already exists.';
                        toastr.error(message);
                        return;
                    }
                    if(type == 'no_permission'){
                        var message = 'You don\'t have permission.';
                        toastr.error(message);
                        return;
                    }
                    toastr.success(message);
                });
            }
        });
    });
    
   /* $(document).on("click","#role_edit", function(event){
        event.preventDefault();
        var role_id = $(this).attr('rel');
            $.ajax({
            type: "POST",
            url:  "<?=ADMIN_BASE_URL ?>roles/edit_role",
            data: {role_id: role_id},
            success: function(form_html){
                $("#role_spinners").hide();
                if(form_html == 'no_permission'){
                        var message = 'You don\'t have permission.';
                        toastr.error(message);
                        return;
                    } 
                $("#roles_form_div").html('');
                $("#roles_form_div").html(form_html);
                $("html, body").animate({ scrollTop: "0px" });
            }
        });

    });*/
    
      $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
        var id = $(this).attr('rel');
        e.preventDefault();
        swal({
            title : "Are you sure to delete the selected Role?",
            text : "You will not be able to recover this Role!",
            type : "warning",
            showCancelButton : true,
             confirmButtonColor : "#DD6B55",
            confirmButtonText : "Yes, delete it!",
            closeOnConfirm : false
        },
        function () {
            $.ajax({
            type: 'POST',
            url: "<?= ADMIN_BASE_URL ?>roles/delete_role",
            data: {'id': id},
            async: false,
            success: function(data) {
               
             if (data  > 0) {
               toastr.error('Error : Role Is Assigned To User ');
               setTimeout(function() {   
                       location.reload()
                     }, 2000);
               return false;
             }
             else
             {
                $("#datatable1").load("<?= ADMIN_BASE_URL ?>roles/roles_load_listing");
                swal("Deleted!", "Role has been deleted.", "success");
             }
            }
            });
          
      });
    });
</script>>