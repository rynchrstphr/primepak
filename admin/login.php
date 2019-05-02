<?php 

  $page = "Login | Primepak Multipurpose Cooperative";
  include 'includes/header.php';
  include 'core/db.php';
  session_start();
  if(isset($_SESSION['admin']))
  {
    header("Location: index.php");
  }

?>

<?php 

  if (isset($_POST['login'])) 
  {
    
    $email = mysqli_real_escape_string($db,$_POST['email']);
    $password = mysqli_real_escape_string($db,$_POST['password']);

    $password = md5($password);

    $query = "SELECT * from dashboardlogintbl WHERE username = '".$email."' AND password = '".$password."';";
    $select = mysqli_query($db, $query);
    $fetch = mysqli_fetch_array($select);
    $row = mysqli_num_rows($select);
    if ($row == 1)  
    {
      $memberno = $fetch['id'];
      $_SESSION['admin'] = $memberno;
      echo '<script type="text/javascript">'; 
      echo 'alert("Login Success");'; 
      echo 'window.location.href = "index.php";';
      echo '</script>';
    }
    elseif($row < 1)
    {
      echo"<script>alert('Invalid Login Combination')</script>";
    }
    else
    {
      echo"<script>alert('Account Not Found')</script>";
    }

  }
?>

<body style="background-color: #E57373;">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block" style="background-image: url('../img/logo.png'); background-position: center; 
background-repeat: no-repeat; 
background-size: cover;"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Primepak Multipurpose Cooperative - Admin</h1>
                  </div>
                  <form class="user" action="login.php" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                    </div>
                    <!-- <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div> -->
                    <button class="btn btn-primary btn-user btn-block" type="submit" name="login">
                      Login
                    </button>
                    <hr>
                  </form>
                  <!-- <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div> -->
                  <!-- <div class="text-center">
                    <span class="small" style="color: grey;">Don't have an account ? </span><a class="small" href="register.php">Create an Account!</a>
                  </div> -->
                </div>
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
