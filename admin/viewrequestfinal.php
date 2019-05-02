<?php 

	$page = "View Loan Request";
	$active = "request";
	include 'includes/header.php';
	include 'core/db.php';
	session_start();
	if(!isset($_SESSION['admin']))
	{
		header("Location: login.php");
	}

	$memberid = $_SESSION['admin'];

	$sqld = "SELECT * from dashboardlogintbl WHERE id = '$memberid'";
	$ress = mysqli_query($db, $sqld);
  $fetch = mysqli_fetch_array($ress);

	$loanrequestid ="";
	$memberid = "";

	if(isset($_GET['applicationno']))
	{
		$loanrequestid = $_GET['applicationno'];
		$memberid = $_GET['memberid'];
	}
	else
	{
		header("Location: loanrequest.php");
	}

	$qued = "SELECT * FROM loanrequesttbl WHERE loanrequestid = '$loanrequestid'";
	$u = "SELECT * FROM memberdetailstbl WHERE memberid = '$memberid'";
	$z = mysqli_query($db, $u);
	$x = mysqli_fetch_array($z);
	$es = mysqli_query($db, $qued);
	$s = mysqli_fetch_array($es);
	$rowsres = mysqli_fetch_row($es);

	$mainStatus = $s['totalrequeststatus'];

	if($rowsres < 0)
	{
		echo '<script type="text/javascript">'; 
		echo 'window.location.href = "loanrequest.php"';
		echo '</script>';
	}
?>

<?php 

	if(isset($_POST['finalSubmitRequest']))
	{

    $loanrequestid = $_POST['applicationid'];
    $memberid = $_POST['memberid'];
    $comakerid = $_SESSION['admin'];

		$que = "UPDATE loanrequesttbl SET totalrequeststatus = 'approved' WHERE loanrequestid = '$loanrequestid'";
    
    if($db->query($que) === true)
    {
      $que = "SELECT * FROM loanrequesttbl WHERE loanrequestid = '$loanrequestid' AND totalrequeststatus = 'approved' AND memberid = '$memberid'";
      $res = mysqli_query($db, $que);
      $fetch = mysqli_fetch_array($res);

      $sqld = "SELECT * from dashboardlogintbl WHERE id = '$memberid'";
		  $ress = mysqli_query($db, $sqld);
		  $fetch = mysqli_fetch_array($ress);

  		$userLevel = $fetch['level'];

      $name = $userLevel;

      $comakername = $name;

      $dateToday = date("M-d-Y h:i:s A");

      $message = "Good Day ! " . $name . ". Happy to inform you that your loan request have been approved by the Chairperson. Please avoid delay of payment!";
    	$que = "INSERT INTO `notiftbl` (`id`, `memberfrom`, `date`,`title`,`message`,`details`, `memberto`, `status`) VALUES (NULL, '$comakername', '$dateToday','Loan Request Approved','$message','$loanrequestid', '$memberid', 'unread')";
      

      if($db->query($que) === true)
      {

      	$que = "SELECT id, memberid, loanrequestid, appmonth, duedate, amortization, CONCAT('Php ', FORMAT(amortization,2)) AS amortization2, principal, CONCAT('Php ', FORMAT(principal,2)) AS principal2, interest, CONCAT('Php ', FORMAT(interest, 2)) AS interest2, balance, CONCAT('Php', FORMAT(balance, 2)) AS balance2 FROM viewloantbl WHERE memberid ='$memberid' ORDER BY id ASC;";
      	$query = mysqli_query($db, $que);
      	$result = mysqli_fetch_array($query);

      	$balance = $result['balance'];
	    $applicationid = $loanrequestid;
	    $datetoday = date('Y-m-d');
	    $currdeadline = $result['duedate'];
	    $loanstatus = 'ongoing';

	    $que = "UPDATE `memberloandetailstbl` SET `balance`= '$balance' ,`applicationid`= '$applicationid',`datetoday`='$datetoday',`currdeadline`='$currdeadline',`status`='$loanstatus' WHERE memberid = '$memberid';";

      	if($db->query($que) === true)
      	{
      		echo '<script type="text/javascript">'; 
	        echo 'alert("Request Approved");'; 
	        echo 'window.location.href = "loanrequest.php"';
	        echo '</script>';
      	}

      }

		// $loanrequestid = $_POST['applicationid'];

		// $que = "UPDATE loanrequesttbl SET totalrequeststatus = 'approved' WHERE loanrequestid = '$loanrequestid';";

  //   if($db->query($que) === true)
  //   {
  //   	$dateToday = date("M-d-Y h:i:s A");
  //   	$zxc = "SELECT * FROM memberdetailstbl WHERE memberid = '$memberid'";
		// 	$zqwe = mysqli_query($db, $zxc);
		// 	$qwe = mysqli_fetch_array($zqwe);
  //   	$memberName = ucfirst($qwe['fname']) . ' ' . ucfirst(substr($qwe['mname'], 0,1)) . '. ' . ucfirst($qwe['lname']);

  // //   	$comaker = $s['comakername'];

  // 		$message = "Good Day ! " . $memberName . ". Your Request Have been approved by the Chairman. Don't forget to pay on your duedate";
  // 		$comakerid = 'Chairperson';
  // 		$qued = "INSERT INTO `notiftbl` (`id`, `memberfrom`, `date`,`title`,`message`,`details`, `memberto`, `status`) VALUES (NULL, '$comakerid', '$dateToday','Chairperson Approved','$message','$loanrequestid', '$memberid', 'unread')";
    	

  //   	if($db->query($qued) === true)
  //   	{
	 //    	echo '<script type="text/javascript">'; 
	 //      echo 'alert("Loan Request Approved");'; 
	 //      echo 'window.location.href = "loanrequest.php"';
	 //      echo '</script>';
	 //    }
	 //    else
	 //    {
	 //    	error_reporting(E_ALL);
		// 		ini_set('display_errors', '1');
	 //    }

  // 	}

		}	
	}

	if(isset($_POST['cancelRequest']))
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

      $comakername = $userLevel;

      $dateToday = date("M-d-Y h:i:s A");

      $message = "Good Day ! " . $name . ". Sorry to inform you that your loan request have been declined by the Chairperson!";
    		$que = "INSERT INTO `notiftbl` (`id`, `memberfrom`, `date`,`title`,`message`,`details`, `memberto`, `status`) VALUES (NULL, '$comakerid', '$dateToday','Chairperson Declined','$message','$loanrequestid', '$memberid', 'unread')";
      

      if($db->query($que) === true)
      {
        echo '<script type="text/javascript">'; 
        echo 'alert("Request Declined");'; 
        echo 'window.location.href = "loanrequest.php"';
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
						<h1 class="h3 mb-0 text-gray-800">View Loan Request</h1>
						<!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
						<a href="loanrequest.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-caret-square-left fa-sm text-white-50"></i> Go Back</a>
					</div>

					<?php 

					// SELECT * FROM loanrequesttbl WHERE memberid = '16-1991-2019' AND paymentstatus = 'unpaid' AND totalrequeststatus = 'comaker approval';


					$s = "SELECT loanrequesttbl.*, STR_TO_DATE(dateend, '%m/%d/%Y') AS dateend, CONCAT('Php ',FORMAT(loanrequesttbl.totalamount,2)) AS bal, memberdetailstbl.* FROM loanrequesttbl INNER JOIN memberdetailstbl ON loanrequesttbl.memberid = memberdetailstbl.memberid WHERE loanrequesttbl.loanrequestid = '$loanrequestid';";
					$r = mysqli_query($db, $s);
					$f = mysqli_fetch_array($r);

					?>

					<div class="card shadow mb-4" style="width: 90%; margin:auto;">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Loan Request | Status: <?php echo ucfirst($f['totalrequeststatus']); ?></h6>
							
							<form class="user" action="viewrequestfinal.php?applicationno=<?php echo $_GET['applicationno'] ?>&memberid=<?php echo $_GET['memberid']; ?>" method="post">
								<button type="submit" class="btn btn-danger btn-sm" name="cancelRequest" onclick="return confirm('Are you sure?');" style="float: right; margin-top: -20px; margin-left: 5px;">Decline Request</button>
								<button type="submit" class="btn btn-success btn-sm" name="finalSubmitRequest" style="float: right; margin-top: -20px;">Approve Request</button>
								<input type="text" name="memberid" value="<?php echo $f['memberid']; ?>" hidden>
								<input type="text" name="comakerid" value="<?php echo $f['comakerid']; ?>" hidden>
								<input type="text" name="applicationid" value="<?php echo $f['loanrequestid']; ?>" hidden>
							</form>

						</div>

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
												<td><?php echo $f['name'];?></td>
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
