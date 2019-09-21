<!-- Page content-->


<div class="content-wrapper">
    <h3>
    <?php 
    $urlPath = $this->uri->segment(6);
    echo ucwords(str_replace('%20',' ',$urlPath));
    ?>
    <a href="<?php echo ADMIN_BASE_URL . 'exam/subjects/'.$this->uri->segment('4') .'/' . $this->uri->segment(6); ?>"><button type="button" class="btn btn-primary pull-right"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Back</button></a></h3>
    <div class="container-fluid">
        <!-- START DATATABLE 1 -->
        <form action="<?php echo ADMIN_BASE_URL . 'exam/submit_marks/'.$this->uri->segment('4').'/'.$this->uri->segment('5') ?>" method="post">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                    <table id="datatable2" class="table table-striped table-hover table-body">
                        <thead class="bg-th">
                        <tr class="bg-col">
                        <th class="sr">S.No</th>
                        <th>Roll No</th>
                        <th>Student Name</th>
                        <th>Obtained Marks</th>
                        <!-- <th>Save Marks</th> -->
                        <th>Total Marks</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php
                                $i = 0;
                                $flag = 0;
                                if (isset($student_list)) {
                                    foreach ($student_list as $key=>
                                            $new) {
                                        $i++;
                                        $flag++;
                                        if (isset($new['obtained_marks']) && !empty($new['obtained_marks']))
                                        {
                                            $flag--;
                                        }
                                        ?>
                                        <td width='2%'><?php echo $i;?>
                                            <input class="form-control" readonly type="hidden" name="std_id[]" value="<?php echo $new['std_id']  ?>">
                                        </td>
                                        <td><input class="form-control" readonly type="number" name="roll_no[]" value="<?php echo $new['roll_no']  ?>"></td>
                                        <td><input class="form-control" readonly type="text" name="std_name[]" value="<?php echo $new['name']  ?>"></td>
                                        <td>
                                            <input class="form-control" id="std_id_<?php echo $new['std_id']; ?>" type="number" max="<?php echo $new['total_marks']?>" min="0" name="obtained_marks[]" 
                                            value="<?php if(isset($new['obtained_marks'])){ echo($new['obtained_marks']);} ?>">

                                            <?php if ($i != $flag) { ?>
                                                
                                                <div class="btn btn-primary edit_marks round" roll_no="<?php echo $new['roll_no']; ?>" std_id="<?php echo $new['std_id']; ?>"
                                                    sbj_id="<?php echo $new['subject_id']; ?>"
                                                    std_name="<?php echo $new['name']; ?>"
                                                 exam_id="<?php echo $new['exam_id']; ?>" obt_marks="<?php echo $new['obtained_marks']; ?>">update</div> 
                                            <?php } ?>
                                        </td>
                                        <td><input class="form-control" readonly type="number" value="<?php echo $new['total_marks']  ?>"></td>
                                        <!-- <td></td> -->
                                        <!-- <td><?php echo anchor($edit_url, '<i class="fa fa-edit"></i>', array('class' => 'action_edit btn blue c-btn','title' => 'Edit exam')); ?></td> -->
                                    </tr>
                                    <?php } ?>    
                                <?php } ?>
                            </tbody>
                    </table>
                    </div>
                    <div class="form-actions fluid no-mrg">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-offset-2 col-md-9" style="padding-bottom:15px;">
                       <?php if ($i == $flag)
                       {?>
                        <span style="margin-left:40px"></span> <button type="submit" id="button1" class="btn btn-primary"><i class="fa fa-check"></i>&nbsp;Save</button>
                        <a href="<?php echo ADMIN_BASE_URL . 'exam/subjects/'.$this->uri->segment('4'); ?>">
                        <button type="button" class="btn green btn-default" style="margin-left:20px;"><i class="fa fa-undo"></i>&nbsp;Cancel</button>
                        <?php } ?>
                        </a> </div>
                    </div>
                  </div>
                </div>
                </div>

            </div>
        </div>
    </form>
    <!-- END DATATABLE 1 -->
    
    </div>
</div>    

<script type="text/javascript">

$(document).on("click", ".edit_marks", function(event){
event.preventDefault();
var std_id = $(this).attr('std_id');
var std_name = $(this).attr('std_name');
var exam_id = $(this).attr('exam_id');
var sbj_id = $(this).attr('sbj_id');
var roll_no = $(this).attr('roll_no');
var obt_mark = $(this).siblings('#std_id_'+std_id).val();
// alert(std_name);

$.ajax({
        type: 'POST',
        url: "<?php echo ADMIN_BASE_URL?>exam/update_marks",
        data: {'std_id': std_id,'std_name': std_name,'exam_id' : exam_id,'sbj_id' : sbj_id,'roll_no' : roll_no,'obt_mark' :obt_mark},
        async: false,
        success: function(result) {
            if (result) {
                  toastr.success('Marks Updated Successfully');
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

