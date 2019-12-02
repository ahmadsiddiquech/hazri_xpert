<!-- Page content-->
<div class="content-wrapper">
    <h3>Voucher Record<a href="<?php echo ADMIN_BASE_URL . 'installment'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
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
                                        $std_voucher_url = ADMIN_BASE_URL . 'installment/std_voucher/' . $new->id.'/'.$new->class_name;
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