<?php 

  $page = "Notification";
  $active = "notification";
  include 'includes/header.php';
  include 'core/db.php';
  session_start();
  if(!isset($_SESSION['memberid']))
  {
    header("Location: login.php");
  }

  $memberid = $_SESSION['memberid'];

  // $qued = "SELECT * FROM loanrequesttbl WHERE memberid = '$memberid' AND totalrequeststatus != '' ";
  // $es = mysqli_query($db, $qued);
  // $rowsres = mysqli_fetch_row($es);

  // if($rowsres < 0)
  // {
  //   echo '<script type="text/javascript">'; 
  //   echo 'window.location.href = "viewloan.php";';
  //   echo '</script>';
  // }

  $sql = "SELECT * FROM memberdetailstbl WHERE memberid = '$memberid'";
  $res = mysqli_query($db, $sql);
  $fetch = mysqli_fetch_array($res);

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
            <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
          </div>

          <div class="card shadow mb-4" >
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Messages</h6>
            </div>
            <div class="card-body">
              <?php   

            $sql = "SELECT * FROM notiftbl WHERE memberto = '$memberid' ORDER BY id DESC";
            $res = mysqli_query($db, $sql);
            
            $sqld = "SELECT * FROM memberdetailstbl WHERE memberid = '$memberid'";
            $resd = mysqli_query($db, $sqld);
            $resultsd = mysqli_fetch_array($resd);
            $fullname = ucfirst($resultsd['fname']) . ' ' . ucfirst(substr($resultsd['mname'], 0,1)) . '. ' . ucfirst($resultsd['lname']);

            if(mysqli_num_rows($res) < 1)
            {

            }
            else
            {
            ?>

              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  
            <?php

              $memberid = $_SESSION['memberid'];
              $sql2 = "SELECT notiftbl.* FROM notiftbl WHERE notiftbl.memberto = '$memberid' ORDER BY id DESC;";
              $res2 = mysqli_query($db, $sql2);
              while ($row = mysqli_fetch_array($res2))
              {
              ?>
                <tr>
                  <th><?php echo $row['date']; ?></th>
                  <th><?php echo $row['title']; ?></th>
                  <th><?php echo $row['message']; ?></th>
                  <td style="text-align: center;"> 
                    <a href="viewmessage.php?message=<?php echo $row['id']; ?>" class="btn btn-primary btn-circle btn-sm" style="margin-left: 5px;">
                    <i class="fas fa-eye"></i>
                  </td>
                </tr>
                <?php
                }
              }
              ?>        
                </tbody>
              </table>

            </div>
          </div>
        <!-- /.container-fluid -->


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
