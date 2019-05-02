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

  if(isset($_GET['id']))
  {
    $id = $_GET['id'];
    $que = "DELETE FROM loantypetbl WHERE id = '$id'";
      if($db->query($que) === true)
      {   
          echo '<script type="text/javascript">'; 
          echo 'alert("Loan Type Deleted Saved");'; 
          echo 'window.location.href = "loantypes.php";';
          echo '</script>';
      }    
      else
      {
        echo "ERROR: Could not able to execute $sql. " . $db->error;   
      }
  }

  if(isset($_GET['deactivate']))
  {
    $memberid = $_GET['deactivate'];
    $sqld = "UPDATE memberdetailstbl SET status = 'inactive' WHERE memberid = '$memberid'";
    $ress = mysqli_query($db, $sqld);
    if($ress)
    {
      $dateNow = date("M-d-Y h:i:s A");
      $message = "";
      $message = "Your Account have been Deactivated. Please contact the Admin for Approval!";
      $notify = mysqli_query($db,"INSERT INTO `notiftbl` (`id`, `memberto`, `date`,`title`,`message`, `memberfrom`, `status`) VALUES (NULL, '$memberid', '$dateNow','Account Deactivated','$message', 'Admin', 'unread')");
      if($db->query($notify) === true)
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Account Declined!");'; 
        echo 'window.location.href = "listofmembers.php";';
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
          <h1 class="h3 mb-0 text-gray-800">List of Loan Types</h1>
          <td style="text-align: center;"><a href="addloantype.php" class="btn btn-primary btn-sm">Add Loan Type</a></td>
        </div>

        <div class="card shadow mb-4">

            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Loan Types</h6>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-12 mb-6 mb-sm-0">
                <?php 

                  $sql = "SELECT * FROM loantypetbl ";
                  $res = mysqli_query($db, $sql);

                ?>
                
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>Loan Type</th>
                      <th>Range 1</th>
                      <th>Range 2</th>
                      <th>Loan Range</th>
                      <th>Max Months</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      while ($row = mysqli_fetch_array($res)) 
                      {
                      ?>
                      <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo ucfirst($row['loantype']); ?></td>
                        <td><?php echo $row['loanrange1']; ?></td>
                        <td><?php echo $row['loanrange2']; ?></td>
                        <td><?php echo $row['loanrange']; ?></td>
                        <td><?php echo $row['months']; ?></td>
                        <td style="text-align: center;"><a href="updateloantype.php?id=<?php echo $row['id'] ?> ?>" class="btn btn-primary btn-sm">Update</a>
                        <a href="loantypes.php?id=<?php echo $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a></td>
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
