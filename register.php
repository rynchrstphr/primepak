<?php 

  $page = "Register | Primepak Multipurpose Cooperative";
  include 'includes/header.php';
  include 'core/db.php';
  session_start();
  
  $getAI = "select AUTO_INCREMENT as 'AI' from information_schema.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = 'memberdetailstbl';";

  $que = $db->query($getAI);
  $getAIRes = $que->fetch_array();
  $getAI = $getAIRes['AI'];

  $coopYear = "1991";

  $yearToday = date("Y");

  $memberid = $getAI . "-" . $coopYear . "-" . $yearToday;
  // echo "<script>alert('$memberid');</script>";

 ?>

 <?php 

 if(isset($_POST['register']))
 {
    // memberdetails
    $memid = mysqli_real_escape_string($db,$memberid);
    $fname = mysqli_real_escape_string($db,$_POST['fname']);
    $lname = mysqli_real_escape_string($db,$_POST['lname']);
    $mname = mysqli_real_escape_string($db,$_POST['mname']);
    $bdate = mysqli_real_escape_string($db,$_POST['bdate']);
    $sex = mysqli_real_escape_string($db,$_POST['sex']);
    $address = mysqli_real_escape_string($db,$_POST['address']);
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $mobileno = mysqli_real_escape_string($db,$_POST['mobileno']);
    $password1 = mysqli_real_escape_string($db,$_POST['password1']);
    $pass = md5($password1);
    $password2 = mysqli_real_escape_string($db,$_POST['password2']);
    $status = 'inactive';
    $regdate = date('Y-m-d');
    $position = mysqli_real_escape_string($db,$_POST['position']);
    if($position == "employee")
    {
      $sharecap = "-";
    }
    else
    {
      $sharecap = "0";
    }
    $image = 'img/defaultprofile.png';

    //memberloandetails
  
    $balance = "0";
    $applicationid = '-';
    $datetoday = date('Y-m-d');
    $currdeadline = '-';
    $loanstatus = '-';

    // check if password = confirm passwrd

    if($password2 == $password1)
    {
      $query1 = "INSERT INTO `memberdetailstbl` (`id`, `memberid`, `fname`, `lname`, `mname`, `bdate`, `sex`, `address`, `email`, `mobileno`, `password`, `status`, `regdate`, `position`,`sharecap`, `image`) VALUES (NULL, '$memid', '$fname', '$lname', '$mname', '$bdate', '$sex', '$address', '$email', '$mobileno', '$pass', '$status', '$regdate', '$position','$sharecap', '$image');";
      $query2 = "INSERT INTO `memberloandetailstbl` (`id`, `memberid`, `balance`, `applicationid`, `datetoday`, `currdeadline`, `status`) VALUES (NULL, '$memid', '$balance', '$applicationid', '$datetoday', '$currdeadline', '$loanstatus');";
      if($db->query($query1) === true)
      {
        if($db->query($query2) === true)
        {
          echo '<script type="text/javascript">'; 
          echo 'alert("Successfuly Registered");'; 
          echo 'window.location.href = "register.php";';
          echo '</script>';
        }
        else
        {
          echo "ERROR: Could not able to execute $sql. " . $mysqli->error;   
        }
      }
      else
      {
        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
      }
    }
    else
    {
      echo "<script>alert('Password don't match');</script>";
    }

 }

 ?>

<body style="background-color: #E57373;">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block" style="background-image: url('img/logo.png'); background-position: center; 
background-repeat: no-repeat; 
background-size: cover;"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <form class="user" action="register.php" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <!-- <label for="memberid"></label> -->
                    <input type="text" class="form-control form-control-user" id="memid" name="memid" value="<?php echo $memberid; ?>" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <div style="margin-left: 20px;" class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="member" name="position" class="custom-control-input" value="member" required="">
                    <label class="custom-control-label" for="member">Member</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="employee" name="position" class="custom-control-input" value="employee">
                    <label class="custom-control-label" for="employee">Employee</label>
                  </div>
                  <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="employee-member" name="position" class="custom-control-input" value="employee-member">
                    <label class="custom-control-label" for="employee-member">Member-Employee</label>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-4 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="fname" name="fname" placeholder="First Name" required>
                  </div>
                  <div class="col-sm-4 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="lname" name="lname" placeholder="Last Name" required>
                  </div>
                  <div class="col-sm-4 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="mname" name="mname" placeholder="Middle Name" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Email Address" required>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0" style="margin-top: 10px;">
                    <div style="margin-left: 20px;" class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="male" name="sex" class="custom-control-input" value="Male" required>
                        <label class="custom-control-label" for="male">Male</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="female" name="sex" class="custom-control-input" value="Female">
                        <label class="custom-control-label" for="female">Female</label>
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input class="form-control form-control-user" id="bdate" name="bdate" placeholder="Birthdate" class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="mobileno" name="mobileno" placeholder="Mobile Number" required>
                  </div>
                </div>
                 <div class="form-group row">
                  <div class="col-sm-12 mb-6 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="address" name="address" placeholder="Home Address" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Confirm Password" required>
                  </div>
                </div>
                <button class="btn btn-primary btn-user btn-block" type="submit" name="register">
                  Register Account
                </button>
                <hr>
                <!-- <a href="index.html" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="index.html" class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a> -->
              </form>
              <!-- <div class="text-center">
                <a class="small" href="forgot-password.html">Forgot Password?</a>
              </div> -->
              <div class="text-center text-small">
                <span class="small" style="color: grey;">Already have an account?</span><a class="small" href="login.php"> Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <?php 

    include 'includes/script.php';

  ?>

</body>

</html>

