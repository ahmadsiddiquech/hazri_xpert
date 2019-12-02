<!-- Page content-->
<div class="content-wrapper">
    <h3>Installment<a href="installment/voucher_record"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;<b>Add New</b></button></a></h3>
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
                        <th>Student Name</th>
                        <th>Fee</th>
                        <th>Due Date</th>
                        <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news->result() as
                                            $new) {
                                        $i++;
                                        $print_url = ADMIN_BASE_URL . 'installment/print_voucher/' . $new->installment_id;
                                        $set_publish_url = ADMIN_BASE_URL . 'installment/set_publish/' . $new->installment_id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'installment/set_unpublish/' . $new->installment_id ;
                                        ?>
                                    <tr id="Row_<?=$new->installment_id?>" class="odd gradeX " >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new->program_name  ?></td>
                                        <td><?php echo $new->class_name  ?></td>
                                        <td><?php echo $new->section_name ?></td>
                                        <td><?php echo $new->std_name ?></td>
                                        <td><?php echo $new->fee ?></td>
                                        <td><?php echo $new->due_date ?></td>

                                        <td class="table_action">
                                            <a class="btn yellow c-btn view_details" rel="<?=$new->installment_id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        <?php
                                        $publish_class = ' table_action_publish';
                                        $publis_title = 'Set as Un-Paid';
                                        $icon = '<i class="fa fa-check"></i>';
                                        $iconbgclass = ' btn green c-btn';
                                        if ($new->status  != 1 ) {
                                        $publish_class = ' table_action_unpublish';
                                        $publis_title = 'Set as Paid';
                                        $icon = '<i class="fa fa-credit-card"></i>';
                                        $iconbgclass = ' btn default c-btn';
                                        }

                                        echo anchor($print_url, '<i class="fa fa-print"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Print installment'));

                                        echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass,
                                        'title' => $publis_title,'rel' => $new->installment_id,'id' => $new->installment_id, 'status' => $new->status, 'fee' => $new->fee, 'std_voucher_id' => $new->std_voucher_id));
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
    
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
              $.ajax({
                        type: 'POST',
                        url: "<?php ADMIN_BASE_URL?>installment/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                        $('#myModal').modal('show')
                        $("#myModal .modal-body").html(test_desc);
                        }
                    });
            });
        
        $(document).off("click",".action_publish").on("click",".action_publish", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            var status = $(this).attr('status');
            var fee = $(this).attr('fee');
            var std_voucher_id = $(this).attr('std_voucher_id');
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>installment/change_status",
                data: {'id': id, 'status': status, 'fee' : fee ,'std_voucher_id' : std_voucher_id},
                async: false,
                success: function(result) {
                    if($('#'+id).hasClass('default')==true)
                    {
                        $('#'+id).addClass('green');
                        $('#'+id).removeClass('default');
                        $('#'+id).find('i.fa-credit-card').removeClass('fa-credit-card').addClass('fa-check');
                    }else{
                        $('#'+id).addClass('default');
                        $('#'+id).removeClass('green');
                        $('#'+id).find('i.fa-check').removeClass('fa-check').addClass('fa-credit-card');
                    }
                    $("#listing").load('<?php ADMIN_BASE_URL?>installment/manage');
                    toastr.success('Status Changed Successfully');
                }
            });
            if (status == 1) {
                $(this).removeClass('table_action_publish');
                $(this).addClass('table_action_unpublish');
                $(this).attr('title', 'Set as Paid');
                $(this).attr('status', '0');
            } else {
                $(this).removeClass('table_action_unpublish');
                $(this).addClass('table_action_publish');
                $(this).attr('title', 'Set as Un-Paid');
                $(this).attr('status', '1');
            }
           
        });
});

</script>