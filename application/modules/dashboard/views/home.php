<div class="page-content-wrapper">

<div class="page-content">

<style>

img {

  display: block;

  margin-left: auto;

  margin-right: auto;

}

.shadow{

    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);

}

</style>

<!-- BEGIN PAGE HEADER-->

<!-- <div class="row">

    <div class="col-md-12"  style="position:relative;">

        

       

        <ul class="page-breadcrumb breadcrumb">

        

            <li>

                <a href="<?php echo ADMIN_BASE_URL?>dashboard"><i class="fa fa-home"></i></a>

                <a href="<?php echo ADMIN_BASE_URL?>dashboard">Dashboard</a>

            </li>

        </ul>



      

    </div>

</div> -->



<div class="row" style="padding-bottom: 30px;padding-top: 30px;">

    <div class="col-md-12">

        <div class="card text-white bg-info shadow">

                <div class="card-body row">

                    <div class="col-md-4">

                        <img src="<?php echo BASE_URL.'plugin/img/org.png'?>">

                    </div>

                    <div class="col-md-8" style="padding-top: 10px;">

                        <h2 class="card-text"><?php echo $organization; ?></h2>

                    </div>

                </div>

        </div>

    </div>

</div>

<div class="row" style="padding-left:50px;">

    <div class="col-md-4" onclick="location.href='user';">

        <div class="card text-white bg-primary col-md-10 shadow">

                <div class="card-body ">

                    <img src="<?php echo BASE_URL.'plugin/img/teacher.png'?>">

                    <h2 class="card-text"><center>Total Teachers:<br><?php echo $teacher; ?></center></h2>

                </div>

        </div>

    </div>

    <div class="col-md-4" onclick="location.href='user';">

        <div class="card text-white bg-primary col-md-10 shadow">

                <div class="card-body">

                    <img src="<?php echo BASE_URL.'plugin/img/parent.png'?>">

                    <h2 class="card-text"><center>Total Parents:<br><?php echo $parent; ?></center></h2>

                </div>

        </div>

    </div>

    <div class="col-md-4" onclick="location.href='student';">

        <div class="card text-white bg-primary col-md-10 shadow">

                <div class="card-body">

                    <img src="<?php echo BASE_URL.'plugin/img/stdnew.png'?>">

                    <h2 class="card-text"><center>Total Students:<br><?php echo $student; ?></center></h2>

                </div>

        </div>

    </div>

</div>

<div class="row" style="padding-top: 20px;">

    <div class="col-md-12" onclick="location.href='announcement';">

        <div class="card text-white  shadow" style="background-color: rgb(77, 182, 172)">

                <div class="card-body">

                    <?php if(isset($announcement) && !empty($announcement)){

                        ?>

                    

                    <h4 class="card-text"><marquee><br><?php echo $announcement[0]['title']; ?></marquee></h5>

                    <h5 class="card-text"><marquee><?php echo $announcement[0]['description']; ?><br><br></marquee></h5>

                <?php }?>

                </div>

        </div>

    </div>

</div>



<!-- END PAGE HEADER-->

</div>

</div>

</div>

</div>

</div>





