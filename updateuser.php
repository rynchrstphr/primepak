<?php 

  $page = "Update User | Primepak Multipurpose Cooperative";
  $active = "index";
  include 'includes/header.php';
  include 'core/db.php';
  session_start();
  if(!isset($_SESSION['memberid']))
  {
    header("Location: login.php");
  }

?>


<?php 

if(isset($_POST['updateuser']))
{

  $memberid = $_SESSION['memberid'];
  $position = mysqli_real_escape_string($db,$_POST['position']);
  $fname = mysqli_real_escape_string($db,$_POST['fname']);
  $lname = mysqli_real_escape_string($db,$_POST['lname']);
  $mname = mysqli_real_escape_string($db,$_POST['mname']);
  $email = mysqli_real_escape_string($db,$_POST['email']);
  $sex = mysqli_real_escape_string($db,$_POST['sex']);
  $bdate = mysqli_real_escape_string($db,$_POST['bdate']);
  $mobileno = mysqli_real_escape_string($db,$_POST['mobileno']);
  $address = mysqli_real_escape_string($db,$_POST['address']);
  if(isset($_POST['password1']))
  {
    $password1 = mysqli_real_escape_string($db,$_POST['password1']);
  }
  $password2 = mysqli_real_escape_string($db,$_POST['password2']);
  $status = "inactive";
  $dateToday = date("Y-m-d");
  $sharecap = "0";

  $password1 = md5($password1);
  $password2 = md5($password2);

  // if(isset($_POST['image']))
  // {
  //   $fileName = $_POST['image'];
  //   $filepath = "img/profiles/" . basename($fileUpload[$fileName]);
  // }
  // else
  // {
  //   $filepath = $_POST['image'];
  // }

  if($password1 == $password2)
  {
    $query = "UPDATE `memberdetailstbl` SET `fname`='$fname',`lname`='$lname',`mname`='$mname',`bdate`='$bdate',`sex`='$sex',`address`='$address',`email`='$email',`mobileno`='$mobileno',`password`='$password1',`status`='$status',`regdate`=$dateToday,`position`='$position',`sharecap`='$sharecap',`image`= '$filepath' WHERE memberid = '$memberid'";
    if($db->query($query) === true)
    {
      // echo '<script type="text/javascript">'; 
      // echo 'alert("Update Successfully");'; 
      // echo 'window.location.href = "index.php";';
      // echo '</script>';
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
            <h1 class="h3 mb-0 text-gray-800">Update Account</h1>
            <a href="index.php" onclick="return confirm('Are you sure?');" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-caret-square-left fa-sm text-white-50"></i> Back</a>
          </div>

          <?php 

            if(isset($_GET['memberid']))
            {
              $memberid = $_GET['memberid'];
            }
            else
            {
              header("Location: index.php");
            }

            $query = "SELECT * FROM memberdetailstbl WHERE memberid = '$memberid';";
            $que = mysqli_query($db, $query);
            $result = mysqli_fetch_array($que);

            $position = $result['position'];
            $fname = $result['fname'];
            $lname = $result['lname'];
            $mname = $result['mname'];
            $email = $result['email'];
            $sex = $result['sex'];
            $bdate = $result['bdate'];
            $mobileno = $result['mobileno'];
            $address = $result['address'];
            // $image = $result['image'];

          ?>

          <div class="card shadow mb-4" >
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Basic Information</h6>
            </div>
            <div class="card-body" style="width: 60%; margin: auto;">
              <br>
              <div class="form-group row">
                <div class="col-sm-12 mb-6 mb-sm-0">
                <form class="user" action="updateuser.php?memberid=<?php echo $_GET['memberid']; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <!-- <label for="memberid"></label> -->
                    <input type="text" class="form-control form-control-user" id="memid" name="memid" value="<?php echo $memberid; ?>" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <div style="margin-left: 20px;" class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="member" name="position" class="custom-control-input" value="member" required="" <?php if($position == "member"){echo "checked";} ?>>
                    <label class="custom-control-label" for="member">Member</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="employee" name="position" class="custom-control-input" value="employee" <?php if($position == "employee"){echo "checked";} ?>>
                    <label class="custom-control-label" for="employee">Employee</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="employee-member" name="position" class="custom-control-input" value="employee-member" <?php if($position == "employee-member"){echo "checked";} ?>>
                    <label class="custom-control-label" for="employee-member">Member-Employee</label>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-4 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="fname" name="fname" placeholder="First Name" required value="<?php echo $fname; ?>">
                  </div>
                  <div class="col-sm-4 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="lname" name="lname" placeholder="Last Name" required value="<?php echo $lname; ?>">
                  </div>
                  <div class="col-sm-4 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="mname" name="mname" placeholder="Middle Name" required value="<?php echo $mname; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email Address" required value="<?php echo $email; ?>">
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0" style="margin-top: 10px;">
                    <div style="margin-left: 20px;" class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="male" name="sex" class="custom-control-input" value="Male" required <?php if($sex == "Male"){echo "checked";} ?>>
                        <label class="custom-control-label" for="male">Male</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="female" name="sex" class="custom-control-input" value="Female" <?php if($sex == "Female"){echo "checked";} ?>>
                        <label class="custom-control-label" for="female">Female</label>
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input class="form-control form-control-user" id="bdate" name="bdate" placeholder="Birthdate" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" value="<?php echo $bdate; ?>">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="mobileno" name="mobileno" placeholder="Mobile Number" required value="<?php echo $mobileno; ?>">
                  </div>
                </div>
                 <div class="form-group row">
                  <div class="col-sm-12 mb-6 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="address" name="address" placeholder="Home Address" required value="<?php echo $address; ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Confirm Password">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="exampleInputFile">Edit Profile Picture</label>
                  <input type="file" id="exampleInputFile3" name="image" value="<?php echo $image; ?>">
                </div> -->
                
                <hr>
                <button class="btn btn-primary btn-user btn-block" type="submit" name="updateuser">
                  Update Account Details
                </button>
                <br>
                <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a> -->
              </form>

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
