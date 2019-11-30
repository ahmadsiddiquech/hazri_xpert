<!-- Page content-->
<div class="content-wrapper">
    <h3>Users Log
        <a href="<?php echo ADMIN_BASE_URL . 'user_log'; ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a>
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
                        <th>Name</th>
                        <th>Userame</th>
                        <th>Org Name</th>
                        <th>Device</th>
                        <th>Login Date & Time</th>
                        <th>Logout Date & Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                if (isset($news) && !empty($news)) {
                                    foreach ($news as $key => $value) {
                                        $i++;
                                        ?>
                                        <tr >
                                        <td width='2%'><?php echo $i;?></td>
                                        <td><?php echo $value['name']  ?></td>
                                        <td><?php echo $value['username'] ?></td>
                                        <td><?php echo $value['org_name'] ?></td>
                                        <td><?php echo $value['device_name'] ?></td>
                                        <td><?php echo $value['login_date'] ?></td>
                                        <td><?php echo $value['logout_date'] ?></td>
                                        <td>
                                            <div class="col-sm-5">
                                        <div class="form-group">
                                          <div class="col-md-8"> 
                                            <select name="status" id="status" required="required" class="form-control">
                                              <option value="0" <?php if($value['login_status'] == 0) echo 'selected'; ?> >Logged Out</option>
                                              <option value="1" <?php if($value['login_status'] == 1) echo 'selected'; ?> >Logged In</option>
                                            </select>
                      </div>
                        </div>
                      </div>
                                        </td>

                                        <td class="table_action">
                                        <div class="btn btn-primary edit_user_log round" user_id="<?php echo $value['user_id']; ?>" org_id="<?php echo $value['org_id']; ?>"
                                                 log_id="<?php echo $value['id']; ?>" status="<?php echo $value['login_status']; ?>">update</div> 
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

$(document).on("click", ".edit_user_log", function(event){
event.preventDefault();
var user_id = $(this).attr('user_id');
var org_id = $(this).attr('org_id');
var log_id = $(this).attr('log_id');
var status = $(this).parent().parent().find('#status').val()
// alert(status);

$.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>user_log/change_status",
        data: {'user_id': user_id,'org_id': org_id,'log_id' : log_id,'status' : status},
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