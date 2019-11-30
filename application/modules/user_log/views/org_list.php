<!-- Page content-->

<div class="content-wrapper">

    <h3>Organization List</h3>

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

                        <th>Organization Name</th>

                        <th>Owner Name</th>

                        <th>Organization Address</th>

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

                                        $log_url = ADMIN_BASE_URL . 'user_log/manage/' . $new->id ;

                                        ?>

                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >

                                        <td width='2%'><?php echo $i;?></td>

                                        <td><?php echo wordwrap($new->org_name , 50 , "<br>\n")  ?></td>

                                        <td><?php echo wordwrap($new->owner_name)  ?></td>

                                        <td><?php echo wordwrap($new->org_address)  ?></td>

                                        <td class="table_action">


                                        <?php

                                        echo anchor($log_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'See Logs'));


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


$(document).ready(function() {

        $("#news_file").change(function() {

            var img = $(this).val();

            var replaced_val = img.replace("C:\\fakepath\\", '');

            $('#hdn_image').val(replaced_val);

        });

    });

</script>



