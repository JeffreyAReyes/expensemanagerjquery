<?php

if (!isset($_POST['BankName'])) 
{
//If not isset -> set with dumy value 
$_POST['BankName'] = "undefine"; 
} 

$BankName = htmlspecialchars($_REQUEST['BankName']);
$Data = ($_REQUEST['JsonData']);


// decode JSON string to PHP object, 2nd param sets to associative array
$decoded = json_decode($Data,true);

//$value;

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
        $this->Cell(40,7,$col);
		$this->Ln();
	$this->Cell(0,4,'--------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,0,'C');
	$this->Ln();
    // Data

	foreach ($decoded as $row) {
		
		$this->Cell(30,6,$row["RefNumber"],0);
		$this->Cell(30,6,$row["TransDate"],0);
		
		if ( $row["Debit"] == 0) {
			$this->Cell(30,6,"",0,0,'R');
		} else {
			$this->Cell(30,6,number_format($row["Debit"],2),0,0,'R');
			$TotalDebit=$TotalDebit + $row["Debit"];
		}
		
		if ( $row["Credit"] == 0) {
			$this->Cell(42,6,"",0,0,'R');
		} else {
			$this->Cell(42,6,number_format($row["Credit"],2),0,0,'R');
			$TotalCredit=$TotalCredit + $row["Credit"];
		}
		
		$this->Cell(45,6,number_format($row["Run_Bal"],2),0,0,'R');
		
        $this->Ln();
		}
		$this->Cell(0,4,'--------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'C');		
		
		//set Location of totals
		$this->SetXY($this->GetX() , $this->GetY());
		//Print totals
		$this->Cell(150,5,"Total Debit:",0,0,'R');
		$this->Cell(27,5,number_format($TotalDebit,2),0,0,'R');
		$this->Ln();
		$this->Cell(150,5,"Total Credit:",0,0,'R');
		$this->Cell(27,5,number_format($TotalCredit,2),0,0,'R');
		$this->Ln();
		$this->Cell(150,5,"Balance:",0,0,'R');
		$this->Cell(27,5,number_format($TotalDebit-$TotalCredit,2),0,0,'R');
}

// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40, 35, 40, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
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

	var $grid = false;

    function DrawGrid()
    {
        if($this->grid===true){
            $spacing = 5;
        } else {
            $spacing = $this->grid;
        }
        $this->SetDrawColor(204,255,255);
        $this->SetLineWidth(0.35);
        for($i=0;$i<$this->w;$i+=$spacing){
            $this->Line($i,0,$i,$this->h);
        }
        for($i=0;$i<$this->h;$i+=$spacing){
            $this->Line(0,$i,$this->w,$i);
        }
        $this->SetDrawColor(0,0,0);

        $x = $this->GetX();
        $y = $this->GetY();
        $this->SetFont('Arial','I',8);
        $this->SetTextColor(204,204,204);
        for($i=20;$i<$this->h;$i+=20){
            $this->SetXY(1,$i-3);
            $this->Write(4,$i);
        }
        for($i=20;$i<(($this->w)-($this->rMargin)-10);$i+=20){
            $this->SetXY($i-1,1);
            $this->Write(4,$i);
        }
        $this->SetXY($x,$y);
    }

    function Header()
    {
        if($this->grid)
            $this->DrawGrid();
    }

}// End class

	
// --------------------------- Get current date

$dt = new DateTime();
$dt = $dt->format('Y-M-d');

// --------------------------- Get current date

$pdf = new PDF();
$pdf->AliasNbPages();

$pdf->grid = true;

// Column headings
$header = array('Ref. Num', 'Date', 'Debit', 'Credit', 'Balance');
// Data loading
//$data = $pdf->LoadData('countries.txt');
$pdf->SetFont('Arial','',10);
$pdf->SetMargins(5,5,5);
$pdf->AddPage();
// Page header
//$pdf->Cell(40,10,'Expense Manager - Bank Account Ledger');
//$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');
$pdf->subWrite(4,'E','',20);
$pdf->Write(4,'xpense');

$pdf->Ln();
$pdf->Ln();
$pdf->SetX(10);
$pdf->subWrite(4,'M','',20);
$pdf->Write(4,'anager');
$pdf->SetX(5);
$pdf->Cell(0,4,'Bank Account Ledger',0,1,'C');
$pdf->Cell(0,4,$BankName,0,1,'C');
$pdf->Cell(0,4,"As Of: " . $dt,0,1,'C');
$pdf->Cell(0,4,'--------------------------------------------------------------------------------------------------------------------------------------------------------------------------',0,1,'C');
$pdf->BasicTable($header,$decoded);
//$pdf->Footer();
$pdf->Output();

?>