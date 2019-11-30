<!-- Page content-->
<div class="content-wrapper">
    <h3>Leave History</h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <button onclick="window.print()" class="btn btn-primary">Print</button>
                    <table id="datatable1" class="table table-striped table-hover table-body">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="sr">S.No</th>
                        <th>Student Name</th>
                        <th>Parent Name</th>
                        <th>Student Roll No</th>
                        <th>Section</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th id="actions">Actions</th>
                        <!-- <th >Actions</th> -->
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news)) {
                                    foreach ($news as $key => $value) {
                                        $i++;
                                        ?>
                                        <tr >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $value['std_name']  ?></td>
                                        <td><?php echo $value['parent_name'] ?></td>
                                        <td><?php echo $value['std_roll_no'] ?></td>
                                        <td><?php echo $value['section_name'] ?></td>
                                        <td><?php echo $value['date'] ?></td>
                                        <td>
                                            <div class="col-sm-5">
                                        <div class="form-group">
                                          <div class="col-md-8"> 
                                            <select name="status" id="status" required="required" class="form-control">
                                              <option value="0" <?php if($value['status'] == 0) echo 'selected'; ?> >Pending</option>
                                              <option value="1" <?php if($value['status'] == 1) echo 'selected'; ?> >Accepted</option>
                                              <option value="2" <?php if($value['status']== 2) echo'selected'; ?>>Rejected</option>
                                            </select>
                      </div>
                        </div>
                      </div>
                                        </td>

                                        <td class="table_action">
                                        <a class="btn yellow c-btn view_details" rel="<?=$value['id']?>"><i class="fa fa-list"  title="See Detail"></i></a>
                                        <div class="btn btn-primary edit_leave round" roll_no="<?php echo $value['std_roll_no']; ?>" std_id="<?php echo $value['std_id']; ?>"
                                                    std_name="<?php echo $value['std_name']; ?>"
                                                 leave_id="<?php echo $value['id']; ?>" status="<?php echo $value['status']; ?>">update</div> 
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
//alert(id); return false;
$.ajax({
    type: 'POST',
    url: "<?php ADMIN_BASE_URL?>leave/detail",
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

$(document).on("click", ".edit_leave", function(event){
event.preventDefault();
var std_id = $(this).attr('std_id');
var std_name = $(this).attr('std_name');
var leave_id = $(this).attr('leave_id');
var roll_no = $(this).attr('roll_no');
var status = $(this).parent().parent().find('#status').val()
// alert(status);

$.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>leave/change_status",
        data: {'std_id': std_id,'std_name': std_name,'leave_id' : leave_id,'roll_no' : roll_no,'status' :status},
        async: false,
        success: function(result) {
            if (result == "true") {
                  toastr.success('successful');
            }
            else{
                toastr.warning('Unsuccessfull');
            }
        }
    });
});


$(document).ready(function() {
        $("#news_file").change(function() {
            var img = $(this).val();
            var replaced_val = img.replace("C:\\fakepath\\", '');
            $('#hdn_image').val(replaced_val);
        });
    });


</script>