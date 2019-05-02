<?php 

require('fpdf/fpdf.php');
include 'core/db.php';
session_start();
// $pdf = new FPDF();
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'Hello World!');
// $pdf->Output();

	$memberid = $_SESSION['memberid'];

	$s = "SELECT loanrequesttbl.*, memberloandetailstbl.* ,loanrequesttbl.dateend AS dateend, CONCAT('Php ',FORMAT(loanrequesttbl.totalamount,2)) AS bal, memberdetailstbl.* FROM loanrequesttbl INNER JOIN memberdetailstbl ON loanrequesttbl.memberid = memberdetailstbl.memberid INNER JOIN memberloandetailstbl ON memberloandetailstbl.memberid = memberdetailstbl.memberid WHERE loanrequesttbl.memberid = '$memberid' AND loanrequesttbl.paymentstatus = 'unpaid' AND loanrequesttbl.totalrequeststatus != ''";
	$r = mysqli_query($db, $s);
	$f = mysqli_fetch_array($r);
	$name = ucfirst($f['fname']) . " " . ucfirst(substr($f['mname'], 0,1)) . ". " . ucfirst($f['lname']);

class PDF extends FPDF
{
	// Page header
	function Header()
	{
		$this->Ln(5);

	    // Logo
	    $this->Image('img/logo.png',30,10,30);
	    // Arial bold 15
	    $this->SetFont('Arial','B',15);
	    // Move to the right
	    $this->Cell(86);
	    // Title
	    $this->Cell(30,10,'Primepak Multipurpose Cooperative',0,0,'C');
	    $this->Ln(10);
	    $this->Cell(86);
	    $this->Cell(30,10,'Member Loan Details',0,0,'C');
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

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
 
$pdf->Ln(30);
$pdf->cell(10);
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(36 ,8.25,'APPLICATION NO:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(42.5 ,8.25,$f['loanrequestid'],0,0,'L');
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(37 ,8.25,'DATE SUBMITTED:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(50 ,8.25,$f['datesubmitted'],0,0,'L');

$pdf->Ln(7);
$pdf->cell(10);
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(24 ,8.25,'MEMBER ID:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(54 ,8.25,$f['memberid'],0,0,'L');
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(28 ,8.25,'CO-MAKER ID:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(50 ,8.25,$f['memberid'],0,0,'L');

$pdf->Ln(7);
$pdf->cell(10);
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(14 ,8.25,'NAME:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(64 ,8.25,$name,0,0,'L');
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(36 ,8.25,'CO-MAKER NAME:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(50 ,8.25,$f['comakername'],0,0,'L');

$pdf->Ln(15);
$pdf->cell(10);
$pdf -> SetFont('Arial','B',13);
$pdf->Cell(46 ,8.25,'LOAN DETAILS',0,0,'L');
$pdf->Ln(9);
$pdf->cell(10);
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(46 ,8.25,'TOTAL LOAN AMOUNT:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(40 ,8.25,$f['bal'],0,0,'L');
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(27,8.25,'LOAN TYPE:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(60 ,8.25,ucfirst($f['loantype']),0,0,'L');

$pdf->Ln(7);
$pdf->cell(10);
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(41,8.25,'MODE OF PAYMENT:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(45 ,8.25,ucfirst($f['mop']),0,0,'L');
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(43,8.25,'NUMBER OF MONTHS:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(60 ,8.25,ucfirst($f['months']) . ' Months',0,0,'L');


$pdf->Ln(7);
$pdf->cell(10);
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(28 ,8.25,'START DATE:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(58 ,8.25,$f['datestart'],0,0,'L');
$pdf -> SetFont('Arial','B',11);
$pdf->Cell(23 ,8.25,'END DATE:',0,0,'L');
$pdf -> SetFont('Arial','',11);
$pdf->Cell(50 ,8.25,$f['dateend'],0,0,'L');

$pdf->Ln(15);
$pdf->cell(10);
$pdf -> SetFont('Arial','',10);
$pdf->Cell(30 ,9,'Application Month',1,0,'L');
$pdf->Cell(29 ,9,'Due Date',1,0,'C');
$pdf->Cell(29 ,9,'Amortization',1,0,'C');
$pdf->Cell(29 ,9,'Interest',1,0,'C');
$pdf->Cell(29 ,9,'Principal',1,0,'C');
$pdf->Cell(29 ,9,'Balance',1,0,'C');
	$memno = $f['memberid'];
	$reqI = $f['loanrequestid'];

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


$pdf->SetFont('Times','',12);
$pdf->Output();

?>