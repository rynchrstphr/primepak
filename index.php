<?php 

  $page = "Primepak Multipurpose Cooperative";
  $active = "index";
  include 'includes/header.php';
  include 'core/db.php';
  session_start();
  if(!isset($_SESSION['memberid']))
  {
    header("Location: login.php");
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
            <h1 class="h3 mb-0 text-gray-800">Account</h1>
            <a href="updateuser.php?memberid=<?php echo $memberid ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-pen-alt fa-sm text-white-50"></i> Update Information</a>
          </div>

          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <div class="col-sm-5 mb-4 mb-sm-0">
                  <img class="img-profile rounded-circle mx-auto d-block" src="<?php echo $fetch['image']; ?>" style="width: 150px;">
                  <hr>
                  <?php 

                    $memberid = $_SESSION['memberid'];

                    $sql = "SELECT memberdetailstbl.*, memberloandetailstbl.*, CONCAT('Php ', FORMAT(memberloandetailstbl.balance,2)) AS bal, memberloandetailstbl.currdeadline as deadline, CONCAT('Php ', (ROUND(memberdetailstbl.sharecap, 2))) AS cap from memberdetailstbl inner join memberloandetailstbl ON memberdetailstbl.memberid = memberloandetailstbl.memberid WHERE memberdetailstbl.memberid = '$memberid';";
                    $res = mysqli_query($db, $sql);
                    $fetch = mysqli_fetch_array($res);

                    $lqs = "select viewloantbl.*, memberloandetailstbl.* from viewloantbl inner join memberloandetailstbl on viewloantbl.memberid = memberloandetailstbl.memberid WHERE viewloantbl.paymentstatus = 'unpaid' and viewloantbl.memberid = '$memberid';";
                    $ser = mysqli_query($db, $lqs);
                    $fe = mysqli_fetch_array($ser);

                    $name = ucfirst($fetch['fname']) . " " . ucfirst(substr($fetch['mname'], 0,1)) . ". " . ucfirst($fetch['lname']);
                    $place = $fetch['memberid'];

                  ?>
                  <table class="table table-borderless">
                    <tbody>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >Member ID:</td>
                        <td><?php echo $fetch['memberid'];?></td>
                      </tr>
                      <tr>
                        <td width="150" style="text-align: right;" scope="col">Balance:</td>
                        <td><?php echo $fetch['bal'];?></td>
                      </tr>
                      <tr>
                        <td width="150" style="text-align: right;" scope="col">Current Deadline:</td>
                        <td><?php echo $fetch['currdeadline'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >Position:</td>
                        <td><?php echo ucfirst($fetch['position']);?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >Share Capital:</td>
                        <td><?php echo ucfirst($fetch['cap']);?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >Name: </td>
                        <td><?php echo $name;?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >Birthdate: </td>
                        <td><?php echo $fetch['bdate'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >Sex: </td>
                        <td><?php echo ucfirst($fetch['sex']);?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >E-mail: </td>
                        <td><?php echo $fetch['email'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >Mobile Number: </td>
                        <td><?php echo $fetch['mobileno'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td width="150" style="text-align: right;" scope="col" >Address: </td>
                        <td><?php echo $fetch['address'];?></td>
                      </tr>
                    </tbody>
                  </table>
                </div> 
              </div>                
            </div>
          </div>

        <!-- /.container-fluid -->

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
