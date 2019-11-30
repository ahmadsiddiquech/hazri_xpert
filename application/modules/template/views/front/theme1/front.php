<?php $this->load->view('front/theme1/header');?> <!--HEADER-->


<!-- PAGE CONTENT PANEL STARTS HERE-->
<section>
        <div class="row">
            <div class="clearfix"></div>
            <div class=""><!--main_body-->
                <div class="">
					<?php 
                        if(!isset($view_file)){
                                $viiew_file = '';
                            }
                        $path = 'front/'.$view_file;
                        $this->load->view($path);
                     ?>
                    </div>
                  
					
                     
                </div>
        </div>
</section>
<!--PAGE CONTENT PANEL ENDS HERE-->

<?php // $this->load->view('front/theme1/footer_banner');?>

<?php $this->load->view('front/theme1/footer');?>



 