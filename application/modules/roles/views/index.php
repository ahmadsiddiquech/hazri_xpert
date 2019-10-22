<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <ul class="page-breadcrumb breadcrumb">
                    <div class="">
                        <div class="btn-group">
                            <a href= "<?php echo ADMIN_BASE_URL . 'units_of_measure/create'; ?>"/>
                            <button id="" class="btn green">
                                Add New <i class="fa fa-plus"></i>
                            </button>
                            </a>
                        </div>
                    </div>
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="#">Dashboard</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        Units of Measure
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box light-grey">
                    <div class="portlet-title">
                        <div class="caption">
                        <img src="<?php echo base_url().'static/admin/theme1/images/supplier.png' ?>" class="img_padd" alt="Shipping Agent" />Units of Measure
                            
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
									<th class="table-checkbox">ID</th>
                                    <th>Code</th>
                                    <th>Quantity per unit</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                if (isset($units)) {
                                    foreach ($units->result() as
                                            $unit) {
                                        $i++;
                                        ?>
							            <tr class="odd gradeX" id="Row_<?= $unit->id; ?>">
                                            <td class="table-checkbox"><?php echo $i;?></td> 
                                            <td><?php echo $unit->code ?></td>                                   
                                            <td><?php echo $unit->qty_per_unit?></td>
                                            <td class="table_action">
                                                <?php
                                                $edit_url = ADMIN_BASE_URL . "units_of_measure/create/" . $unit->id;
                                                echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn', 'title' => 'Edit Unit'));
                                                echo anchor('javascript:;', '<i class="fa fa-times"></i>', array('class' => 'action_delete btn red c-btn', 'rel' => $unit->id, 'title' => 'Delete Unit'));
                                                ?>
                                            </td>
                                        </tr>
                                    <?php }
                                    ?>    
<?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
</div>

<div id="static" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>
                    Would you like to delete selected unit Permanently?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn default">Cancel</button>
                <button type="button" data-dismiss="modal" class="btn green" id="confirm">Delete</button>
            </div>
        </div>
    </div>
</div>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#sample_1').dataTable(
                {
                    "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
                    "iDisplayLength": 10,
                    "aoColumns": [
                        {"bSortable": false},
                        null,
                        {"bSortable": false},
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

    $(document).ready(function() {
        $('#sample_1').on("click",".action_delete", function(event) {
            event.preventDefault();
            var id = $(this).attr('rel');
            $('#static').modal('show')
            $('#static').find('.modal-footer #confirm').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: "<?= ADMIN_BASE_URL ?>units_of_measure/delete",
                    data: {'id': id},
                    async: false,
                    success: function() {
                        toastr.success('Successfully deleted');
                        $('#Row_' + id).hide();

                    }
                });
            });

        });
    });
</script>
<?php       