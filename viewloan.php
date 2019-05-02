<?php 

	$page = "View Loan Request";
	$active = "request";
	include 'includes/header.php';
	include 'core/db.php';
	session_start();
	if(!isset($_SESSION['memberid']))
	{
		header("Location: login.php");
	}

	$memberid = $_SESSION['memberid'];

	$qued = "SELECT * FROM loanrequesttbl WHERE memberid = '$memberid' AND totalrequeststatus = '-'";
	$es = mysqli_query($db, $qued);
	$s = mysqli_fetch_array($es);
	$rowsres = mysqli_fetch_row($es);

	if($rowsres < 0)
	{
		echo '<script type="text/javascript">'; 
		echo 'window.location.href = "request.php";';
		echo '</script>';
	}

?>

<?php 

	if(isset($_POST['finalSubmitRequest']))
	{
		$loanrequestid = $_POST['applicationid'];
		$que = "UPDATE loanrequesttbl SET totalrequeststatus = 'comaker approval' WHERE loanrequestid = '$loanrequestid';";
	    if($db->query($que) === true)
	    {
	    	$dateToday = date("M-d-Y h:i:s A");
	    	$memberName = $s['name'];
	    	$sex = $s['sex'];
	    	if($sex == 'Male')
	    	{
	    		$sex = 'his';
	    	}
	    	if($sex == 'Female')
	    	{
	    		$sex = 'her';
	    	}
	    	$comaker = $s['comakername'];

	    	$message = "Good Day ! " . $comaker . ". " . $memberName . " wants you to be " . $sex . " Co-Maker. ";

	    	$comakerid = $_POST['comakerid'];

	    	$que = "INSERT INTO `notiftbl` (`id`, `memberfrom`, `date`,`title`,`message`,`details`, `memberto`, `status`) VALUES (NULL, '$memberid', '$dateToday','Co-Maker','$message','$loanrequestid', '$comakerid', 'unread')";

	    	$queddd = "SELECT email FROM memberdetailstbl WHERE memberid = '$comakerid'";
				$esss = mysqli_query($db, $queddd);
				$sss = mysqli_fetch_array($esss);
				$mailed = $sss['email'];
	    	if($db->query($que) === true)
	    	{

	    		try
          {
            require_once('PHPMailer/PHPMailerAutoload.php');
            require_once('PHPMailer/class.phpmailer.php');  
            require_once('PHPMailer/class.smtp.php');


            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host ='smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username ='loaningsystem2019@gmail.com';
            $mail->Password ='P@s$w0rd';
            $mail->SMTPSecure = 'ssl';
            
            $mail->Port = '465';
            $mail->isHTML();
            
            $mail->SetFrom('no-reply@primepak.com');
            $mail->Subject = 'Prime Pak Loaning System';
            $mail->Body= $message;
            $mail->AddAddress($mailed);

            $mail->Send();

            echo "<script>alert('Loan Successfully Submitted to the Co-Maker!')</script>";
            echo "<script>document.getElementById('acc').click();</script>";
          }
          catch (phpmailerException $e) 
          {
            echo $e->errorMessage(); //error messages from PHPMailer
          }
          catch (Exception $e) 
          {
            echo $e->getMessage();
          }


		    	// echo '<script type="text/javascript">'; 
		     //  echo 'alert("Loan Request Submitted to Co-Maker for Approval");'; 
		     //  echo 'window.location.href = "viewloan.php";';
		     //  echo '</script>';
		    }
	    }


	}

	if(isset($_POST['cancelRequest']))
	{
		$loanrequestid = $_POST['applicationid'];
		$que = "DELETE FROM loanrequesttbl WHERE loanrequestid = '$loanrequestid';";
		$que = "DELETE FROM loanrequesttbl WHERE loanrequestid = '$loanrequestid';";
	    if($db->query($que) === true)
	    {
	    	echo '<script type="text/javascript">'; 
	      echo 'alert("Loan Request Cancelled!");'; 
	      echo 'window.location.href = "index.php";';
	      echo '</script>';
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
					</div>

					<?php 

					// SELECT * FROM loanrequesttbl WHERE memberid = '16-1991-2019' AND paymentstatus = 'unpaid' AND totalrequeststatus = 'comaker approval';

					$memberid = $_SESSION['memberid'];

					$s = "SELECT loanrequesttbl.*, memberloandetailstbl.* ,loanrequesttbl.dateend AS dateend, CONCAT('Php ',FORMAT(loanrequesttbl.totalamount,2)) AS bal, memberdetailstbl.* FROM loanrequesttbl INNER JOIN memberdetailstbl ON loanrequesttbl.memberid = memberdetailstbl.memberid INNER JOIN memberloandetailstbl ON memberloandetailstbl.memberid = memberdetailstbl.memberid WHERE loanrequesttbl.memberid = '$memberid' AND loanrequesttbl.paymentstatus = 'unpaid' AND loanrequesttbl.totalrequeststatus != ''";
					$r = mysqli_query($db, $s);
					$f = mysqli_fetch_array($r);
					$name = ucfirst($f['fname']) . " " . ucfirst(substr($f['mname'], 0,1)) . ". " . ucfirst($f['lname']);

					$lqs = "SELECT *, CONCAT('Php ', FORMAT(balance, 2)) AS balance FROM viewloantbl as balance WHERE loanrequestid = (SELECT applicationid FROM memberloandetailstbl WHERE memberid = '14-1991-2019') AND paymentstatus = 'unpaid' ORDER BY id ASC LIMIT 1;";
          $ser = mysqli_query($db, $lqs);
          $fe = mysqli_fetch_array($ser);

					?>

					<div class="card shadow mb-4" style="width: 90%; margin:auto;">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Loan Request | Status: <?php echo ucfirst($f['totalrequeststatus']); ?></h6>
							
							<?php 

								if($f['totalrequeststatus'] == '-')
								{
								?>
									<form class="user" action="viewloan.php" method="post">
										<button type="submit" class="btn btn-danger btn-sm" name="cancelRequest" onclick="return confirm('Are you sure?');" style="float: right; margin-top: -20px; margin-left: 5px;">Cancel Request</button>
										<button type="submit" class="btn btn-success btn-sm" name="finalSubmitRequest" style="float: right; margin-top: -20px;">Final Submit</button>
										<input type="text" name="memberid" value="<?php echo $f['memberid']; ?>" hidden>
										<input type="text" name="comakerid" value="<?php echo $f['comakerid']; ?>" hidden>
										<input type="text" name="applicationid" value="<?php echo $f['loanrequestid']; ?>" hidden>
									</form>
								<?php
								}

							?>

						</div>

						<div class="card-body">
							<div class="form-group-control">
								<div class="form-group row">
									<div class="col" style="margin-top: 10px;">
										<button type="submit" class="btn btn-secondary btn-sm" onclick="window.open('loanPrint.php')" style="float: right; margin-top: -20px;">Print</button>
									</div>
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
												<td style="text-align: right;" scope="col" >Current Deadline</td>
												<td><?php echo $f['currdeadline'];?></td>
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
										<table class="table table-bordered viewloantable" id="dataTable">
											<thead>
												<th>Application Month</th>
												<th>Due Date</th>
												<th>Amortization</th>
												<th>Interest</th>
												<th>Principal</th>
												<th>Balance</th>
												<th>Status</th>
											</thead>
											<tbody>
											<?php 

												$memno = $f['memberid'];
												$reqI = $f['loanrequestid'];

												$sq = "SELECT id, memberid, loanrequestid, appmonth, duedate, CONCAT('Php ',FORMAT(viewloantbl.amortization,2)) AS amortization, CONCAT('Php ',FORMAT(viewloantbl.principal,2)) AS principal, CONCAT('Php ',FORMAT(viewloantbl.interest,2)) AS interest, CONCAT('Php ',FORMAT(viewloantbl.balance,2)) AS balance, paymentstatus as status from viewloantbl WHERE memberid = '$memno' AND loanrequestid = '$reqI' ORDER BY id ASC";
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
														<td><?php echo $r['status']; ?></td>
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
