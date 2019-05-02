<?php 

  $page = "Account Approval | Primepak Multipurpose Cooperative";
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
          <h1 class="h3 mb-0 text-gray-800">Loan Requests</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Loans For Approval</h6>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-12 mb-6 mb-sm-0">
                <?php 

                if($userLevel == 'admin')
                {
                  $sql = "SELECT *, CONCAT('Php ', FORMAT(totalamount,2)) AS 'totalamount' FROM loanrequesttbl WHERE totalrequeststatus = 'admin approval';";  
                }
                if($userLevel == 'chairperson')
                {
                  $sql = "SELECT *, CONCAT('Php ', FORMAT(totalamount,2)) AS 'totalamount' FROM loanrequesttbl WHERE totalrequeststatus = 'chairperson approval';";  
                }

                
                  $res = mysqli_query($db, $sql);

                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Application No</th>
                      <th>Member ID</th>
                      <th>Name</th>
                      <th>Loan Type</th>
                      <th>Total Amount</th>
                      <th>Full Details</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      while ($row = mysqli_fetch_array($res)) 
                      {
                        
                      ?>
                      <tr>
                        <td><?php echo $row['loanrequestid']; ?></td>
                        <td><?php echo $row['memberid']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo ucfirst($row['loantype']); ?></td>
                        <td><?php echo $row['totalamount']; ?></td>
                        <?php 
                        if($userLevel == 'admin')
                        {
                        ?>
                        <td style="text-align: center;"><a href="viewrequest.php?applicationno=<?php echo $row['loanrequestid']; ?>&memberid=<?php echo $row['memberid']; ?>" class="btn btn-primary btn-sm">View</a></td>
                        <?php
                        }
                        if($userLevel == 'chairperson')
                        {
                        ?>
                        <td style="text-align: center;"><a href="viewrequestfinal.php?applicationno=<?php echo $row['loanrequestid']; ?>&memberid=<?php echo $row['memberid']; ?>" class="btn btn-primary btn-sm">View</a></td>
                        <?php
                        }
                        ?>
                      </tr>
                      <?php
                      }
                    ?>
                  </tbody>
                </table>

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
