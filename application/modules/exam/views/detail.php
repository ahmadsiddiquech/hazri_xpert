<?php // print_r($post['title']); exit(); ?>

<div class="row">
    <div class="col-md-6">
        <h4 ><b>ID:&nbsp;&nbsp;</b></h4><?php echo $user['exam_id']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Exam Title:&nbsp;&nbsp;</b></h4><?php echo $user['exam_title']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Exam Description:&nbsp;&nbsp;</b></h4><?php echo $user['exam_description']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Program Name:&nbsp;&nbsp;</b></h4><?php echo $user['program_name']; ?>
    </div>
    <div class="col-md-6">
         <h4 ><b>Class Name:&nbsp;&nbsp;</b></h4><?php echo $user['class_name']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
       <h4 ><b>Exam Start Date:&nbsp;&nbsp;</b></h4><?php echo $user['start_date']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Exam End Time:&nbsp;&nbsp;</b></h4><?php echo $user['end_date']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Status:&nbsp;&nbsp;</b></h4><?php echo $user['status']; ?>
    </div>
</div>