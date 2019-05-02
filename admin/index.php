<?php 

  $page = "Admin | Primepak Multipurpose Cooperative ";
  $active = "index";
  include 'includes/header.php';
  include 'core/db.php';
  session_start();
  if(!isset($_SESSION['admin']))
  {
    header("Location: login.php");
  }

  $memberid = $_SESSION['admin'];

  $sqld = "SELECT * from dashboardlogintbl WHERE id = '$memberid'";
  $ress = mysqli_query($db, $sqld);
  $fetch = mysqli_fetch_array($ress);

  $userLevel = $fetch['level'];
?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php 

      include 'includes/sidebar.php'; 

    ?>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include 'includes/topnav.php'; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

        <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          </div>

          <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow h-100 py-2" style="border-left:5px solid #E57373;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Account to Approve
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <?php 

                        $sql = "SELECT COUNT(*) AS 'toApprove' FROM memberdetailstbl WHERE status = 'inactive';";
                        $res = mysqli_query($db,$sql);
                        while($r = mysqli_fetch_array($res))
                        {
                          echo $r['toApprove'];
                        }

                        ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user-circle fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>  

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow h-100 py-2" style="border-left:5px solid #E57373;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Members
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <?php 

                        $sql = "SELECT COUNT(*) AS 'noOfMembers' FROM memberdetailstbl WHERE status = 'active';";
                        $res = mysqli_query($db,$sql);
                        while($r = mysqli_fetch_array($res))
                        {
                          echo $r['noOfMembers'];
                        }

                        ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>  

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow h-100 py-2" style="border-left:5px solid #E57373;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Loan Request
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <?php 

                        if($userLevel == 'admin')
                        {
                          $sql = "SELECT COUNT(*) AS 'approval', CONCAT('Php ', FORMAT(totalamount,2)) AS 'totalamount' FROM loanrequesttbl WHERE totalrequeststatus = 'admin approval';";  
                        }
                        if($userLevel == 'chairperson')
                        {
                          $sql = "SELECT COUNT(*) AS 'approval', CONCAT('Php ', FORMAT(totalamount,2)) AS 'totalamount' FROM loanrequesttbl WHERE totalrequeststatus = 'chairperson approval';";  
                        }

                        $res = mysqli_query($db,$sql);
                        while($r = mysqli_fetch_array($res))
                        {
                          echo $r['approval'];
                        }

                        ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> 

            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card shadow h-100 py-2" style="border-left:5px solid #E57373;">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        On-going Loans
                      </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">

                        <?php 

                        $sql = "SELECT COUNT(*) AS 'onGoing' FROM loanrequesttbl WHERE paymentstatus = 'unpaid';";
                        $res = mysqli_query($db,$sql);
                        while($r = mysqli_fetch_array($res))
                        {
                          echo $r['onGoing'];
                        }

                        ?>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> 

          </div>

          <div class="row">
            
            <div class="col-xl-8 col-lg-7">

              <!-- Area Chart -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Income</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>

              <!-- Bar Chart -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Requests</h6>
                </div>
                <div class="card-body">
                  <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                  </div>
                </div>
              </div>

            </div>

            <div class="col-xl-4 col-lg-5">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Members</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-pie pt-4">
                    <canvas id="myPieChart"></canvas>
                  </div>
                </div>
              </div>
            </div>

          </div>

        <!-- /.container-fluid -->
        </div>

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php 

        include 'includes/footer.php';

      ?>

  <!-- Bootstrap core JavaScript-->
  <?php 

    include 'includes/script.php';

  ?>

</body>

</html>
