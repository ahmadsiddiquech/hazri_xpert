<div class="row">
    <div class="col-md-6">
        <h4 ><b>Voucher ID:&nbsp;&nbsp;</b></h4><?php echo $user['std_voucher_id']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Student Name:&nbsp;&nbsp;</b></h4><?php echo $user['std_name']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Parent Name:&nbsp;&nbsp;</b></h4><?php echo $user['parent_name']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Program Name:&nbsp;&nbsp;</b></h4><?php echo $user['program_name']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Class Name:&nbsp;&nbsp;</b></h4><?php echo $user['class_name']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Section Name:&nbsp;&nbsp;</b></h4><?php echo $user['section_name']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Tution Fee:&nbsp;&nbsp;</b></h4><?php echo $user['tution_fee']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Transport Fee:&nbsp;&nbsp;</b></h4><?php echo $user['transport_fee']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Stationary Fee:&nbsp;&nbsp;</b></h4><?php echo $user['stationary_fee']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Lunch Fee:&nbsp;&nbsp;</b></h4><?php echo $user['lunch_fee']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Other Fee:&nbsp;&nbsp;</b></h4><?php echo $user['other_fee']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Total Fee:&nbsp;&nbsp;</b></h4><?php echo $user['total']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Paid Fee:&nbsp;&nbsp;</b></h4><?php echo $user['paid']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Remaining Fee:&nbsp;&nbsp;</b></h4><?php echo $user['remaining']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Status:&nbsp;&nbsp;</b></h4><?php if($user['status'] == 1 ) {
            echo "Paid";
        } else {
            echo "Un-Paid";
        } ?>
    </div>
</div>