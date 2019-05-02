
<?php 

  $page = "Loan Request";
  $active = "request";
  include 'includes/header.php';
  include 'core/db.php';
  session_start();
  if(!isset($_SESSION['admin']))
  {
    header("Location: login.php");
  }

  $memberid = $_SESSION['admin'];

?>

<?php 

  if(isset($_POST['save']))
  {
   	$loantype = $_POST['loantype'];
		$range1 = $_POST['range1'];
		$range2 = $_POST['range2'];
		$loanrange = $_POST['loanrange'];
		$months = $_POST['months'];

    

    $que = "INSERT INTO `loantypetbl` (`id`, `loantype`, `loanrange1`, `loanrange2`, `loanrange`, `months`) VALUES (NULL, '$loantype', '$range1', '$range2', '$loanrange', '$months')";
    if($db->query($que) === true)
    {   
        echo '<script type="text/javascript">'; 
        echo 'alert("Loan Type Saved");'; 
        echo 'window.location.href = "loantypes.php";';
        echo '</script>';
    }    
    else
    {
      echo "ERROR: Could not able to execute $sql. " . $db->error;   
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

        	 <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Update Account</h1>
            <a href="index.php" onclick="return confirm('Are you sure?');" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-caret-square-left fa-sm text-white-50"></i> Back</a>
          </div>

          <?php 

            // $query = "SELECT * FROM memberdetailstbl WHERE memberid = '$memberid';";
            // $que = mysqli_query($db, $query);
            // $result = mysqli_fetch_array($que);

            // $position = $result['position'];
            // $fname = $result['fname'];
            // $lname = $result['lname'];
            // $mname = $result['mname'];
            // $email = $result['email'];
            // $sex = $result['sex'];
            // $bdate = $result['bdate'];
            // $mobileno = $result['mobileno'];
            // $address = $result['address'];
            // // $image = $result['image'];

          ?>

          <div class="card shadow mb-4" >
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Loan Type</h6>
            </div>
            <div class="card-body" style="width: 60%; margin: auto;">
              <br>
              <div class="form-group row">
                <div class="col-sm-12 mb-6 mb-sm-0">
                <form class="user" action="addloantype.php" method="post" >
                <div class="form-group row">
                  <label for="">Loan Type</label>
                     <input type="text" class="form-control form-control-user" id="loantype" name="loantype" placeholder="Loan Type" required>
                </div>
                <div class="form-group row">
                  <label for="">Range 1</label>
                     <input type="text" class="form-control form-control-user" id="range1" name="range1" placeholder="Range 1" required>
                </div>
                <div class="form-group row">
                  <label for="">Range 2</label>
                     <input type="text" class="form-control form-control-user" id="range2" name="range2" placeholder="Range 2" required>
                </div>
                <div class="form-group row">
                  <label for="">Loan Range</label>
                     <input type="text" class="form-control form-control-user" id="loanrange" name="loanrange" placeholder="Loan Range" required value="member, employee, member-employee">
                </div>
                <div class="form-group row">
                  <label for="">Months</label>
                     <input type="text" class="form-control form-control-user" id="months" name="months" placeholder="Months" required>
                </div>
                <button class="btn btn-sm btn-success" type="submit" name="save">Save</button>
              </form>
            </div>
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




