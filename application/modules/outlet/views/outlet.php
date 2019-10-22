<!-- Page content-->
<div class="content-wrapper">
<h3>Mosques <a href="outlet/create"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Add New</button></a></h3>
<div class="container-fluid">
<!-- START DATATABLE 1 -->
         <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">

                <table id="datatable1" class="table table-striped table-hover">
                    <thead class="bg-th">
                          <tr>
                                <th width='2%'>S.No</th>
                                <th width="20%">Building Name</th>
                                <th width="20%">Address</th>
                                <th width="5%">city</th>
                                <th width="5%"> Registered</th>
                                <th width="5%"> Package Type</th>
                                <th width="50px">phone</th>
                                <th class="table_action">Action</th>
                          </tr>
                    </thead>
                    <tbody>
                      <?php
                    $i = 0;
                    if (isset($outlet)) {

                        foreach ($outlet as $row) {
                            $i++;
                            $edit_url = ADMIN_BASE_URL . 'outlet/create/' . $row['id'];                           
                        ?>
                    <tr id="Row_<?=$row['id']?>" class="odd gradeX">
                        <td width="2%"><?php echo $i;?></td>
                        <td width="20%"><?php echo $row['building_name']?></td>
                        <td width="20%"><?php echo $row['address']?></td>
                        <td width="5%"><?php echo $row['city']?></td>
                        <td width="5%"><?php echo $row['is_registred']?></td>
                         <td width="5%"><?php echo $row['title']?></td>
                        <td width="50px"><?php echo $row['phone']?></td>
                        <td class="table_action">
                        <a class="btn yellow c-btn view_details" rel="<?=$row['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
                        <?php
                             echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit Mosque'));
                             echo anchor('"javascript:;"', '<i class="fa fa-times"></i>', array('class' => 'delete_record btn red c-btn', 'rel' => $row['id'], 'title' => 'Delete Mosque'));                    
                        ?>
                        </td>
                    </tr>
                        <?php 
                            }
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


<script type="text/javascript">
$(document).ready(function(){

    /*//////////////////////// code for detail //////////////////////////*/

            $(document).on("click", ".view_details", function(event){
            event.preventDefault();
            var id = $(this).attr('rel');
            //alert(id); return false;
              $.ajax({
                        type: 'POST',
                        url: "<?php ADMIN_BASE_URL?>outlet/detail",
                        data: {'id': id},
                        async: false,
                        success: function(test_body) {
                        var test_desc = test_body;
                        //var test_body = '<ul class="list-group"><li class="list-group-item"><b>Description:</b> Akabir Abbasi Test</li></ul>';
                        $('#myModal').modal('show')
                        //$("#myModal .modal-title").html(test_title);
                        $("#myModal .modal-body").html(test_desc);
                        }
                    });
            });

    /*///////////////////////// end for code detail //////////////////////////////*/

          $(document).off('click', '.delete_record').on('click', '.delete_record', function(e){
                var id = $(this).attr('rel');
                e.preventDefault();
              swal({
                title : "Are you sure to delete the selected Mosque?",
                text : "You will not be able to recover this Mosque!",
                type : "warning",
                showCancelButton : true,
                confirmButtonColor : "#DD6B55",
                confirmButtonText : "Yes, delete it!",
                closeOnConfirm : false
              },
                function () {
                    
                       $.ajax({
                            type: 'POST',
                            url: "<?php ADMIN_BASE_URL?>outlet/delete",
                            data: {'id': id},
                            async: false,
                            success: function() {
                               $( "#datatable1" ).load( "<? ADMIN_BASE_URL ?>outlet/load_listing" );
                               //location.reload();
                            }
                        });
                swal("Deleted!", "Thought of day has been deleted.", "success");
              });

            });

});

</script>


