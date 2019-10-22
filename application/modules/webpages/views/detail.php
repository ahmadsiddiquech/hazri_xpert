
<h4 ><b>Title:&nbsp;&nbsp;</b></h4><?php echo $sub_pages_details['page_title']; ?>

<div class="page-content-wrapper"><?php // print_r($thought_of_day['title']);exit; ?>
        <!-- END PAGE HEADER-->
       
        <!-- BEGIN PAGE CONTENT-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">

                       
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                       
                            <div class="form-body">                               

                                    <h4 class="form-section">URL</h4>
                           
                                    <div class="row">
                                        <div class="col-sm-12">
                                                <?php echo $sub_pages_details['url_slug']; ?>
                                            </span>
                                        </div>
                                    </div>

                                <h4 class="form-section">Short Description</h4>
                           
                                <div class="row">
                                    <div class="col-sm-8">
                                            <?php if(isset($sub_pages_details['meta_description']) && $sub_pages_details['meta_description'])
                                                echo $sub_pages_details['meta_description'];
                                            else
                                                echo "Nill";
                                            ?>
                                    </div>
                                   
                                </div>


                                  <h4 class="form-section">Long Description</h4>
                                    <!--/span-->
                                    <div class="row">
                                            <div class="col-md-12">
                                                    <?php if(isset($sub_pages_details['page_content']) && !empty($sub_pages_details['page_content']))
                                                        echo $sub_pages_details['page_content'];
                                                    else
                                                        echo "Nill";
                                                    ?>
                                            </div>
                                    </div>

                                </div>
                           
                        
                            </div>
                        
                        <!-- END FORM-->
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
<!--    </div>-->
</div>
</div>


