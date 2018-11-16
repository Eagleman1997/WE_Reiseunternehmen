<?php

//namespace pdf;

/*
require_once '../entities/Trip.php';
$trip = new \entities\Trip;
$trip->setId(1);
$newTrip = $trip->find();

*/

include("../fpdf/fpdf.php");

$tripName = 'Oversea Beauty';
$date = new DateTime();
$bookingDate = $date->format('d.m.Y');
$date->add(new DateInterval('P30D'));
$departureDate = $date->format('d.m.Y');

// Creating Trip ID
$tId = 20202;
switch (true) {
    case $tId < 10:
        $tripId = '00000'.$tId;
        break;

    case $tId < 100:
        $tripId = '0000'.$tId;
        break;

    case $tId < 1000:
        $tripId = '000'.$tId;
        break;
    
    case $tId < 10000:
        $tripId = '00'.$tId;
        break;
    
    case $tId < 100000:
        $tripId = '0'.$tId;
        break;
    
    case $tId < 1000000:
        $tripId = ''.$tId;
        break;
}



// customer variables
$hotelCalcCost = 500;
$hotelActualCost = 600;
$hotelDelta = (($hotelActualCost - $hotelCalcCost)/($hotelCalcCost/100));

$busCalcCost = 500;
$busActualCost = 400;
$busDelta = (($busActualCost - $busCalcCost)/($busCalcCost/100));

$insuranceCalcCost = 200;
$insuranceActualCost = 200;
$insuranceDelta = (($insuranceActualCost - $insuranceCalcCost)/($insuranceCalcCost/100));

$calcCostTotal = $hotelCalcCost + $busCalcCost + $insuranceCalcCost;
$actualCostTotal = $hotelActualCost + $busActualCost + $insuranceActualCost;
$totalDelta = (($actualCostTotal - $calcCostTotal)/($calcCostTotal/100));

$marge = 10;
$hotelRevenue = $hotelCalcCost + ($hotelCalcCost * $marge/100);
$busRevenue = $busCalcCost + ($busCalcCost * $marge /100);
$insuranceRevenue = $insuranceCalcCost + ($insuranceCalcCost * $marge/100);
$totalRevenue = $hotelRevenue + $busRevenue + $insuranceRevenue;

$grossProfit = $totalRevenue - $actualCostTotal;
    

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
    $this->SetFont('Helvetica','I',33);
    $this->SetTextColor(233, 156, 28);
    $this->Cell(55,15,'FINAL SETTLEMENT',0,0);
         
    // Line break
    $this->Ln(31);
    
    
    $this->Line(10, 75, 50, 75);
    $this->Line(60, 75, 100, 75);
    $this->Line(110, 75, 150, 75);
    $this->Line(160, 75, 200, 75);
    

    $this->SetTextColor(0,0,0);
    
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,4,'Trip #',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'Booking date',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'Departure Due',0,0);
    $this->Cell(20);
    $this->Cell(30,4,'Trip Name',0,1);
    $this->Ln(1);
    
     /*
     * 
     * Load Trip ID, booking date, trip name
     * 
     */
    global $tripName;
    global $bookingDate;
    global $departureDate;
    global $tripId;
    
    
    
    $this->SetFont('Arial','',8);
    // Invoice ID
    $this->Cell(30,4,'#'.$tripId,0,0);
    $this->Cell(20);    
    // Booking date
    $this->Cell(30,4,''.$bookingDate,0,0);
    $this->Cell(20);
    // Booking date + 30 days
    $this->Cell(30,4,''.$departureDate,0,0);
    $this->Cell(20);    
    // Trip name
    $this->Cell(30,4,''.$tripName,0,1);     
    
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
    
    // customer variables
    global $hotelCalcCost;
    global $hotelActualCost;
    global $hotelDelta;
    global $busCalcCost;
    global $busActualCost;
    global $busDelta;
    global $insuranceCalcCost;
    global $insuranceActualCost;
    global $insuranceDelta;
    global $calcCostTotal;
    global $actualCostTotal;
    global $totalDelta;
    global $hotelRevenue;
    global $busRevenue;
    global $insuranceRevenue;
    global $totalRevenue;
    global $grossProfit;
    
    
    //$this->SetY(106);
    
    $this->SetY(100);
    $this->SetFont('Helvetica','I',15);
    $this->SetTextColor(233, 156, 28);
    $this->Cell(110,15,'Costs',0,0);
    $this->Cell(50,15,'Revenue',0,0);
    
    $this->SetY(116);
    $this->SetTextColor(0,0,0);
    $this->Line(10, 120, 110, 120);
    $this->Line(120, 120, 200, 120);
    
    $this->SetFont('Arial','BI',8);
    $this->Cell(22,4,'Description',0,0);
    $this->Cell(30,4,'Calculated costs',0,0,'R');
    $this->Cell(30,4,'Actual costs',0,0,'R');
    $this->Cell(18,4,'Delta',0,0,'R');
    $this->Cell(10);
    $this->Cell(30,4,'Description',0,0);
    $this->Cell(30,4,'Revenue',0,1,'R');
    
    $this->SetFont('Arial','',8);
    $this->Cell(22,5,'Hotel',0,0);
    $this->Cell(30,5,'CHF '.$hotelCalcCost,0,0,'R');
    $this->Cell(30,5,'CHF '.$hotelActualCost,0,0,'R');
    
    if ($hotelDelta < 0){
        $this->SetTextColor(255, 0, 0);
    } else if ($hotelDelta > 0){
        $this->SetTextColor(0, 153, 0);
    }
    $this->Cell(18,5,''.$hotelDelta.'%',0,0,'R');
    $this->SetTextColor(0,0,0);
    $this->Cell(10);
    $this->Cell(30,5,'Hotel',0,0);
    $this->Cell(30,5,'CHF '.$hotelRevenue,0,1,'R');
    
    $this->SetDrawColor(217, 217, 217);
    $this->Line(10, 125, 110, 125);
    
    $this->Line(120, 125, 200, 125);
 
    $this->SetFont('Arial','',8);
    $this->Cell(22,5,'Bus',0,0);
    $this->Cell(30,5,'CHF '.$busCalcCost,0,0,'R');
    $this->Cell(30,5,'CHF '.$busActualCost,0,0,'R');
    if ($busDelta < 0){
        $this->SetTextColor(255, 0, 0);
    } else if ($busDelta > 0){
        $this->SetTextColor(0, 153, 0);
    }
    $this->Cell(18,5,''.$busDelta.'%',0,0,'R');
    $this->SetTextColor(0,0,0);
    $this->Cell(10);
    $this->Cell(30,5,'Bus',0,0);
    $this->Cell(30,5,'CHF '.$busRevenue,0,1,'R');
    
    $this->Line(10, 130, 110, 130);
    $this->Line(120, 130, 200, 130);
    
    $this->Cell(22,5,'Insurance',0,0);
    $this->Cell(30,5,'CHF '.$insuranceCalcCost,0,0,'R');
    $this->Cell(30,5,'CHF '.$insuranceActualCost,0,0,'R');
    if ($insuranceDelta < 0){
        $this->SetTextColor(255, 0, 0);
    } else if ($insuranceDelta > 0){
        $this->SetTextColor(0, 153, 0);
    }
    $this->Cell(18,5,''.$insuranceDelta.'%',0,0,'R');
    $this->SetTextColor(0,0,0);
    $this->Cell(10);
    $this->Cell(30,5,'Insurance',0,0);
    $this->Cell(30,5,'CHF '.$insuranceRevenue,0,1,'R');
   
    $this->SetDrawColor(0, 0, 0);
    $this->Line(10, 135, 110, 135);
    $this->Line(120, 135, 200, 135);
    
    $this->Ln(5);
    
    $this->Line(10, 145, 110, 145);  
    $this->Line(120, 145, 200, 145); 
    
    
    $this->SetFont('Arial','BI',8);
    $this->Cell(22,5,'Total',0,0);
    $this->SetFont('Arial','',8);
    $this->Cell(30,5,'CHF '.$calcCostTotal,0,0,'R');
    $this->Cell(30,5,'CHF '.$actualCostTotal,0,0,'R');
    $this->Cell(18,5,''.$totalDelta.'%',0,0,'R');
    $this->Cell(10);
    
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,5,'Total',0,0);
    $this->SetFont('Arial','',8);
    $this->Cell(30,5,'CHF '.$totalRevenue,0,1,'R');



    
    // Big Price
    $this->SetY(160);
    $this->Line(10, 165, 40, 165);
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,5,'Gross profit',0,0);
    $this->Ln(3);
    

    $this->SetFont('Helvetica','I',15);
    $this->SetTextColor(233, 156, 28);
    $this->Cell(80,15,'CHF '.$grossProfit,0,0);   

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
