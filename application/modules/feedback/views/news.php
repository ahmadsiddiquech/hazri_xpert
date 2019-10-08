<div class="content-wrapper">
    <h3>Feedback</h3>
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
                        <th>Teacher Name</th>
                        <th>Parent Name</th>
                        <th>Student Name</th>
                        <th>Date Time</th>
                        <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news->result() as $new) {
                                        $i++;
                                        $conversation_url = ADMIN_BASE_URL . 'feedback/conversation/' . $new->id.'/'.$new->user_type;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new->teacher_name  ?></td>
                                        <td><?php echo $new->parent_name ?></td>
                                        <td><?php echo $new->std_name ?></td>
                                        <td><?php echo $new->date_time ?></td>

                                        <td class="table_action">
                                        <a class="btn yellow c-btn view_details" rel="<?=$new->id?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        <?php
                                        echo anchor($conversation_url, '<i class="fa fa-comments-o"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Conversation'));
                                        }
                                        ?>
                                        </td>
                                    </tr>   
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
                url: "<?php ADMIN_BASE_URL?>feedback/detail",
                data: {'id': id},
                async: false,
                success: function(test_body) {
                var test_desc = test_body;
                $('#myModal').modal('show')
                $("#myModal .modal-body").html(test_desc);
                }
            });
    });
});
</script>