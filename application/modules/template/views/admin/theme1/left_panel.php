<?php    
	$curr_url = $this->uri->segment(2);
	$active="active";
  $role_id = $this->session->userdata('user_data')['role_id'];
?>
<!-- sidebar-->
<aside class="aside" >
 <!-- START Sidebar (left)-->
 <div class="aside-inner" >
    <nav data-sidebar-anyclick-close="" class="sidebar">
       <!-- START sidebar nav-->
       <ul class="nav page-sidebar-menu">
          <!-- Iterates over all sidebar items-->

      
      <?php if($role_id!=1){ ?>
         <li class="<?php if($curr_url == 'dashboard'){echo 'active';}    ?>">
                <a href="<?php $controller='dashboard'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-home"></em>
                   <span>Dashboard</span>
                </a>
          </li>
          <?php } if($role_id==1){ ?>
          <li class="<?php if($curr_url == 'organizations'){echo 'active';}    ?>">
              <a href="<?php $controller='organizations'; 
              echo ADMIN_BASE_URL . $controller ?>">
             <em class="fa fa-users"></em>
                <span>Organizations</span>
             </a>
          </li>
          <li class="<?php if($curr_url == 'banner'){echo 'active';}    ?>">
                <a href="<?php $controller='banner'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-flag"></em>
                   <span>Banner</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'user_log'){echo 'active';}    ?>">
                <a href="<?php $controller='user_log'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-calendar"></em>
                   <span>User Log</span>
                </a>
          </li>
         <?php } if($role_id != 1){ ?>
          <li class="<?php if($curr_url == 'user'){echo 'active';}    ?>">
                <a href="<?php $controller='user'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-user"></em>
                   <span>User</span>
                </a>
          </li>

          <li class="<?php if($curr_url == 'program'){echo 'active';}    ?>">
                <a href="<?php $controller='program'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-th-large"></em>
                   <span>Program</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'program'){echo 'active';}    ?>">
                <a href="<?php $controller='program'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-th-large"></em>
                   <span>Program</span>
                </a>
          </li>


          <li class="<?php if($curr_url == 'classes'){echo 'active';}    ?>">
                <a href="<?php $controller='classes'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-th-list"></em>
                   <span>Classes</span>
                </a>
          </li>

          <li class="<?php if($curr_url == 'sections'){echo 'active';}    ?>">
                <a href="<?php $controller='sections'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-delicious"></em>
                   <span>Sections</span>
                </a>
          </li>

          <li class="<?php if($curr_url == 'subjects'){echo 'active';}    ?>">
                <a href="<?php $controller='subjects'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-book"></em>
                   <span>Subjects</span>
                </a>
          </li>

          <li class="<?php if($curr_url == 'student'){echo 'active';}    ?>">
                <a href="<?php $controller='student'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-child"></em>
                   <span>Student</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'exam'){echo 'active';}    ?>">
                <a href="<?php $controller='exam'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-pencil-square-o"></em>
                   <span>Exam</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'test'){echo 'active';}    ?>">
                <a href="<?php $controller='test'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-pencil"></em>
                   <span>Test</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'attendance'){echo 'active';} ?>">
                <a href="<?php $controller='attendance'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-check"></em>
                   <span>Attendance</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'leave'){echo 'active';}    ?>">
                <a href="<?php $controller='leave'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-clock-o"></em>
                   <span>Leave</span>
                </a>
          </li>
          <li class="<?php if($curr_url == 'announcement'){echo 'active';}    ?>">
                <a href="<?php $controller='announcement'; 
                   echo ADMIN_BASE_URL . $controller ?>">
                   <em class="fa fa-bullhorn"></em>
                   <span>Announcement</span>
                </a>
          </li>
        <?php } ?>
       </ul>
       <!-- END sidebar nav-->
    </nav>
 </div>
 <!-- END Sidebar (left)-->
</aside>




