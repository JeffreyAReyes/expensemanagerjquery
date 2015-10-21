<?php

if (!isset($_POST['ReportTitle'])) 
{
//If not isset -> set with dumy value 
$_POST['ReportTitle'] = "undefine"; 
} 

$ReportTitle = htmlspecialchars($_REQUEST['ReportTitle']);
$Data = ($_REQUEST['JsonData']);


// decode JSON string to PHP object, 2nd param sets to associative array
$decoded = json_decode($Data,true);


require('fpdf.php');

class PDF extends FPDF
{
	
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Simple table


function BasicTable($header,$decoded)
{
	
	$TotalDebit=0;
	$TotalCredit=0;
    // Header
    foreach($header as $col)
        $this->Cell(35,7,$col);
	$this->Ln();
	$this->Cell(0,4,'--------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,0,'C');
	$this->Ln();
    // Data

	foreach ($decoded as $row) {
		
		$this->Cell(35,6,$row["CatSubcat"],0);
		$this->Cell(35,6,$row["TransDate"],0);
		
		if ( $row["Amount"] == 0) {
			$this->Cell(35,6,"",0,0,'R');
		} else {
			$this->SetX(65);
			$this->Cell(25,6,number_format($row["Amount"],2),0,0,'R');
			$TotalDebit=$TotalDebit + $row["Amount"];
		}
		
		if ( $row["ExpenseAmount"] == 0) {
			$this->Cell(42,6,"",0,0,'R');
		} else {
			$this->SetX(100);
			$this->Cell(25,6,number_format($row["ExpenseAmount"],2),0,0,'R');
			$TotalCredit=$TotalCredit + $row["ExpenseAmount"];
		}
		$this->SetX(130);
		$this->Cell(30,6,$row["Remarks"],0);
		
        $this->Ln();
		}
		$this->Cell(0,4,'--------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'C');		
		
		//set Location of totals
		$this->SetXY($this->GetX() , $this->GetY());
		//Print totals
		$this->Cell(150,5,"Total Income:",0,0,'R');
		$this->Cell(27,5,number_format($TotalDebit,2),0,0,'R');
		$this->Ln();
		$this->Cell(150,5,"Total Expense:",0,0,'R');
		$this->Cell(27,5,number_format($TotalCredit,2),0,0,'R');
		$this->Ln();
		$this->Cell(150,5,"Balance:",0,0,'R');
		$this->Cell(27,5,number_format($TotalDebit-$TotalCredit,2),0,0,'R');
}

	function Footer()
	{
		// Go to 1.5 cm from bottom
		$this->SetY(-10);
		// Select Arial italic 8
		$this->SetFont('Arial','I',8);
		// Print centered page number
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

	}
	
	function subWrite($h, $txt, $link='', $subFontSize=12, $subOffset=0)
		{
			// resize font
			$subFontSizeold = $this->FontSizePt;
			$this->SetFontSize($subFontSize);
			
			// reposition y
			$subOffset = ((($subFontSize - $subFontSizeold) / $this->k) * 0.3) + ($subOffset / $this->k);
			$subX        = $this->x;
			$subY        = $this->y;
			$this->SetXY($subX, $subY - $subOffset);

			//Output text
			$this->Write($h, $txt, $link);

			// restore y position
			$subX        = $this->x;
			$subY        = $this->y;
			$this->SetXY($subX,  $subY + $subOffset);

			// restore font size
			$this->SetFontSize($subFontSizeold);
		}

}

// --------------------------- Get current date

$dt = new DateTime();
$dt = $dt->format('Y-M-d');

// --------------------------- Get current date

$pdf = new PDF();
$pdf->AliasNbPages();
// Column headings
$header = array('Account Title',  'Date', 'Income', 'Expense');

$pdf->SetFont('Arial','',9);
$pdf->SetMargins(5,5,5);
$pdf->AddPage();

$pdf->subWrite(4,'E','',20);
$pdf->Write(4,'xpense');

$pdf->Ln();
$pdf->Ln();
$pdf->SetX(10);
$pdf->subWrite(4,'M','',20);
$pdf->Write(4,'anager');
$pdf->SetX(5);
$pdf->Cell(0,4,'Income - Expense Report',0,1,'C');
$pdf->Cell(0,4,$ReportTitle,0,1,'C');
$pdf->Cell(0,4,"As Of: " . $dt,0,1,'C');
$pdf->Cell(0,4,'--------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'C');
$pdf->BasicTable($header,$decoded);

$pdf->Output();

?>