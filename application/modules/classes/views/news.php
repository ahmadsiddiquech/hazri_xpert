<div class="content-wrapper">
    <h3>Classes<a href="classes/create"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button></a></h3>

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
                        <th>Class Name</th>
                        <th>Program Name</th>
                        <th class="" style="width:400px;">Description</th>
                        <th class="" style="width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news->result() as
                                            $new) {
                                        $i++;

                                    $std_url = ADMIN_BASE_URL . 'classes/std_list/' . $new->id.'/'.$new->name;
                                        $set_publish_url = ADMIN_BASE_URL . 'classes/set_publish/' . $new->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'classes/set_unpublish/' . $new->id ;
                                        $edit_url = ADMIN_BASE_URL . 'classes/create/' . $new->id ;
                                        $delete_url = ADMIN_BASE_URL . 'classes/delete/' . $new->id;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo wordwrap($new->name , 50 , "<br>\n")  ?></td>
                                        <td><?php echo $new->program_name ?></td>
                                        <td><?php echo $new->description ?></td>
                                        <td class="table_action">

                                        <a class="btn yellow c-btn view_details" rel="<?=$new->id?>"><i class="fa fa-list"  title="See Detail"></i></a>

                                        <?php

                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set Un-Publish';
                                        $icon = '<i class="fa fa-long-arrow-up"></i>';
                                        $iconbgclass = ' btn green c-btn';
                                        if ($new->status  != 1 ) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set Publish';
                                        $icon = '<i class="fa fa-long-arrow-down"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                        }

                                        echo anchor($std_url, '<i class="fa fa-mail-forward"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'View Students'));

                                        echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass,

                                        'title' => $publis_title,'rel' => $new->id,'id' => $new->id, 'status' => $new->status));

                                        echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit classes'));

                                        echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new->id, 'title' => 'Delete classes'));
                                        ?>
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
$(document).on("click", ".view_details", function(event){
event.preventDefault();
var id = $(this).attr('rel');
  $.ajax({
            type: 'POST',
            url: "<?php ADMIN_BASE_URL?>classes/detail",
            data: {'id': id},
            async: false,
            success: function(test_body) {
            var test_desc = test_body;
            $('#myModal').modal('show')
            $("#myModal .modal-body").html(test_desc);
            }
        });
});

$(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
    var id = $(this).attr('rel');
    e.preventDefault();
  swal({
    title : "Are you sure to delete the selected classes?",
    text : "You will not be able to recover this classes!",
    type : "warning",
    showCancelButton : true,
    confirmButtonColor : "#DD6B55",
    confirmButtonText : "Yes, delete it!",
    closeOnConfirm : false
  },
    function () {
           $.ajax({
                type: 'POST',
                url: "<?php echo ADMIN_BASE_URL?>classes/delete",
                data: {'id': id},
                async: false,
                success: function() {
                location.reload();
                }
            });
    swal("Deleted!", "classes has been deleted.", "success");
  });
});

$(document).off("click",".action_publish").on("click",".action_publish", function(event) {
    event.preventDefault();
    var id = $(this).attr('rel');
    var status = $(this).attr('status');
     $.ajax({
        type: 'POST',
        url: "<?= ADMIN_BASE_URL ?>classes/change_status",
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
            $("#listing").load('<?php ADMIN_BASE_URL?>classes/manage');
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