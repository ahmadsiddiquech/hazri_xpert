<!-- Page content-->
<div class="content-wrapper">
    <h3>
        <?php 
    $urlPath = $this->uri->segment(5);
    echo ucwords(str_replace('%20',' ',$urlPath));
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'voucher'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a></h3>
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
                        <th>Student Name</th>
                        <th>Parent Name</th>
                        <th>Total Fee</th>
                        <th>Paid Fee</th>
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
                                        $std_voucher_edit_url = ADMIN_BASE_URL . 'voucher/std_voucher_edit/' . $new->voucher_id.'/'.$urlPath.'/'.$new->id;
                                        $print_url = ADMIN_BASE_URL . 'voucher/create/' . $new->id;
                                        $set_publish_url = ADMIN_BASE_URL . 'voucher/set_publish/' . $new->id;
                                        $set_unpublish_url = ADMIN_BASE_URL . 'voucher/set_unpublish/' . $new->id ;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new->std_name ?></td>
                                        <td><?php echo $new->parent_name  ?></td>
                                        <td><?php echo $new->total ?></td>
                                        <td><?php echo $new->paid ?></td>

                                        <td class="table_action">
                                        <a class="btn yellow c-btn view_details" rel="<?=$new->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
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

                                        echo anchor($print_url, '<i class="fa fa-print"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Print Voucher'));

                                        echo anchor($std_voucher_edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit voucher'));
                                        
                                        echo anchor("javascript:;",$icon, array('class' => 'action_publish' . $publish_class . $iconbgclass,
                                        'title' => $publis_title,'rel' => $new->id,'id' => $new->id, 'status' => $new->status));

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

    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?php ADMIN_BASE_URL?>voucher/detail",
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
             $.ajax({
                type: 'POST',
                url: "<?= ADMIN_BASE_URL ?>voucher/change_status",
                data: {'id': id, 'status': status},
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
                    $("#listing").load('<?php ADMIN_BASE_URL?>voucher/manage');
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
    /*///////////////////////////////// END STATUS  ///////////////////////////////////*/

});

$(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });
</script>

