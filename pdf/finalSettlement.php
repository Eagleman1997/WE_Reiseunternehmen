<?php

namespace pdf;

/*
require_once '../entities/Trip.php';
$trip = new \entities\Trip;
$trip->setId(1);
$newTrip = $trip->find();

*/

include("fpdf/fpdf.php");


class PDF extends \FPDF
{
// Page header
function Header()
{
      
    // A4 ist 210mm
        
    // Logo
    $this->Image('pdf/logo.jpeg',90,6,30);
    $this->Ln(30);
    
    // Line(float x1, float y1, float x2, float y2)
    $this->Line(10, 40, 200, 40);
    $this->Line(10, 55, 200, 55);
    
    // Invoice
    $this->SetFont('Helvetica','I',37);
    $this->SetTextColor(233, 156, 28);
    $this->Cell(55,15,'INVOICE',0,0);
    
    
    // customer details
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(0,0,0);
    $this->Cell(0,3,'',0,1);
    $this->Cell(80);    
    $this->Cell(30,5,'Prepared for:',0,0);
    $this->SetFont('Arial','',8);
    $this->Cell(40,4,'Ms.',0,0);
    $this->Cell(40,4,'Buechstrasse 9',0,1);
    $this->Cell(110);
    $this->Cell(40,4,'Vanessa Cajochen',0,0);
    $this->Cell(40,4,'5436 Wurenlos',0,1);
        
    // Line break
    $this->Ln(20);
    
    
    $this->Line(10, 75, 50, 75);
    $this->Line(60, 75, 100, 75);
    $this->Line(110, 75, 150, 75);
    $this->Line(160, 75, 200, 75);
    
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,4,'Invoice #',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'Invoice date',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'Payment Due',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'Trip Name',0,1);
    $this->Ln(1);
    
    $this->SetFont('Arial','',8);
    $this->Cell(30,4,'#000001',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'02.02.2018',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'02.03.2018',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'Oversea Beauty',0,1);     
    
    $this->Ln(20);
    
 
}


// Page footer
function Footer()
{
    // Position at 2.5 cm from bottom
    $this->SetY(-25);
    // Arial italic 8
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(0,0,0);
    $this->Cell(45,4,'Dream Trips',0,1);    
    
    $this->SetFont('Arial','',8);
    $this->Cell(25,4,'Bahnstrasse 1',0,0);
    $this->Cell(48,4,'IBAN: CH8209000000603591064',0,0);
    $this->Cell(45,4,'P: +41 56 424 24 24',0,1);
    $this->Cell(25,4,'3008 Bern',0,0);
    $this->Cell(48,4,'BIC: POFICHBEXXX',0,0);
    $this->Cell(45,4,'M: info@dreamtrips.ch',0,1);
    
     
    
    
    // Thank you
    $this->SetY(-27);
    $this->Cell(119);
    $this->SetFont('Helvetica','I',32);
    $this->SetTextColor(233, 156, 28);
    $this->Cell(70,15,'THANK YOU!',0,0);
    
    // Line(float x1, float y1, float x2, float y2) y ist von oben
    $this->Line(10, 270, 200, 270);
    $this->Line(10, 285, 200, 285);

    
    
    // Page number
    //$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}


function CreateTable()
{
    $this->SetY(106);
    $this->Line(10, 110, 200, 110);
    
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,4,'Description',0,0);
    $this->Cell(60);
    $this->Cell(30,4,'Amount',0,0,'R');
    $this->Cell(40,4,'Price/Rate',0,0,'R');
    $this->Cell(30,4,'Subtotal',0,1,'R');
    
    $this->SetFont('Arial','',8);
    $this->Cell(30,6,'Hotel',0,0);
    $this->Cell(60);
    $this->Cell(30,6,'x '.'10',0,0,'R');
    $this->Cell(40,6,'CHF '.'50',0,0,'R');
    $this->Cell(30,6,'CHF '.'500',0,1, 'R');
    
    $this->SetDrawColor(217, 217, 217);
    $this->Line(10, 116, 200, 116);
    
    $this->Cell(30,6,'Bus',0,0);
    $this->Cell(60);
    $this->Cell(30,6,'x '.'1',0,0,'R');
    $this->Cell(40,6,'CHF '.'500',0,0,'R');
    $this->Cell(30,6,'CHF '.'500',0,1, 'R');
    $this->Line(10, 122, 200, 122);
    
    $this->Cell(30,6,'Insurance',0,0);
    $this->Cell(60);
    $this->Cell(30,6,'x '.'10',0,0,'R');
    $this->Cell(40,6,'CHF '.'22',0,0,'R');
    $this->Cell(30,6,'CHF '.'220',0,1, 'R');
    
    $this->SetDrawColor(0, 0, 0);
    $this->Line(10, 128, 200, 128);
    
    $this->Ln(5);
    $this->Cell(160);
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,4,'Total',0,1,'R');
    $this->Line(180, 137, 200, 137);
    
    $this->SetFont('Arial','',8);
    $this->Cell(160);
    $this->Cell(30,6,'CHF '.'1220',0,1, 'R');
    
    // TERMS & CONDITIONS
    
    $this->SetY(164);
    $this->SetFont('Arial','B',8);
    $this->Cell(100,6,'TERMS & CONDITIONS',0,0);
    $this->Cell(90,6,'AMOUNT DUE',0,1, 'R');
    $this->Line(10, 169, 200, 169);
    
    $this->Ln(1);
    $this->SetFont('Arial','I',7);
    $this->MultiCell(100, 3, 'Dream Trips reserves the right to change the Tour Price according to the price list or the agreed Tour Price, respectively, in case of extraordinary circumstances. Dream Trips reserves the right to change the Tour program at any time, prematurely curtail the Tour or offer alternative solutions in case of extraordinary circumstances. Any additional costs of the Tour shall be borne by the Customer. Dream Trips undertakes to immediately inform the Customer of any changes in services and/or in the program. If the alternative solution is more expensive than the initially booked Tour or unreasonable for the Customer, Customer is offered withdrawal free of charge. Refunds are effected in the same way as payment has been made. ');

    
    // Big Price
    $this->SetY(171);
    $this->Cell(110);
    $this->SetFont('Helvetica','B',30);
    $this->SetTextColor(233, 156, 28);
    $this->Cell(80,15,'CHF 1220.-',0,0,'R');
    

}

}

// Instanciation of inherited class
ob_start();
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->CreateTable();

$pdf->Output();
ob_end_flush();

/*
 * $pdf=new \FPDF('P','mm','A4');
$pdf->AddPage();
//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);
 * 
//Cell(source, x, y, width , height)
$pdf->Image('logo.jpeg',10,10,30,30);
$pdf->Cell(130 ,5,'',0,0);//end of line
$pdf->Cell(59 ,5,'INVOICE',0,1);//end of line

$pdf->Cell(189 ,10,'',0,1);//end of line
$pdf->Cell(189 ,10,'',0,1);//end of line
$pdf->Cell(189 ,10,'',0,1);//end of line
$pdf->Cell(189 ,10,'',0,1);//end of line

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130 ,5,'Dream Trips',0,0);
$pdf->Cell(59 ,5,'INVOICE',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130 ,5,'Bahnstrasse 1',0,0);
$pdf->Cell(59 ,5,'',0,1);//end of line

$pdf->Cell(130 ,5,'3008 Bern',0,0);
$pdf->Cell(25 ,5,'Date',0,0);
$pdf->Cell(34 ,5,'[dd/mm/yyyy]',0,1);//end of line

$pdf->Cell(130 ,5,'Schweiz',0,0);
$pdf->Cell(25 ,5,'Invoice #',0,0);
$pdf->Cell(34 ,5,'[1234567]',0,1);//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Customer ID',0,0);
$pdf->Cell(34 ,5,'[1234567]',0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line

//billing address
$pdf->Cell(100 ,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'[Name]',0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'[Company Name]',0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'[Address]',0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'[Phone]',0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(130 ,5,'Description',1,0);
$pdf->Cell(25 ,5,'Taxable',1,0);
$pdf->Cell(34 ,5,'Amount',1,1);//end of line

$pdf->SetFont('Arial','',12);

//Numbers are right-aligned so we give 'R' after new line parameter

$pdf->Cell(130 ,5,'UltraCool Fridge',1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(34 ,5,'3,250',1,1,'R');//end of line

$pdf->Cell(130 ,5,'Supaclean Diswasher',1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(34 ,5,'1,200',1,1,'R');//end of line

$pdf->Cell(130 ,5,'Something Else',1,0);
$pdf->Cell(25 ,5,'-',1,0);
$pdf->Cell(34 ,5,'1,000',1,1,'R');//end of line

//summary
$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Subtotal',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'4,450',1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Taxable',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'0',1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Tax Rate',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'10%',1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Total Due',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'4,450',1,1,'R');//end of line
        
        $pdf->Output();
        ?>
 
 */
