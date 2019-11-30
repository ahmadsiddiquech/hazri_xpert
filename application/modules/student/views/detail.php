<div class="row">
    <div class="col-md-6">
        <h4 ><b>ID:&nbsp;&nbsp;</b></h4><?php echo $user['id']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Name:&nbsp;&nbsp;</b></h4><?php echo $user['name']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Parent Name:&nbsp;&nbsp;</b></h4><?php echo $user['parent_name']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Parent Phone:&nbsp;&nbsp;</b></h4><?php echo $user['p_c_no']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Date of Birth:&nbsp;&nbsp;</b></h4><?php echo $user['dob']; ?>
    </div>
    <div class="col-md-6">
         <h4 ><b>Gender:&nbsp;&nbsp;</b></h4><?php echo $user['gender']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
       <h4 ><b>Address:&nbsp;&nbsp;</b></h4><?php echo $user['address']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Addmission Date:&nbsp;&nbsp;</b></h4><?php echo $user['addmission_date']; ?>
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
        <h4 ><b>Section Name:&nbsp;&nbsp;</b></h4><?php echo $user['section_name']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Tution Fee:&nbsp;&nbsp;</b></h4><?php echo $user['tution_fee']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Transport Fee:&nbsp;&nbsp;</b></h4><?php echo $user['transport_fee']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Lunch Fee:&nbsp;&nbsp;</b></h4><?php echo $user['lunch_fee']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Stationary Fee:&nbsp;&nbsp;</b></h4><?php echo $user['stationary_fee']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Other Fee:&nbsp;&nbsp;</b></h4><?php echo $user['other_fee']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Status:&nbsp;&nbsp;</b></h4><?php echo $user['status']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Image:&nbsp;&nbsp;</b></h4><image src="<?php if(isset($user['image']) && !empty($user['image'])) { echo BASE_URL.SMALL_STUDENT_IMAGE_PATH. $user['image']; } else{ echo "http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image";} ?>">
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <h4 ><b>Subject Name:&nbsp;&nbsp;</b></h4>
    </div>
    <div class="col-md-4">
        <h4 ><b>Subject Type:&nbsp;&nbsp;</b></h4>
    </div>
    <div class="col-md-4">
        <h4 ><b>Teacher Name:&nbsp;&nbsp;</b></h4>
    </div>
</div>
<?php foreach ($subject as $key => $value) { ?>
<div class="row">
    <div class="col-md-4">
    <?php echo $value['subject_name']; ?>
    </div>
    <div class="col-md-4">
        <?php echo $value['subject_type']; ?>
    </div>
    <div class="col-md-4">
        <?php echo $value['teacher_name']; ?>
    </div>
</div>
<?php } ?>