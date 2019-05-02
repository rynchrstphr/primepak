<?php 

  $page = "Loan Request";
  $active = "request";
  include 'includes/header.php';
  include 'core/db.php';
  session_start();
  if(!isset($_SESSION['memberid']))
  {
    header("Location: login.php");
  }

  $memberid = $_SESSION['memberid'];

  $qued = "SELECT * FROM loanrequesttbl WHERE memberid = '$memberid' AND totalrequeststatus != '' AND paymentstatus != 'paid';";
  $es = mysqli_query($db, $qued);
  $rowsres = mysqli_fetch_row($es);

  if($rowsres > 0)
  {
    echo '<script type="text/javascript">'; 
    echo 'window.location.href = "viewloan.php";';
    echo '</script>';
  }

  $sql = "SELECT * FROM memberdetailstbl WHERE memberid = '$memberid'";
  $res = mysqli_query($db, $sql);
  $fetch = mysqli_fetch_array($res);

?>

<?php 

  if(isset($_POST['submitRequest']))
  {
    $memberid = mysqli_real_escape_string($db,$_SESSION['memberid']);
    $loanrequestid = $fetch['id'] . '-' . date('m') . date('d') . date('Y');
    $memname = ucfirst($fetch['fname']) . " " . ucfirst(substr($fetch['mname'], 0,1)) . ". " . ucfirst($fetch['lname']);
    $name = mysqli_real_escape_string($db,$memname);
    $loantype = mysqli_real_escape_string($db,$_POST['loantype']);
    $totalamount = mysqli_real_escape_string($db,$_POST['amount1']);
    $datestart = mysqli_real_escape_string($db,$_POST['dateStart']);
    $dateend = $_POST['dateEnd'];
    $months = mysqli_real_escape_string($db,$_POST['months']);
    $mop = mysqli_real_escape_string($db,$_POST['paymentMethod']);
    $comakerid = mysqli_real_escape_string($db,$_POST['comakerid']);
    $comakername = mysqli_real_escape_string($db,$_POST['comakername']);
    $datesubmitted = date('Y-m-d');
    $paymentstatus = 'unpaid';

    // $que = "INSERT INTO `loanrequesttbl` (`id`, `loanrequestid`, `memberid`, `name`, `loantype`, `totalamount`, `datestart`, `dateend`, `months`, `mop`, `comakerid`, `comakername`, `datesubmitted`, `totalpaymentstatus`, `requeststatus`) VALUES (NULL, '$memberid','$loanrequestid', '$name', '$loantype', '$totalamount', '$datestart', '$dateend', '$months', '$mop', '$comakerid', '$comakername', '$datesubmitted', '$totalpaymentstatus', 'comaker approval')";

    $que = "INSERT INTO `loanrequesttbl` (`id`, `loanrequestid`, `memberid`, `name`, `loantype`, `totalamount`, `datestart`, `dateend`, `months`, `mop`, `comakerid`, `comakername`, `datesubmitted`, `paymentstatus`, `totalrequeststatus`) VALUES (NULL, '$loanrequestid', '$memberid', '$memname', '$loantype', '$totalamount', '$datestart', '$dateend', '$months', '$mop', '$comakerid', '$comakername', '$datesubmitted', '$paymentstatus', '-')";
    if($db->query($que) === true)
    {
        $SQLgetDateRange = "SELECT *, DATE_FORMAT(datestart, '%Y-%m-%d') AS 'STARTING DATE', DATE_FORMAT(STR_TO_DATE(dateend, '%Y/%m/%d'), '%Y-%m-%d') AS 'ENDING DATE' from loanrequesttbl WHERE memberid = '$memberid' AND paymentstatus = 'unpaid';";
        $exec = mysqli_query($db, $SQLgetDateRange);
        $rangeArray = mysqli_fetch_array($exec);

        $memberid = $rangeArray['memberid'];
        $loanrequestid = $rangeArray['loanrequestid'];

        $today = $rangeArray['STARTING DATE']; // Or can put $today = date ("Y-m-d");
        $fiveDays = date ("d/m/Y", strtotime ($today ."+30 days"));

        $datas = array();

        $amount = $rangeArray['totalamount'];
        $amount = $amount/$months;
        $principal = round($amount,2);

        $percentInterest = 0.02;

        $balance = $rangeArray['totalamount'];

        $totalInterest  = $balance * $percentInterest;

        $amortization = $totalInterest + $principal;                               

        for($i = 0; $i < $rangeArray['months']; $i++)
        {
          $myDated = DateTime::createFromFormat('d/m/Y', $fiveDays);
          $t = $myDated->format('Y-m-d');
          $monForm = date("F",strtotime($t));
          // array_push($datas, $monForm, $fiveDays,$amortization, $principal, $totalInterest, $balance);

          $zxc = "INSERT INTO `viewloantbl` (`id`, `memberid`, `loanrequestid`, `appmonth`, `duedate`, `amortization`, `principal`, `interest`, `balance`) VALUES (NULL, '$memberid', '$loanrequestid', '$monForm', '$fiveDays', '$amortization', '$principal', '$totalInterest', '$balance')";
          mysqli_query($db,$zxc);
          $myDateTime = DateTime::createFromFormat('d/m/Y', $fiveDays);
          $today = $myDateTime->format('Y-m-d');
          $fiveDays = date ("d/m/Y", strtotime ($today ."+30 days"));
          $balance = $balance - $principal;
          $totalInterest  = $balance * $percentInterest;
          $totalInterest = round($totalInterest, 2);
          $amortization = $totalInterest + $principal; 
        }
        echo '<script type="text/javascript">'; 
        echo 'alert("Loan Request Submitted");'; 
        echo 'window.location.href = "viewloan.php";';
        echo '</script>';
    }    
    else
    {
      echo "ERROR: Could not able to execute $sql. " . $db->error;   
    }
    $db->close();


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
            <h1 class="h3 mb-0 text-gray-800">Loan Request</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
          </div>
          <div class="card shadow mb-4" style="width: 90%; margin:auto;">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Loan Application Form</h6>
            </div>
            <div class="card-body">
              <form class="user" action="<?php echo $requestLink; ?>" method="post">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="memberid">Member ID</label>
                    <input type="text" class="form-control form-control-user" id="memberid" name="memberid" value="<?php echo $_SESSION['memberid']; ?>" disabled>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="applicationdate">Date</label>
                    <input type="text" class="form-control form-control-user" id="applicationdate" name="applicationdate" value="<?php echo date('Y-m-d'); ?>" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12 mb-6 mb-sm-0">
                    <label for="name">Name</label>
                    <?php $name = ucfirst($fetch['fname']) . " " . ucfirst(substr($fetch['mname'], 0,1)) . ". " . ucfirst($fetch['lname']); ?>
                    <input type="text" class="form-control form-control-user" id="name" name="name" value="<?php echo $name; ?>" disabled>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12 mb-6 mb-sm-0">
                    <label for="loantype">Loan Type</label>
                    <?php 

                      if($fetch['position'] == 'employee')
                      {
                        $que = "SELECT *, CONCAT('Php', FORMAT(loanrange1, 2)) AS 'r1', CONCAT('Php', FORMAT(loanrange2, 2)) AS 'r2' FROM loantypetbl WHERE loanrange != 'member, member-employee' ;";
                      }
                      else
                      {
                        $que = "SELECT *, CONCAT('Php', FORMAT(loanrange1, 2)) AS 'r1', CONCAT('Php', FORMAT(loanrange2, 2)) AS 'r2' FROM loantypetbl;";
                      }

                      $s = mysqli_query($db,$que);  

                    ?>
                    <select class="form-control animated--grow-in" id="loantype" name="loantype" style="border-radius: 10rem; height: 50px;">
                      <option value="1" <?php if(!isset($_POST['loantype'])){echo 'selected';} ?>>-Select Loan Type-</option>
                      <?php 
                        while($result = mysqli_fetch_array($s))
                        {
                      ?>
                          <option <?php if(isset($_POST['loantype'])){if($_POST['loantype'] == $result['loantype']){echo 'selected';}} ?> value="<?php echo $result['loantype']; ?>"><?php echo ucfirst($result['loantype']) ." (".$result['r1']." - ".$result['r2'].") (Max: ".$result['months']."Months)"; ?></option>
                      <?php
                        }
                      ?>
                    </select>

                    <?php 

                      $qe = "SELECT * FROM loantypetbl;";
                      $su = mysqli_query($db,$qe);    

                      while($resultd = mysqli_fetch_array($su))
                      {
                      ?>
                        <input type="text" id="<?php echo $resultd['loantype']; ?>" name="<?php echo $resultd['loantype']; ?>" value="<?php echo $resultd['loanrange1']; ?>, <?php echo $resultd['loanrange2']; ?>, <?php echo $resultd['months']; ?>" hidden>

                      <?php
                      }
                    ?>

                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="amount1">Amount</label>
                    <input type="number" class="form-control form-control-user" id="amount1" name="amount1" onkeyup="validateAmountRange();" value="<?php if(isset($_POST['amount1'])){echo $_POST['amount1'];} ?>" required>
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="months">Number Of Months</label>
                    <input type="number" class="form-control form-control-user" id="months" name="months" onkeyup="validateMonth();" onfocusout="validateNumberOfMonths()" value="<?php if(isset($_POST['months'])){echo $_POST['months'];} ?>" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="dateStart">From</label>
                    <input type="date" class="form-control form-control-user" id="dateStart" name="dateStart" value="<?php if(isset($_POST['submitRequest'])){if(isset($_POST['dateStart'])){echo $_POST['dateStart'];}} ?>" required >
                  </div>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <label for="dateEnd">To</label>
                    <input type="text" class="form-control form-control-user" id="dateEndView" name="dateEndView" disabled>
                    <input type="text" class="form-control form-control-user" id="dateEnd" name="dateEnd" hidden>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12 mb-6 mb-sm-0" style="margin-top: 10px;">
                    <label for="">Payment Method</label>
                    <br>
                    <div style="margin-left: 10px;" class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="overTheCounter" name="paymentMethod" class="custom-control-input" value="Over-The-Counter" >
                        <label class="custom-control-label" for="overTheCounter" <?php if(isset($_POST['paymentMethod'])){if($_POST['paymentMethod']=='Over-The-Counter'){echo 'checked';}} ?>>Over-The-Counter</label>
                      </div>
                      <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="salaryDeduction" name="paymentMethod" class="custom-control-input" value="Salary Deduction" <?php if(isset($_POST['paymentMethod'])){if($_POST['paymentMethod']=='Salary Deduction'){echo 'checked';}} ?>>
                        <label class="custom-control-label" for="salaryDeduction">Salary Deduction</label>
                      </div>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12 mb-6 mb-sm-0">
                    <?php 
                      $comaker = mysqli_query($db,"SELECT memberdetailstbl.*, memberloandetailstbl.*, CONCAT('Php ', (ROUND(memberloandetailstbl.balance, 2))) AS bal, CONCAT('Php ', (ROUND(memberdetailstbl.sharecap, 2))) AS cap from memberdetailstbl inner join memberloandetailstbl ON memberdetailstbl.memberid = memberloandetailstbl.memberid WHERE memberdetailstbl.memberid != '$memberid' AND position != 'employee'");
                    ?>
                    <label for="">Co-Maker</label>
                    <input type="text" class="form-control form-control-user" id="comaker" name="comaker" placeholder="Comaker" value="<?php if(isset($_POST['comaker'])){echo $_POST['comaker'];} ?>" disabled required>
                    <input type="text" class="form-control form-control-user" id="comakerid" name="comakerid"  value="<?php if(isset($_POST['comakerid'])){echo $_POST['comakerid'];} ?>" hidden required>
                    <input type="text" class="form-control form-control-user" id="comakername" name="comakername"  value="<?php if(isset($_POST['comakername'])){echo $_POST['comakername'];} ?>" hidden required >
                    <br>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-12 mb-10 mb-sm-0">
                    <label for="dataTable">Search for Co-Maker</label>
                    <table class="table table-bordered table-hover table-sm comakers" id="dataTable" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Member Id</th>
                          <th>Name</th>
                          <th>Co-maker Details</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        while ($row=mysqli_fetch_array($comaker)) 
                        {

                          ?>
                          <tr>
                            <td value="<?php $row['memberid']; ?>"><?php echo $row['memberid']; ?></td>
                            <td value="<?php $row['memberid']; ?>"><?php $n = ucfirst($row['fname']) . ' ' . ucfirst(substr($fetch['mname'], 0,1)) . '. ' . ucfirst($row['lname']); echo $n; ?></td>
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
                                      <img class="img-profile rounded-circle" src="<?php echo $fetch['image']; ?>" style="width: 200px;">
                                    </div>
                                    <div class="col-sm-1 mb-1 mb-sm-0"></div>
                                    <div class="col-sm-7 mb-3 mb-sm-0">
                                      <ul style="list-style: none;">
                                        <li>Member ID: <?php echo $row['memberid']; ?></li>
                                        <li>Name: <?php echo $n; ?></li>
                                        <li>Position: <?php echo $row['position']; ?></li>
                                        <li>Balance: <?php echo $row['bal']; ?></li>
                                        <li>Sharecap: <?php echo $row['sharecap']; ?></li>
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

                          </div>
                          </tr>
                          <?php
                          
                        ?>
                        <?php 
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <hr>
                <div class="form-group row" style="float: right;">
                  <div class="col-sm-12 mb-10 mb-sm-0">
                    <button class="btn btn-success btn-icon-split" type="submit" name="submitRequest">
                      <span class="icon text-white-50">
                        <i class="fas fa-check"></i>
                      </span>
                      <span class="text">Submit Request</span>
                    </button>
                  </div>
                </div>
              </form>
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
