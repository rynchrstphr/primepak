<?php 

require('fpdf/fpdf.php');
include 'core/db.php';

class PDF extends FPDF
{
	// Page header
	function Header()
	{
		$this->Ln(5);

	    // Logo
	    $this->Image('../img/logo.png',30,10,30);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Move to the right
	    $this->Cell(86);
	    // Title
	    $this->Cell(30,10,'Primepak Multipurpose Cooperative',0,0,'C');
	    $this->Ln(10);
	    $this->Cell(86);
	    $this->Cell(30,10,'On-going Loan',0,0,'C');
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}


$pdf = new PDF();

$lt = "";

if(isset($_GET['ltype']))
{
	$lt = $_GET['ltype'];
}

if($lt == "Loan Type")
{
	$lt = "";
}

if($lt == "")
{

	$client = array();
	$sql = "SELECT loanrequesttbl.*, memberloandetailstbl.* ,loanrequesttbl.dateend AS dateend, CONCAT('Php ',FORMAT(loanrequesttbl.totalamount,2)) AS bal, memberdetailstbl.* FROM loanrequesttbl INNER JOIN memberdetailstbl ON loanrequesttbl.memberid = memberdetailstbl.memberid INNER JOIN memberloandetailstbl ON memberloandetailstbl.memberid = memberdetailstbl.memberid WHERE loanrequesttbl.paymentstatus = 'unpaid' AND loanrequesttbl.totalrequeststatus != '';";
	$res = mysqli_query($db, $sql);
	while ($row = mysqli_fetch_array($res)) 
	{
		array_push($client, $row['memberid']);
		$pdf->AliasNbPages();
		$pdf->AddPage();

		$name = ucfirst($row['fname']) . " " . ucfirst(substr($row['mname'], 0,1)) . ". " . ucfirst($row['lname']);

		$pdf->Ln(30);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(36 ,8.25,'APPLICATION NO:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(42.5 ,8.25,$row['loanrequestid'],0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(37 ,8.25,'DATE SUBMITTED:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(50 ,8.25,$row['datesubmitted'],0,0,'L');

		$pdf->Ln(7);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(24 ,8.25,'MEMBER ID:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(54 ,8.25,$row['memberid'],0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(28 ,8.25,'CO-MAKER ID:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(50 ,8.25,$row['memberid'],0,0,'L');

		$pdf->Ln(7);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(14 ,8.25,'NAME:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(64 ,8.25,$name,0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(36 ,8.25,'CO-MAKER NAME:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(50 ,8.25,$name,0,0,'L');

		$pdf->Ln(15);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',13);
		$pdf->Cell(46 ,8.25,'LOAN DETAILS',0,0,'L');
		$pdf->Ln(9);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(46 ,8.25,'TOTAL LOAN AMOUNT:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(40 ,8.25,$row['bal'],0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(27,8.25,'LOAN TYPE:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(60 ,8.25,ucfirst($row['loantype']),0,0,'L');

		$pdf->Ln(7);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(41,8.25,'MODE OF PAYMENT:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(45 ,8.25,ucfirst($row['mop']),0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(43,8.25,'NUMBER OF MONTHS:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(60 ,8.25,ucfirst($row['months']) . ' Months',0,0,'L');


		$pdf->Ln(7);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(28 ,8.25,'START DATE:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(58 ,8.25,$row['datestart'],0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(23 ,8.25,'END DATE:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(50 ,8.25,$row['dateend'],0,0,'L');

		$pdf->Ln(15);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','',10);
		$pdf->Cell(30 ,9,'Application Month',1,0,'L');
		$pdf->Cell(29 ,9,'Due Date',1,0,'C');
		$pdf->Cell(29 ,9,'Amortization',1,0,'C');
		$pdf->Cell(29 ,9,'Interest',1,0,'C');
		$pdf->Cell(29 ,9,'Principal',1,0,'C');
		$pdf->Cell(29 ,9,'Balance',1,0,'C');

		$memno = $row['memberid'];
		$reqI = $row['loanrequestid'];

		$sq = "SELECT id, memberid, loanrequestid, appmonth, duedate, CONCAT('Php ',FORMAT(viewloantbl.amortization,2)) AS amortization, CONCAT('Php ',FORMAT(viewloantbl.principal,2)) AS principal, CONCAT('Php ',FORMAT(viewloantbl.interest,2)) AS interest, CONCAT('Php ',FORMAT(viewloantbl.balance,2)) AS balance, paymentstatus as status from viewloantbl WHERE memberid = '$memno' AND loanrequestid = '$reqI' ORDER BY id ASC";
		$s = mysqli_query($db,$sq); 
		while($r = mysqli_fetch_array($s))
		{
			$pdf->Ln(9);
			$pdf->cell(10);
			$pdf -> SetFont('Arial','',10);
			$pdf->Cell(30 ,9,$r['appmonth'],1,0,'C');
			$pdf->Cell(29 ,9,$r['duedate'],1,0,'C');
			$pdf->Cell(29 ,9,$r['amortization'],1,0,'C');
			$pdf->Cell(29 ,9,$r['interest'],1,0,'C');
			$pdf->Cell(29 ,9,$r['principal'],1,0,'C');
			$pdf->Cell(29 ,9,$r['balance'],1,0,'C');
		}
	}
	
}
else
{
	$client = array();
	$sql = "SELECT loanrequesttbl.*, memberloandetailstbl.* ,loanrequesttbl.dateend AS dateend, CONCAT('Php ',FORMAT(loanrequesttbl.totalamount,2)) AS bal, memberdetailstbl.* FROM loanrequesttbl INNER JOIN memberdetailstbl ON loanrequesttbl.memberid = memberdetailstbl.memberid INNER JOIN memberloandetailstbl ON memberloandetailstbl.memberid = memberdetailstbl.memberid WHERE loanrequesttbl.paymentstatus = 'unpaid' AND loanrequesttbl.totalrequeststatus != '' AND loanrequesttbl.loantype = '$lt';";
	$res = mysqli_query($db, $sql);
	while ($row = mysqli_fetch_array($res)) 
	{
		array_push($client, $row['memberid']);
		$pdf->AliasNbPages();
		$pdf->AddPage();

		$name = ucfirst($row['fname']) . " " . ucfirst(substr($row['mname'], 0,1)) . ". " . ucfirst($row['lname']);

		$pdf->Ln(30);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(36 ,8.25,'APPLICATION NO:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(42.5 ,8.25,$row['loanrequestid'],0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(37 ,8.25,'DATE SUBMITTED:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(50 ,8.25,$row['datesubmitted'],0,0,'L');

		$pdf->Ln(7);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(24 ,8.25,'MEMBER ID:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(54 ,8.25,$row['memberid'],0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(28 ,8.25,'CO-MAKER ID:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(50 ,8.25,$row['memberid'],0,0,'L');

		$pdf->Ln(7);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(14 ,8.25,'NAME:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(64 ,8.25,$name,0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(36 ,8.25,'CO-MAKER NAME:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(50 ,8.25,$name,0,0,'L');

		$pdf->Ln(15);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',13);
		$pdf->Cell(46 ,8.25,'LOAN DETAILS',0,0,'L');
		$pdf->Ln(9);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(46 ,8.25,'TOTAL LOAN AMOUNT:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(40 ,8.25,$row['bal'],0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(27,8.25,'LOAN TYPE:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(60 ,8.25,ucfirst($row['loantype']),0,0,'L');

		$pdf->Ln(7);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(41,8.25,'MODE OF PAYMENT:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(45 ,8.25,ucfirst($row['mop']),0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(43,8.25,'NUMBER OF MONTHS:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(60 ,8.25,ucfirst($row['months']) . ' Months',0,0,'L');


		$pdf->Ln(7);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(28 ,8.25,'START DATE:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(58 ,8.25,$row['datestart'],0,0,'L');
		$pdf -> SetFont('Arial','B',11);
		$pdf->Cell(23 ,8.25,'END DATE:',0,0,'L');
		$pdf -> SetFont('Arial','',11);
		$pdf->Cell(50 ,8.25,$row['dateend'],0,0,'L');

		$pdf->Ln(15);
		$pdf->cell(10);
		$pdf -> SetFont('Arial','',10);
		$pdf->Cell(30 ,9,'Application Month',1,0,'L');
		$pdf->Cell(29 ,9,'Due Date',1,0,'C');
		$pdf->Cell(29 ,9,'Amortization',1,0,'C');
		$pdf->Cell(29 ,9,'Interest',1,0,'C');
		$pdf->Cell(29 ,9,'Principal',1,0,'C');
		$pdf->Cell(29 ,9,'Balance',1,0,'C');

		$memno = $row['memberid'];
		$reqI = $row['loanrequestid'];

		$sq = "SELECT id, memberid, loanrequestid, appmonth, duedate, CONCAT('Php ',FORMAT(viewloantbl.amortization,2)) AS amortization, CONCAT('Php ',FORMAT(viewloantbl.principal,2)) AS principal, CONCAT('Php ',FORMAT(viewloantbl.interest,2)) AS interest, CONCAT('Php ',FORMAT(viewloantbl.balance,2)) AS balance, paymentstatus as status from viewloantbl WHERE memberid = '$memno' AND loanrequestid = '$reqI' ORDER BY id ASC";
		$s = mysqli_query($db,$sq); 
		while($r = mysqli_fetch_array($s))
		{
			$pdf->Ln(9);
			$pdf->cell(10);
			$pdf -> SetFont('Arial','',10);
			$pdf->Cell(30 ,9,$r['appmonth'],1,0,'C');
			$pdf->Cell(29 ,9,$r['duedate'],1,0,'C');
			$pdf->Cell(29 ,9,$r['amortization'],1,0,'C');
			$pdf->Cell(29 ,9,$r['interest'],1,0,'C');
			$pdf->Cell(29 ,9,$r['principal'],1,0,'C');
			$pdf->Cell(29 ,9,$r['balance'],1,0,'C');
		}
	}
}

$pdf->Output();

?>












