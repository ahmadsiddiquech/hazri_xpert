<?php //  print_r($mosque); exit(); ?>


                           
        <div class="row">
            <h4><b> &nbsp;&nbsp; Bulding Name:&nbsp;&nbsp;</b></h4>
            <div class="col-sm-6">
                    <?php echo $mosque['building_name']; ?>
            </div>

            <div class="col-sm-6">
                    <span >
                    <?php
                    $item_img = base_url() . "static/admin/theme1/images/no_item_image_small.jpg";
                    if (!empty($mosque['image']) && file_exists(FCPATH . SMALL_OUTLET_IMAGE_PATH . $mosque['image']))

                        $item_img = IMAGE_BASE_URL . 'outlet/small_images/' . $mosque['image'];
                    ?>
                    <img src="<?= $item_img ?>"/>
                    </span>
            </div>
        </div>

        <div class="row">
            
            <div class="col-sm-6">
            <h4><b> Address:&nbsp;&nbsp;</b></h4>
                    <?php echo $mosque['address']; ?>
            </div>

            
            <div class="col-sm-6"><span >
            <h4><b> City:&nbsp;&nbsp;</b></h4>
                    
                    <?php echo $mosque['city']; ?>
                    </span>
            </div>
        </div>

        <div class="row">
            
            <div class="col-sm-6">
            <h4><b> Country:&nbsp;&nbsp;</b></h4>
                    <?php echo $mosque['country']; ?>
            </div>

            
            <div class="col-sm-6"><span >
            <h4><b> State:&nbsp;&nbsp;</b></h4>
                    
                    <?php echo $mosque['state']; ?>
                    </span>
            </div>
        </div>

        <div class="row">
            
            <div class="col-sm-6">
            <h4><b> Phone:&nbsp;&nbsp;</b></h4>
                    <?php echo $mosque['phone']; ?>
            </div>

            
            <div class="col-sm-6"><span >
            <h4><b> Zip:&nbsp;&nbsp;</b></h4>
                    
                    <?php echo $mosque['zip']; ?>
                    </span>
            </div>
        </div>

        <div class="row">
            
            <div class="col-sm-6">
            <h4><b> Longitude:&nbsp;&nbsp;</b></h4>
                    <?php echo $mosque['longitude']; ?>
            </div>

            
            <div class="col-sm-6"><span >
            <h4><b> URL:&nbsp;&nbsp;</b></h4>
                    
                    <?php echo $mosque['url']; ?>
                    </span>
            </div>
        </div>

        <div class="row">
            
            <div class="col-sm-6">
            <h4><b> Latitude:&nbsp;&nbsp;</b></h4>
                    <?php echo $mosque['latitude']; ?>
            </div>

            
            <div class="col-sm-6"><span >
            <h4><b> E-mail:&nbsp;&nbsp;</b></h4>
                    
                    <?php echo $mosque['email']; ?>
                    </span>
            </div>
        </div>