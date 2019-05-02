<?php 


  $memberid = $_SESSION['memberid'];

  $sqld = "SELECT * from memberdetailstbl WHERE memberid = '$memberid'";
  $ress = mysqli_query($db, $sqld);
  $fetch = mysqli_fetch_array($ress);

?>

<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #E57373;">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" style="margin-top: 10px; margin-bottom: 10px;">
        <div class="sidebar-brand-text mx-3" >Primepak Multipurpose Cooperative</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if($active == 'index'){echo "active";} ?>">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Account</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <?php 

        $queryy = "SELECT * FROM loanrequesttbl WHERE memberid = '$memberid' AND paymentstatus = 'unpaid' AND totalrequeststatus != 'declined request';";
        $selected = mysqli_query($db, $queryy);
        $rowss = mysqli_num_rows($selected);
        if($rowss < 1)
        {
        ?>
        <li class="nav-item <?php if($active == 'request'){echo "active";} ?>" <?php if($fetch['status'] == 'inactive' || $fetch['status'] == 'declined'){echo 'style="display:none;"';} ?>>
        <!-- request link -->
          <?php 
            $requestLink = "request.php?mid=".$_SESSION['memberid'];
          ?>
          <a class="nav-link" href="<?php echo $requestLink; ?>">
            <i class="fas fa-money-check"></i>
            <span>Request Loan</span></a>
        </li>

        <!-- SELECT * FROM loanrequesttbl WHERE memberid = '16-1991-2019' AND paymentstatus = 'unpaid' AND totalrequeststatus = 'comaker approval'; -->
        
        <li class="nav-item" <?php if($fetch['status'] == 'active'){echo 'style="display:none;"';}?>>
          <a class="nav-link" href="">
            <i class="fas fa-money-check"></i>
            <span>Request Loan: Admin Verification Needed</span></a>
        </li>
        <?php
        }
        else
        {
        ?>
          <li class="nav-item <?php if($active == 'request'){echo "active";} ?>" <?php if($fetch['status'] == 'inactive'){echo 'style="display:none;"';}?>>
            <a class="nav-link" href="viewloan.php">
              <i class="fas fa-money-check"></i>
              <span>View Loan Request</span></a>
          </li>
        <?php
        }
      ?>

      <hr class="sidebar-divider my-0">

      <li class="nav-item <?php if($active == 'notification'){echo "active";} ?>">
        <a class="nav-link" href="notifications.php">
          <i class="fas fa-bell"></i>
          <span>Notification</span></a>
      </li>

      <hr class="sidebar-divider my-0">

      <li class="nav-item <?php if($active == 'loan history'){echo "active";} ?>">
        <a class="nav-link" href="loanhistory.php">
          <i class="fas fa-book"></i>
          <span>Loan History</span></a>
      </li>

      <!-- Heading --><!-- 
      <div class="sidebar-heading">
        Loan
      </div> -->

      <!-- Nav Item - Pages Collapse Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
          </div>
        </div>
      </li> -->

      <!-- Nav Item - Utilities Collapse Menu -->
     <!--  <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
          </div>
        </div>
      </li> -->

      <!-- Divider -->
      <!-- <hr class="sidebar-divider"> -->

      <!-- Heading -->
      <!-- <div class="sidebar-heading">
        Addons
      </div> -->

      <!-- Nav Item - Pages Collapse Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li> -->

      <!-- Nav Item - Charts -->

      

      <!-- Nav Item - Tables -->
      <!-- <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li> -->

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>