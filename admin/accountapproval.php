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

  if(isset($_GET['approve']))
  {
    $memberid = $_GET['approve'];
    $sqld = "UPDATE memberdetailstbl SET status = 'active' WHERE memberid = '$memberid'";
    $ress = mysqli_query($db, $sqld);
    if($ress)
    {
      $dateNow = date("M-d-Y h:i:s A");
      $message = "";
      $message = "Your Account Successfully VERIFIED! You can now start your Transactions.";
      $notify = mysqli_query($db,"INSERT INTO `notiftbl` (`id`, `memberto`, `date`,`title`,`message`, `memberfrom`, `status`) VALUES (NULL, '$memberid', '$dateNow','Account Activated','$message', 'Admin', 'unread')");
      if($db->query($notify) === true)
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Account Approved!");'; 
        echo 'window.location.href = "accountapproval.php";';
        echo '</script>';
      }
    }
  }

  if(isset($_GET['disapprove']))
  {
    $memberid = $_GET['disapprove'];
    $sqld = "UPDATE memberdetailstbl SET status = 'declined' WHERE memberid = '$memberid'";
    $ress = mysqli_query($db, $sqld);
    if($ress)
    {
      $dateNow = date("M-d-Y h:i:s A");
      $message = "";
      $message = "Your Account have been Declined. Please contact the Admin for Approval!";
      $notify = mysqli_query($db,"INSERT INTO `notiftbl` (`id`, `memberfrom`, `date`,`title`,`message`, `memberto`, `status`) VALUES (NULL, '$memberid', '$dateNow','Account Declined','$message', 'Admin', 'unread')");
      if($db->query($notify) === true)
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Account Declined!");'; 
        echo 'window.location.href = "accountapproval.php";';
        echo '</script>';
      }
    }
  } 

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
          <h1 class="h3 mb-0 text-gray-800">Account Approval</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List of Accounts for Approval</h6>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-12 mb-6 mb-sm-0">
                <?php 

                  $sql = "SELECT * FROM memberdetailstbl WHERE status = 'inactive';";
                  $res = mysqli_query($db, $sql);

                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Member ID</th>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Sex</th>
                      <th>Address</th>
                      <th>Full Details</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      while ($row = mysqli_fetch_array($res)) 
                      {
                        $name = ucfirst($row['fname']) . " " . ucfirst(substr($row['mname'], 0,1)) . ". " . ucfirst($row['lname']);
                      ?>
                      <tr>
                        <td><?php echo $row['memberid']; ?></td>
                        <td><?php echo $name ?></td>
                        <td><?php echo ucfirst($row['position']); ?></td>
                        <td><?php echo $row['sex']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td style="text-align: center;"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal<?php echo $row['memberid']; ?>">View</button></td>

                        <div class="modal fade" id="exampleModal<?php echo $row['memberid']; ?>"" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Co-maker Details</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="form-group row">
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                  <img class="img-profile rounded-circle" src="../<?php echo $row['image']; ?>" style="width: 200px;">
                                </div>
                                <div class="col-sm-1 mb-1 mb-sm-0"></div>
                                <div class="col-sm-7 mb-3 mb-sm-0">
                                  <ul style="list-style: none;">
                                    <li>Member ID: <?php echo $row['memberid']; ?></li>
                                    <li>Name: <?php echo $name; ?></li>
                                    <li>Position: <?php echo ucfirst($row['position']); ?></li>
                                    <li>Balance: Php 0.00</li>
                                    <li>Sharecap: Php 0.00</li>
                                    <li>Birthdate: <?php echo $row['bdate']; ?></li>
                                    <li>Sex: <?php echo $row['sex']; ?></li>
                                    <li>E-mail: <?php echo $row['email']; ?></li>
                                    <li>Mobile Number: <?php echo $row['mobileno']; ?></li>
                                    <li>Address: <?php echo $row['address']; ?></li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                        <td style="text-align: center;"> 
                          
                          <a href="accountapproval.php?approve=<?php echo $row['memberid']; ?>" class="btn btn-success btn-circle btn-sm" onclick="return confirm('Approve Account?');">
                          <i class="fas fa-check"></i>

                          <a href="accountapproval.php?disapprove=<?php echo $row['memberid']; ?>" class="btn btn-danger btn-circle btn-sm" style="margin-left: 5px;" onclick="return confirm('Disapprove Account?');">
                          <i class="fas fa-times"></i>

                        </td>
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
