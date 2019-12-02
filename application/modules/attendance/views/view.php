<!-- Page content-->
<div class="content-wrapper">
    <h3>Attendance
    <a href="<?php echo ADMIN_BASE_URL . 'attendance'; ?>"><button type="button" class="btn btn-lg btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;<b>Back</b></button></a>
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
                        <th>Section</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($attendance)) {
                                    foreach ($attendance->result() as
                                            $new) {
                                        $i++;
                                        ?>
                                    <tr id="Row_<?=$new->id?>" class="odd gradeX " >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $new->student_name  ?></td>
                                        <td><?php echo $new->roll_no ?></td>
                                        <td><?php echo $new->section_name  ?></td>
                                        <td><?php echo $new->subject_name ?></td>
                                        <td><?php echo $new->attend_date  ?></td>
                                        <td>
                                            <div class="col-sm-5">
                                        <div class="form-group">
                                          <div class="col-md-8"> 
                                            <select name="attend_status" id="attend_status" required="required" class="form-control">
                                              <option value="present" <?php if($new->attend_status == 'present') echo 'selected'; ?> >Present</option>
                                              <option value="absent" <?php if($new->attend_status == 'absent') echo 'selected'; ?> >Absent</option>
                                              <option value="leave" <?php if($new->attend_status == 'leave') echo'selected'; ?> >Leave</option>
                                            </select>
                      </div>
                        </div>
                      </div>
                                        </td>
                                        <td class="table_action">
                                        <div class="btn btn-primary edit_attendance round" roll_no="<?php echo $new->roll_no; ?>" std_id="<?php echo $new->student_id; ?>"
                                                    std_name="<?php echo $new->student_name; ?>"
                                                 attendance_id="<?php echo $new->id; ?>" status="<?php echo $new->attend_status; ?>">update</div> 
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

$(document).on("click", ".edit_attendance", function(event){
event.preventDefault();
var std_id = $(this).attr('std_id');
var std_name = $(this).attr('std_name');
var attendance_id = $(this).attr('attendance_id');
var roll_no = $(this).attr('roll_no');
var attend_status = $(this).parent().parent().find('#attend_status').val()
// alert(roll_no);

$.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>attendance/change_status",
        data: {'std_id': std_id,'std_name': std_name,'attendance_id' : attendance_id,'roll_no' : roll_no,'attend_status' :attend_status},
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

