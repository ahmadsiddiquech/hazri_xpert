<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title> <?=$page_title;?></title>

<!-- Bootstrap -->
<script src="<?php  echo STATIC_FRONT_JS?>jquery.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="<?php echo STATIC_FRONT_CSS?>custom.css" rel="stylesheet">
<link href="<?php echo STATIC_FRONT_CSS?>bootstrap.min.css" rel="stylesheet">
<link  href="<?php echo STATIC_FRONT_CSS?>font-awesome.min.css">
<link  href="<?php echo STATIC_FRONT_CSS?>jquery-confirm.css">
<link  href="<?php echo STATIC_FRONT_CSS?>yahooapis.css">
<link  href="<?php echo STATIC_FRONT_CSS?>jquery.nouislider.css">

<link href="<?php echo STATIC_FRONT_CSS?>bootstrap-fileupload.css" rel="stylesheet">
<link href="<?php echo STATIC_FRONT_CSS?>checkbox.css" rel="stylesheet">
<link href="<?php echo STATIC_FRONT_CSS?>checkbox-style.css" rel="stylesheet">

<link  href="<?php echo STATIC_FRONT_CSS?>bootstrap-slider.css">
<link  href="<?php echo STATIC_FRONT_CSS?>font-awsome.css">
<link href="<?php echo STATIC_FRONT_CSS?>bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- Include all compiled plugins (below), or include individual files as needed 
        <link href="<?php echo STATIC_FRONT_CSS?>nouislider.min.css" rel="stylesheet">-->
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

<![endif]-->

</head>
  <body>
    <header class="navbar-fixed-top">
      <div class="container">
          <div class="row">
              <div class="logo col-lg-2" style="padding: 0px;margin: 0px;">
                  <a href="<?= BASE_URL ?>"><img src="<?php echo STATIC_FRONT_IMAGE?>logo.png" alt="logo" class="img-responsive"></a>
                </div>
                <div class="top_nav col-lg-10">
                           <nav class="navbar navbar-default">
                              <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                  </button>
                                </div>
                            
                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                  <ul class="nav navbar-nav">
                                   
                                   
                                   <li class="" ><a href="<?= BASE_URL ?>" style="color: #FFF;">Home <span class="sr-only">(current)</span></a></li>
                        <li class="" ><a href="<?= BASE_URL.'user_adds' ?>" style="color: #FFF;">Post Ad <span class="sr-only">(current)</span></a></li>
                        <li><a href="<?=BASE_URL.'helper'?>" style="color: #FFF;" > I Want To Help <span class="sr-only">(current)</span></a></a></li>
                        <li><a href="<?= BASE_URL.'ineed' ?>" style="color: #FFF;">I Need Help</a></li>
                        <?php if ($this->session->userdata['user_session']['id']) { ?>
                        <li class="dropdown">
                
                              <a href="#" style="color: #FFF;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">User Account <span class="caret"></span></a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Profile</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">Messages</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#">My Ads</a></li>
                                 <li role="separator" class="divider"></li>
                                <li><a href="<?= BASE_URL.'log_out' ?>" ><span class="glyphicon glyphicon-log-out"> Logout</a></li>
                              </ul>
                            </li>
                            <?php } else {?>
                            <li><a href="<?=BASE_URL.'user_account'?>" style="color: #FFF;"> <span class="glyphicon glyphicon-user"></span> My Account</a></li>
                            <?php } ?>
                                  </ul>
                                  
                                </div><!-- /.navbar-collapse -->
                              </div><!-- /.container-fluid -->
</nav>
                </div>
            </div>
        </div>
    </header>
    <div class="clearfix"></div>
    <div class="top_banner">
      <div class="container-fluid">
          <div class="row">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                      <ol class="carousel-indicators">
                        <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                        <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                      </ol>
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner" role="listbox">
                        <div class="item active">
                          <img src="<?php echo STATIC_FRONT_IMAGE?>slider_01.jpg" alt="slider_01">
                          <div class="carousel-caption">
                          </div>
                        </div>
                        <div class="item">
                          <img src="<?php echo STATIC_FRONT_IMAGE?>slider_01.jpg" alt="slider_01">
                        </div>
                         <div class="item">
                          <img src="<?php echo STATIC_FRONT_IMAGE?>slider_01.jpg" alt="slider_01">
                        </div>
                      </div>
                      <!-- Controls -->
                      <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                      </a>
                      <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                      </a>
                </div>
              </div>
        </div>
   </div>
   