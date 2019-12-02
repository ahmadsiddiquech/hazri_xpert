<!-- Page content-->
<div class="content-wrapper">
    <h3>Voucher<a href="voucher/create"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<b>Add Voucher</b></button></a></h3>
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
                        <th>Program Name</th>
                        <th>Class Name</th>
                        <th>Section Name</th>
                        <th>Issue Date</th>
                        <th>Last Date</th>
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
                                        $std_voucher_url = ADMIN_BASE_URL . 'voucher/std_voucher/' . $new->id.'/'.$new->class_name;
                                        $edit_url = ADMIN_BASE_URL . 'voucher/create/' . $new->id ;
                                        $delete_url = ADMIN_BASE_URL . 'voucher/delete/' . $new->id;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new->program_name  ?></td>
                                        <td><?php echo $new->class_name  ?></td>
                                        <td><?php echo $new->section_name ?></td>
                                        <td><?php echo $new->issue_date ?></td>
                                        <td><?php echo $new->due_date ?></td>

                                        <td class="table_action">
                                        <?php
                                        echo anchor($std_voucher_url, '<i class="fa fa-mail-forward"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'View Vouchers'));

                                        echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit voucher'));

                                        echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $new->id, 'title' => 'Delete voucher'));
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

  $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
        var id = $(this).attr('rel');
        e.preventDefault();
      swal({
        title : "Are you sure to delete the selected voucher?",
        text : "You will not be able to recover this voucher!",
        type : "warning",
        showCancelButton : true,
        confirmButtonColor : "#DD6B55",
        confirmButtonText : "Yes, delete it!",
        closeOnConfirm : false
      },
        function () {
            
               $.ajax({
                    type: 'POST',
                    url: "<?php echo ADMIN_BASE_URL?>voucher/delete",
                    data: {'id': id},
                    async: false,
                    success: function() {
                    location.reload();
                    }
                });
        swal("Deleted!", "voucher has been deleted.", "success");
      });

    });
</script>