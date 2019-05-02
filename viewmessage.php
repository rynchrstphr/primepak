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

  // if($rowsres > 0)
  // {
  //   echo '<script type="text/javascript">'; 
  //   echo 'window.location.href = "viewloan.php";';
  //   echo '</script>';
  // }

  $sql = "SELECT * FROM memberdetailstbl WHERE memberid = '$memberid'";
  $res = mysqli_query($db, $sql);
  $fetch = mysqli_fetch_array($res);

?>

<?php 

if(isset($_POST['acceptRequest']))
{
  $messageId = $_POST['message'];
  $loanrequestid = $_POST['applicationid'];
  $memberid = $_POST['memberid'];
  $comakerid = $_SESSION['memberid'];

  $que = "UPDATE loanrequesttbl SET totalrequeststatus = 'admin approval' WHERE loanrequestid = '$loanrequestid'";
  if($db->query($que) === true)
  {
    $que = "SELECT * FROM loanrequesttbl WHERE loanrequestid = '$loanrequestid' AND totalrequeststatus = 'admin approval' AND memberid = '$memberid'";
    $res = mysqli_query($db, $que);
    $fetch = mysqli_fetch_array($res);

    $name = $fetch['name'];

    $comakername = $fetch['comakername'];

    $dateToday = date("M-d-Y h:i:s A");

    $message = "Good Day ! " . $name . ". " . $comakername . " approved your request for Co-Maker. Wait for the approval of the Admin and Chairman for your Request.!";

    $que = "INSERT INTO `notiftbl` (`id`, `memberfrom`, `date`,`title`,`message`,`details`, `memberto`, `status`) VALUES (NULL, '$comakerid', '$dateToday','Approved Co-Maker','$message','$loanrequestid', '$memberid', 'unread')";

    if($db->query($que) === true)
    {
      echo '<script type="text/javascript">'; 
      echo 'alert("Request Approved");'; 
      echo 'window.location.href = "viewmessage.php?message='.$messageId.'";';
      echo '</script>';
    }
  }
  }

  if(isset($_GET['cancelRequest']))
  {
    $messageId = $_POST['message'];
    $loanrequestid = $_POST['applicationid'];
    $memberid = $_POST['memberid'];
    $comakerid = $_SESSION['memberid'];

    $que = "UPDATE loanrequesttbl SET totalrequeststatus = 'declined request' WHERE loanrequestid = '$loanrequestid'";
    if($db->query($que) === true)
    {
      $que = "SELECT * FROM loanrequesttbl WHERE loanrequestid = '$loanrequestid' AND totalrequeststatus = 'declined request' AND memberid = '$memberid'";
      $res = mysqli_query($db, $que);
      $fetch = mysqli_fetch_array($res);

      $name = $fetch['name'];

      $comakername = $fetch['comakername'];

      $dateToday = date("M-d-Y h:i:s A");

      $message = "Good Day ! " . $name . ". Sorry to inform you that your request for Co-Maker have been declined! Submit and find a new co-maker.";

      $que = "INSERT INTO `notiftbl` (`id`, `memberfrom`, `date`,`title`,`message`,`details`, `memberto`, `status`) VALUES (NULL, '$comakerid', '$dateToday','Approved Co-Maker','$message','$loanrequestid', '$memberid', 'unread')";

      if($db->query($que) === true)
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Request Declined");'; 
        echo 'window.location.href = "viewmessage.php?message='.$messageId.'";';
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
            <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
            <a href="notifications.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-caret-square-left fa-sm text-white-50"></i> Go Back</a>
          </div>

          <div class="card shadow mb-4" >
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Message</h6>
            </div>
            <div class="card-body">
            <?php   

              $messageid = $_GET['message'];

              $sql = "SELECT * FROM notiftbl WHERE id = '$messageid'";
              $res = mysqli_query($db, $sql);
              $result = mysqli_fetch_array($res);

              $to = $result['memberfrom'];
              $from = $result['memberto'];
              $title = $result['title'];
              $message = $result['message'];
              $details = $result['details'];

              $sqll = "SELECT * FROM memberdetailstbl  WHERE memberid = '$to'";
              $ress = mysqli_query($db, $sqll);
              $resultt = mysqli_fetch_array($ress);

              $nameto = ucfirst($resultt['fname']) . ' ' . ucfirst(substr($resultt['mname'], 0,1)) . '. ' . ucfirst($resultt['lname']);

              $sqlll = "SELECT * FROM memberdetailstbl  WHERE memberid = '$from'";
              $resss = mysqli_query($db, $sqlll);
              $resulttt = mysqli_fetch_array($resss);

              $namefrom = ucfirst($resulttt['fname']) . ' ' . ucfirst(substr($resulttt['mname'], 0,1)) . '. ' . ucfirst($resulttt['lname']);              
            ?>


              To: <?php echo $nameto; ?>
              <br><br>
              From:  <?php echo $namefrom; ?>
              <br><br>
              Title: <?php echo $title; ?>
              <br><br>
              Message: 
              &nbsp;&nbsp;&nbsp;<?php echo $message; ?>



            </div>
          </div>

          <?php 

          if($title == 'Co-Maker')
          {
          ?>

          <div class="card shadow mb-4" >
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Loan Request Form</h6>
            </div>
            <div class="card-body">

            <?php 

            // SELECT * FROM loanrequesttbl WHERE memberid = '16-1991-2019' AND paymentstatus = 'unpaid' AND totalrequeststatus = 'comaker approval';

            $memberid = $to;

            $s = "SELECT loanrequesttbl.*, STR_TO_DATE(dateend, '%m/%d/%Y') AS dateend, CONCAT('Php ',FORMAT(loanrequesttbl.totalamount,2)) AS bal, memberdetailstbl.* FROM loanrequesttbl INNER JOIN memberdetailstbl ON loanrequesttbl.memberid = memberdetailstbl.memberid WHERE loanrequesttbl.memberid = '$memberid' AND loanrequesttbl.paymentstatus = 'unpaid' AND loanrequesttbl.totalrequeststatus = 'comaker approval' OR loanrequesttbl.totalrequeststatus = 'admin approval';";
            $r = mysqli_query($db, $s);
            $f = mysqli_fetch_array($r);
            $name = ucfirst($f['fname']) . " " . ucfirst(substr($f['mname'], 0,1)) . ". " . ucfirst($f['lname']);

            ?>

            <div class="card-body">
              <div class="form-group-control">
                <div class="form-group row">
                  <table class="table table-borderless">
                    <tbody>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Date Submitted: </td>
                        <td><?php echo $f['datesubmitted'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Application No:</td>
                        <td><?php $reqId = $f['loanrequestid']; echo $reqId; ?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Member ID:</td>
                        <td><?php echo $f['memberid'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Name: </td>
                        <td><?php echo $name;?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Loan Type:</td>
                        <td><?php echo ucfirst($f['loantype']);?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Total Loan Amount</td>
                        <td><?php echo $f['bal'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Start Date: </td>
                        <td><?php echo $f['datestart'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >End Date: </td>
                        <td><?php echo $f['dateend'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Number of Months: </td>
                        <td><?php echo $f['months'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Mode of Payment</td>
                        <td><?php echo ucfirst($f['mop']);?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Co-Maker ID: </td>
                        <td><?php echo $f['comakerid'];?></td>
                      </tr>
                      <tr style="border-top-style: none;">
                        <td style="text-align: right;" scope="col" >Co-Maker Name: </td>
                        <td><?php echo $f['comakername'];?></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="form-group row">
                  <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable">
                      <thead>
                        <th>Application Month</th>
                        <th>Due Date</th>
                        <th>Amortization</th>
                        <th>Interest</th>
                        <th>Principal</th>
                        <th>Balance</th>
                      </thead>
                      <tbody>
                      <?php 

                        $memno = $f['memberid'];
                        $reqI = $f['loanrequestid'];

                        $sq = "SELECT id, memberid, loanrequestid, appmonth, duedate, CONCAT('Php ',FORMAT(viewloantbl.amortization,2)) AS amortization, CONCAT('Php ',FORMAT(viewloantbl.principal,2)) AS principal, CONCAT('Php ',FORMAT(viewloantbl.interest,2)) AS interest, CONCAT('Php ',FORMAT(viewloantbl.balance,2)) AS balance from viewloantbl WHERE memberid = '$memno' AND loanrequestid = '$reqI'";
                        $s = mysqli_query($db,$sq); 
                        while($r = mysqli_fetch_array($s))
                        {
                        ?>
                          <tr style="border-top-style: none;">
                            <td><?php echo $r['appmonth']; ?></td>
                            <td><?php echo $r['duedate']; ?></td>
                            <td><?php echo $r['amortization']; ?></td>
                            <td><?php echo $r['interest']; ?></td>
                            <td><?php echo $r['principal']; ?></td>
                            <td><?php echo $r['balance']; ?></td>
                          </tr>
                        <?php
                        }
                      ?>
                      </tbody>
                    </table>  
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <br>
            <?php 

                if($f['totalrequeststatus'] == 'comaker approval')
                {
                ?>
                  <form class="user" action="viewmessage.php?message=<?php echo $_GET['message']; ?>" method="post">
                    <button type="submit" class="btn btn-danger btn-sm" name="declineRequest" onclick="return confirm('Are you sure?');" style="float: right; margin-top: -20px; margin-left: 5px;">Decline Request</button>
                    <button type="submit" class="btn btn-success btn-sm" name="acceptRequest" style="float: right; margin-top: -20px;">Accept Request</button>
                    <input type="text" name="message" value="<?php echo $_GET['message']; ?>" hidden>
                    <input type="text" name="memberid" value="<?php echo $f['memberid']; ?>" hidden>
                    <input type="text" name="applicationid" value="<?php echo $f['loanrequestid']; ?>" hidden>
                  </form>
                <?php
                }

              ?>

            </div>
          </div>

          <?php
          }

          ?>
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
