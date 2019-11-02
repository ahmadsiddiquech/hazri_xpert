<!-- Page content-->
<div class="content-wrapper">
    <h3>Fee History
    <a href="<?php echo ADMIN_BASE_URL . 'fee_history'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
</h3>
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
                        <th>Roll No</th>
                        <th>Issue Date</th>
                        <th>Total Fee</th>
                        <th>Paid Fee</th>
                        <th>Remaining Fee</th>
                        <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($fee_history)) {
                                    foreach ($fee_history->result() as
                                            $new) {
                                        $i++;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new->std_name  ?></td>
                                        <td><?php echo $new->std_roll_no ?></td>
                                        <td><?php echo $new->issue_date  ?></td>
                                        <td><?php echo $new->total ?></td>
                                        <td><?php echo $new->paid  ?></td>
                                        <td><?php echo $new->remaining  ?></td>
                                        <td class="table_action">
                                            <a class="btn yellow c-btn view_details" rel="<?=$new->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
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

$(document).on("click", ".view_details", function(event){
event.preventDefault();
var id = $(this).attr('rel');
  $.ajax({
            type: 'POST',
            url: "<?php echo ADMIN_BASE_URL?>fee_history/detail",
            data: {'id': id},
            async: false,
            success: function(test_body) {
            var test_desc = test_body;
            $('#myModal').modal('show')
            $("#myModal .modal-body").html(test_desc);
            }
        });
});
</script>