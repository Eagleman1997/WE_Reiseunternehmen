<?php


 /*
 * @author Vanessa Cajochen
 */


use entities\Trip;


include("fpdf/fpdf.php");

$trip = Trip::findTrip();

if(!$trip){
    exit();
}
ob_start();

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
    
    $this->SetFont('Arial','B',8);
    $this->SetTextColor(0,0,0);
    $this->Cell(0,3,'',0,1);
    $this->Cell(80);    
    $this->Cell(30,5,'Prepared for:',0,0);
    $this->SetFont('Arial','',8);
    $this->Cell(40,4,''.$this->customerGender,0,0);
    $this->Cell(40,4,''.$this->customerStreet,0,1);
    $this->Cell(110);
    $this->Cell(40,4,''.$this->customerName,0,0);
    $this->Cell(40,4,''.$this->customerPLZ,0,1);
        
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
    
    /*
     * 
     * Load Trip ID, booking date, trip name
     * 
     */

    $this->SetFont('Arial','',8);
    // Invoice ID
    $this->Cell(30,4,'#'.$this->InvoiceID,0,0);
    $this->Cell(20);    
    // Booking date
    $this->Cell(30,4,''.$this->bookingDate,0,0);
    $this->Cell(20);
    // Booking date + 30 days
    $this->Cell(30,4,''.$this->dueDate,0,0);
    $this->Cell(20);    
    // Trip name
    $this->Cell(30,4,''.$this->tripName,0,1);     
    
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

}


function CreateTable()
{ 
    
    $this->SetY(106);
    $this->Line(10, 110, 200, 110);
    
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,4,'Description',0,0);
    $this->Cell(60);
    $this->Cell(30,4,'No. of persons',0,0,'R');
    $this->Cell(40,4,'Cost per person',0,0,'R');
    $this->Cell(30,4,'Subtotal',0,1,'R');
    
    $this->SetFont('Arial','',8);
    $this->Cell(30,6,''.$this->tripDescription,0,0);
    $this->Cell(60);
    $this->Cell(30,6,''.$this->numberOfPersons,0,0,'R');
    $this->Cell(40,6,'CHF '.$this->tripCostPerPerson,0,0,'R');
    $this->Cell(30,6,'CHF '.$this->tripSubtotal,0,1, 'R');
    
    $this->SetDrawColor(217, 217, 217);
    $this->Line(10, 116, 200, 116);
 
    $this->Cell(30,6,''.$this->insuranceDescription,0,0);
    $this->Cell(60);
    $this->Cell(30,6,''.$this->numberOfPersons,0,0,'R');
    $this->Cell(40,6,'CHF '.$this->insuranceCostPerPerson,0,0,'R');
    $this->Cell(30,6,'CHF '.$this->insuranceSubtotal,0,1, 'R');
    
    $this->SetDrawColor(0, 0, 0);
    $this->Line(10, 122, 200, 122);
    
    $this->Ln(5);
    $this->Cell(160);
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,4,'Total',0,1,'R');
    $this->Line(177, 131, 200, 131);
    
    $this->SetFont('Arial','',8);
    $this->Cell(160);
    $this->Cell(30,6,'CHF '.$this->totalCost,0,1, 'R');
    
    $this->Ln(5);
    $this->Cell(160);
    $this->SetFont('Arial','BI',8);
    $this->Cell(30,4,'incl. 7,70% VAT',0,1,'R');
    $this->Line(177, 146, 200, 146);
    
    $this->SetFont('Arial','',8);
    $this->Cell(160);
    $this->Cell(30,6,'CHF '.$this->VAT,0,1, 'R');
    
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
    $this->SetFont('Helvetica','BI',30);
    $this->SetTextColor(233, 156, 28);
    $this->Cell(80,15,'CHF '.$this->totalCost,0,0,'R');   

}


}

// invoice id helper class
function serializeInvoiceID($InvoiceID) {
    while (strlen($InvoiceID) < 8) {
        $InvoiceID = "0".$InvoiceID;
    }
    return $InvoiceID;
}

// gender helper
function getGender($gender) {
    if($gender == "male") {
        return "Mr.";
    } else {
        return "Mrs.";
    }
}
// due date calculator 
function getDueDate($date) {
$date = date('Y-m-d',strtotime("+30days",strtotime($date)));
return $date;
}


// Instanciation of inherited class

$pdf = new PDF();

// vars
$pdf->InvoiceID = serializeInvoiceID($trip->getId());
$pdf->customerGender = getGender($trip->getUser()->getGender());
$pdf->customerStreet = $trip->getUser()->getStreet();
$pdf->customerName = $trip->getUser()->getFirstName()." ".$trip->getUser()->getLastName();
$pdf->customerPLZ = $trip->getUser()->getZipCode()." ".$trip->getUser()->getLocation();
$pdf->bookingDate = $trip->getBookingDate();
$pdf->dueDate = getDueDate($trip->getBookingDate());;
$pdf->tripName = $trip->getTripTemplate()->getName();
$pdf->tripDescription = "Trip";
$pdf->numberOfPersons = $trip->getNumOfParticipation();
$pdf->VAT = number_format(round((($trip->getCustomerPrice())/100*7.7),2),2);
$pdf->totalCost  = number_format(round($trip->getCustomerPrice(),2),2);

if($trip->getInsurance()) {
    $pdf->tripCostPerPerson = number_format(round(($trip->getCustomerPrice())/$trip->getNumOfParticipation(),2),2);
    $pdf->tripSubtotal = number_format(($trip->getCustomerPrice()),2);
    $pdf->insuranceDescription = "No insurance";
    $pdf->insuranceSubtotal = "-";
    $pdf->insuranceCostPerPerson  = "-";

} else {
    $pdf->tripCostPerPerson = number_format(round(($trip->getCustomerPrice() - $trip->getInsuranceCustomerPrice())/$trip->getNumOfParticipation(),2),2);
    $pdf->tripSubtotal = number_format(($trip->getCustomerPrice() - $trip->getInsuranceCustomerPrice()),2);
    $pdf->insuranceDescription = "Insurance";
    $pdf->insuranceSubtotal = $trip->getInsuranceCustomerPrice();
    $pdf->insuranceCostPerPerson  = round($trip->getInsuranceCustomerPrice()/$trip->getNumOfParticipation(),2);

}

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->CreateTable();
$pdf->SetTitle('Customer invoice');



$pdf->Output();
ob_end_flush();
?>