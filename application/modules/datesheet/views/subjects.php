<!-- Page content-->
<div class="content-wrapper">
    <h3>
    <?php 
    $urlPath = $this->uri->segment(5);
    echo ucwords(str_replace('%20',' ',$urlPath));
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'datesheet'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a></h3>
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
                        <th>Subject Name</th>
                        <th>Exam Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th class="" style="width:300px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Actions</th>
                        <!-- <th>Save subjects</th> -->
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($subject_list)) {
                                    foreach ($subject_list as $key=>
                                            $new) {
                                        $i++;
                                        $edit_url = ADMIN_BASE_URL . 'datesheet/subject_edit/' . $new['datesheet_id'].'/'.$new['id'];
                                        ?>
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new['subject_name']?></td>
                                        <td><?php echo $new['exam_date'] ?></td>
                                        <td><?php echo $new['start_time'] ?></td>
                                        <td><?php echo $new['end_time'] ?></td>
                                        <td class="table_action">
                                        <?php
                                        echo anchor($edit_url, '<i class="fa fa-pencil-square-o"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Datesheet Subject'));
                                        ?>
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