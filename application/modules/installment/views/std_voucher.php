<!-- Page content-->
<div class="content-wrapper">
    <h3>
        <?php 
    $urlPath = $this->uri->segment(5);
    echo ucwords(str_replace('%20',' ',$urlPath));
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'installment/voucher_record'; ?>"><button type="button" class="btn btn-primary btn-lg pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
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
                                        $std_voucher_edit_url = ADMIN_BASE_URL . 'installment/std_voucher_edit/' . $new->voucher_id.'/'.$urlPath.'/'.$new->id;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX">
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new->std_name ?></td>
                                        <td><?php echo $new->parent_name  ?></td>
                                        <td><?php echo $new->total ?></td>
                                        <td><?php echo $new->paid ?></td>

                                        <td class="table_action">
                                        <?php
                                        echo anchor($std_voucher_edit_url, '<i class="fa fa-random"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Create Installment'));
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