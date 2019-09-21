   <?php foreach($res_categories->result() as $res_category){ ?>
    <div class="item_block col-lg-4 col-sm-4">
        <div class="item_block_inner">
            <a class="cat_name" href="<?=  BASE_URL . 'category/'.$res_category->id ?>"><?=  $res_category->cat_name  ?></a>
            <a href="<?=  BASE_URL . 'category/'.$res_category->id ?>"> <?php if($res_category->image){?> 
             <img src="<?php echo BASE_URL.ACTUAL_CATAGORIES_IMAGE_PATH.$res_category->image?>"
              alt="Vehicles"> <?php }
               else { ?>
              <img src="<?php echo STATIC_FRONT_IMAGE.'no_image.jpg'?>" width="60px;"
            <?php    } ?> </a>
                
        </div>
    </div>
    <?php }?>

    <div class="clearfix"></div>
    <!-- Slider start-->
    <div class="slider">
    	<div class="container">
            <div class="row">
                <div class="col-md-12">
                		<h3>Last Published Ads</h3>
                        <div id="Carousel" class="carousel slide">
                        <!-- Carousel items -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <div class="row">
                                      <div class="col-sm-4 col-md-2 slider_block">
                                            <div class="thumbnail">
                                              <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_01.jpg" alt="Image" style="max-width:100%;"></a>
                                              <div class="caption">
                                                <label>HTC One Mini</label>
                                                <span>Rs. 20,000</span>
                                              </div>
                                            </div>
                                      </div>
                                      <div class="col-sm-4 col-md-2 slider_block">
                                            <div class="thumbnail">
                                              <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_02.jpg" alt="Image" style="max-width:100%;"></a>
                                              <div class="caption">
                                                <label>HTC One Mini</label>
                                                <span>Rs. 20,000</span>
                                              </div>
                                            </div>
                                      </div>
                                      <div class="col-sm-4 col-md-2 slider_block">
                                            <div class="thumbnail">
                                               <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_03.jpg" alt="Image" style="max-width:100%;"></a>
                                                 <div class="caption">
                                                <label>HTC One Mini</label>
                                                <span>Rs. 20,000</span>
                                              </div>
                                            </div>
                                      </div>
                                      <div class="col-sm-4 col-md-2 slider_block">
                                            <div class="thumbnail">
                                               <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_01.jpg" alt="Image" style="max-width:100%;"></a>
                                                 <div class="caption">
                                                <label>HTC One Mini</label>
                                                <span>Rs. 20,000</span>
                                              </div>
                                            </div>
                                      </div>
                                      <div class="col-sm-4 col-md-2 slider_block">
                                            <div class="thumbnail">
                                               <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_03.jpg" alt="Image" style="max-width:100%;"></a>
                                                 <div class="caption">
                                                <label>HTC One Mini</label>
                                                <span>Rs. 20,000</span>
                                              </div>
                                            </div>
                                      </div>
                                      <div class="col-sm-4 col-md-2 slider_block">
                                            <div class="thumbnail">
                                               <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_02.jpg" alt="Image" style="max-width:100%;"></a>
                                                 <div class="caption">
                                                <label>HTC One Mini</label>
                                                <span>Rs. 20,000</span>
                                              </div>
                                            </div>
                                      </div>
                                    </div><!--.row-->
                                </div>
                            <!--.item-->
                            <div class="item ">
                                <div class="row">
                                  <div class="col-sm-4 col-md-2 slider_block">
                                        <div class="thumbnail">
                                          <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_02.jpg" alt="Image" style="max-width:100%;"></a>
                                          <div class="caption">
                                            <label>HTC One Mini</label>
                                            <span>Rs. 20,000</span>
                                          </div>
                                        </div>
                                  </div>
                                  <div class="col-sm-4 col-md-2 slider_block">
                                        <div class="thumbnail">
                                          <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_03.jpg" alt="Image" style="max-width:100%;"></a>
                                          <div class="caption">
                                            <label>HTC One Mini</label>
                                            <span>Rs. 20,000</span>
                                          </div>
                                        </div>
                                  </div>
                                  <div class="col-sm-4 col-md-2 slider_block">
                                        <div class="thumbnail">
                                           <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_02.jpg" alt="Image" style="max-width:100%;"></a>
                                             <div class="caption">
                                            <label>HTC One Mini</label>
                                            <span>Rs. 20,000</span>
                                          </div>
                                        </div>
                                  </div>
                                  <div class="col-sm-4 col-md-2 slider_block">
                                        <div class="thumbnail">
                                           <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_01.jpg" alt="Image" style="max-width:100%;"></a>
                                             <div class="caption">
                                            <label>HTC One Mini</label>
                                            <span>Rs. 20,000</span>
                                          </div>
                                        </div>
                                  </div>
                                  <div class="col-sm-4 col-md-2 slider_block">
                                        <div class="thumbnail">
                                           <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_03.jpg" alt="Image" style="max-width:100%;"></a>
                                             <div class="caption">
                                            <label>HTC One Mini</label>
                                            <span>Rs. 20,000</span>
                                          </div>
                                        </div>
                                  </div>
                                  <div class="col-sm-4 col-md-2 slider_block">
                                        <div class="thumbnail">
                                           <a href="#" class="thumbnail"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_01.jpg" alt="Image" style="max-width:100%;"></a>
                                             <div class="caption">
                                            <label>HTC One Mini</label>
                                            <span>Rs. 20,000</span>
                                          </div>
                                        </div>
                                  </div>
                                  
                                  
                                 
                                </div><!--.row-->
                            </div>
                            
                            </div><!--.carousel-inner-->
                          <a data-slide="prev" href="#Carousel" class="left carousel-control"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_arrow_left.jpg" alt="slider_arrow_left"></a>
                          <a data-slide="next" href="#Carousel" class="right carousel-control"><img src="<?php echo STATIC_FRONT_IMAGE?>slider_arrow_right.jpg" alt="slider_arrow_left"></a>
                        </div><!--.Carousel-->
                         
                </div>
            </div>
</div><!--.container-->
    </div>
    <!-- Slider end-->
    <div class="add_three col-lg-12">
        <a href="#"><img src="<?php echo STATIC_FRONT_IMAGE?>banner_04.jpg" class="img-responsive" alt="banner_01"> </a>
    </div>