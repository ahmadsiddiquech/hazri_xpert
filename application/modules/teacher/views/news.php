<!-- Page content-->
<div class="content-wrapper">
    <h3>Teacher<a href="teacher/create"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<b>Add Teacher</b></button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                    <table id="datatable1" class="table table-striped table-hover table-body">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="sr">S.No</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th class="" style="width:400px;">Email</th>
                        <th class="" style="width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                // print_r($news);exit();
                                if (isset($news)) {
                                    foreach ($news as $key => $value){
                                        $i++;
                                        $set_publish_url = ADMIN_BASE_URL . 'teacher/set_publish/' . $value['id'];
                                        $set_unpublish_url = ADMIN_BASE_URL . 'teacher/set_unpublish/' . $value['id'] ;
                                        $edit_url = ADMIN_BASE_URL . 'teacher/create/' . $value['id'] ;
                                        $delete_url = ADMIN_BASE_URL . 'teacher/delete/' . $value['id'];
                                        ?>
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo wordwrap($value['name'] , 50 , "<br>\n")  ?></td>
                                        <td><?php echo $value['designation'] ?></td>
                                        <td><?php echo $value['email'] ?></td>
                                        <td class="table_action">
                                        <a class="btn yellow c-btn view_details" rel="<?=$value['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="fa fa-long-arrow-up"></i>';
                                        $iconbgclass = ' btn green c-btn';
                                        if ($value['status']  != 1 ) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="fa fa-long-arrow-down"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                        }
                                        
                                        echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass,
                                        'title' => $publis_title,'rel' => $value['id'],'id' => $value['id'], 'status' => $value['status']));

                                        echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit teacher'));

                                        echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $value['id'], 'title' => 'Delete teacher'));
                                        if(isset($value['login_status']) && !empty($value['login_status']) && $value['login_status'] != 0) { ?>

                                            <div class="btn btn-primary log_out round" id="logout_button_<?php echo $value['id']; ?>" user_id="<?php echo $value['id']; ?>" org_id="<?php echo $value['org_id']; ?>"
                                                 username="<?php echo $value['phone']; ?>">Logout<div> 
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    <?php } ?>    
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

<script type="text/javascript">
$(document).ready(function(){

    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?php ADMIN_BASE_URL?>teacher/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                        //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                        $('#myModal').modal('show')
                        //$("#myModal .modal-title").html(test_title);
                        $("#myModal .modal-body").html(test_desc);
                        }
                    });
            });

    /*///////////////////////// end for code detail //////////////////////////////*/

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected teacher?",
                text : "You will not be able to recover this teacher!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?php echo ADMIN_BASE_URL?>teacher/delete",
                            data: {'id': id},
                            async: false,
                            success: function() {
                            location.reload();
                            }
                        });
                swal("Deleted!", "teacher has been deleted.", "success");
              });

            });

       
    /*///////////////////////////////// START STATUS  ///////////////////////////////////*/
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>teacher/change_status",
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
                    $("#listing").load('<?php ADMIN_BASE_URL?>teacher/manage');
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
    /*///////////////////////////////// END STATUS  ///////////////////////////////////*/

});

$(document).on("click", ".log_out", function(event){
event.preventDefault();
var user_id = $(this).attr('user_id');
var org_id = $(this).attr('org_id');
var username = $(this).attr('username');

$.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>teacher/logout_user",
        data: {'user_id': user_id,'org_id': org_id,'username' : username
        },
        async: false,
        success: function(result) {
            if (result == "1") {
                $('#logout_button_'+user_id).hide();
                toastr.success('successful');
            }
            else{
                toastr.warning('User Already Logged Out');
            }
        }
    });
});

</script>

