<div class="row">
    <div class="col-md-6">
        <h4 ><b>ID:&nbsp;&nbsp;</b></h4><?php echo $user['id']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Event Title:&nbsp;&nbsp;</b></h4><?php echo $user['title']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Description:&nbsp;&nbsp;</b></h4><?php echo $user['description']; ?>
    </div>
    <div class="col-md-6">
        <h4 ><b>Event Date:&nbsp;&nbsp;</b></h4><?php echo $user['event_date']; ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h4 ><b>Image:&nbsp;&nbsp;</b></h4><image src="<?php echo BASE_URL.SMALL_GALLERY_IMAGE_PATH. $user['image']; ?>">
    </div>
    <div class="col-md-6">
        <h4 ><b>Status:&nbsp;&nbsp;</b></h4><?php echo $user['status']; ?>
    </div>
</div>