<div class="content-wrapper">
<h3>Organizations <a href="organizations/create"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<b>Add New</b></button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <table id="datatable1" class="table table-striped table-hover">
                        <thead class="bg-th">
                            <tr class="bg-col">
                                <th width='2%'>S.No</th>
                                <th>Organization Name</th>
                                <th>Owner Name</th>
                                <th style="width:350px;">Actions</th>
                          </tr>
                    </thead>
                            <tbody class="table-body">
                             <?php
                    $i = 0;
                    if (isset($users_rec)) {
                        foreach ($users_rec as $row) {
                            $i++;
                            $edit_url = ADMIN_BASE_URL . 'organizations/create/' . $row['id'];
                            $view_url = ADMIN_BASE_URL . 'organizations/view/' . $row['id'];
                            $delete_url = ADMIN_BASE_URL . 'organizations/delete/'. $row['id'];
                           
                        ?>
                    <tr id="Row_<?=$row['id']?>" class="odd gradeX">
                        <td width='2%'><?php echo $i;?></td>
                        <td><?php echo $row['org_name']?></td>
                        <td><?php echo $row['owner_name']?></td>                
                       <td class="table_action">
                            <!-- <a class="fancybox btn yellow c-btn" data-target="#myModal" data-toggle="modal" href="#description_<?= $row['id'] ?>" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a> -->
                            <?php
                            echo anchor($view_url, '<i class="fa fa-arrow-right"></i>', array('class' => 'btn blue c-btn','title' => 'View organizations'));
                            ?>
                            <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
                            <a class="btn red c-btn change_password" rel="<?=$row['id']?>"><i class="fa fa-eye"  title="Change Password"></i></a>
                            <?php
                             $publish_class = ' table_action_publish';
                                $publis_title = 'Set Un-Publish';
                                $icon = '<i class="fa fa-long-arrow-up"></i>';
                                $iconbgclass = ' btn green c-btn';
                                 if ($row['status'] != 1) {
                                     $publish_class = ' table_action_unpublish';
                                 $publis_title = 'Set Publish';
                                     $icon = '<i class="fa fa-long-arrow-down"></i>';
                                     $iconbgclass = ' btn default c-btn';
                                }
                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit organizations'));
                             echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass, 
                             'title' => $publis_title,'rel' => $row['id'],'id' => $row['id'], 'status' => $row['status']));
                             echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row['id'], 'title' => 'Delete User'));

                            ?>
                        </td>
                    </tr>
                      <?php 
                        }
                    ?>
                      <?php } ?>
                            </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    
<script type="application/javascript">
$(document).ready(function(){
  $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected User?",
                text : "You will not be able to recover this User!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?php ADMIN_BASE_URL?>organizations/delete",
                            data: {'id': id},
                            async: false,
                            success: function() {

                               /*$( "#datatable1" ).load( "<? ADMIN_BASE_URL ?>catagories/load_listing" );*/
                               location.reload();
                            }
                        });
                swal("Deleted!", "User has been deleted.", "success");
              });

            });

    
    $(document).on("click", ".view_details", function(event){
        event.preventDefault();
        var id = $(this).attr('rel');
        //alert(id); return false;
          $.ajax({
                    type: 'POST',
                    url: "<?= ADMIN_BASE_URL ?>organizations/detail",
                    data: {'id': id},
                    async: false,
                    success: function(test_body) {
                    var test_desc = test_body;
                    //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                    $('#myModalLarge').modal('show')
                    //$("#myModal .modal-title").html(test_title);
                    $("#myModalLarge .modal-body").html(test_desc);
                    }
                });
    
    });
    $(document).on("click", ".change_password", function(event){
        event.preventDefault();
        var id = $(this).attr('rel');
        //alert(id); return false;
          $.ajax({
                    type: 'POST',
                    url: "<?= ADMIN_BASE_URL ?>organizations/change_password",
                    data: {'id': id},
                    async: false,
                    success: function(test_body) {
                    var test_desc = test_body;
                    //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                    $('#password_Modal').modal('show')
                    //$("#myModal .modal-title").html(test_title);
                    $("#password_Modal .modal-body").html(test_desc);
                    }
                });
    
    });
    
    
    
    
            /*/////////////////////////////////////////////////////*/
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>organizations/change_status_event",
                data: {'id': id, 'status': status},
                async: false,
                success: function(result) {
                    if($('#'+id).hasClass('default')==true)
                    {
                        $('#'+id).addClass('green');
                        $('#'+id).removeClass('default');
                        $('#'+id).find('i.fa-long-arrow-down').removeClass('fa-long-arrow-down').addClass('fa-long-arrow-up');
                    }else{
                        $('#'+id).addClass('default');
                        $('#'+id).removeClass('green');
                        $('#'+id).find('i.fa-long-arrow-up').removeClass('fa-long-arrow-up').addClass('fa-long-arrow-down');
                    }
                    $("#listing").load('<?php ADMIN_BASE_URL?>thought_of_day/manage_record');
                    toastr.success('Status Changed Successfully');
                }
            });
            if (status == 1) {
                $(this).removeClass('table_action_publish');
                $(this).addClass('table_action_unpublish');
                $(this).attr('title', 'Set Publish');
                $(this).attr('status', '0');
            } else {
                $(this).removeClass('table_action_unpublish');
                $(this).addClass('table_action_publish');
                $(this).attr('title', 'Set Un-Publish');
                $(this).attr('status', '1');
            }
           
        });
                
});
</script>