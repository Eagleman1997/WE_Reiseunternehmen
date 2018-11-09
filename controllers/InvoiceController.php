<?php

namespace controllers;

use entities\Invoice;
use database\InvoiceDBC;
use database\TripDBC;
use helpers\Validation;
use helpers\Upload;

/**
 * Controlls the Invoice storage and querys
 *
 * @author Lukas
 */
class InvoiceController{
    
    
    /**
     * Creates an Invoice to the according Trip
     * @return boolean
     */
    public static function createInvoice(){
        echo "createInvoice</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $invoice = new Invoice();
        $invoice->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $price = Validation::positivePrice(filter_input(INPUT_POST, $_POST['price'], FILTER_DEFAULT));
        if(!$price){
            return false;
        }
        $invoice->setPrice($price);
        $date = Validation::date(filter_input(INPUT_POST, $_POST['date'], FILTER_DEFAULT));
        if(!$date){
            return false;
        }
        $invoice->setDate($date);
        $type = Validation::invoiceType(filter_input(INPUT_POST, $_POST['type'], FILTER_DEFAULT));
        if(!$type){
            return false;
        }
        $invoice->setType($type);
        $pdf = $_FILES['invoice'];
        if($pdf){
            $invoice->setPdfPath(Upload::uploadPdf());
        }else{
            $invoice->setPdfPath("views/assets/pdfs/defaultInvoice.jpg");
        }
        $fk_trip_id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT));
        if(!$fk_trip_id){
            return false;
        }
        $invoice->setFkTripId($fk_trip_id);
        
        return $invoice->create();
    }
    
    /**
     * Gets the final Invoice of the Trip if invoiceRegistered is set on the Trip
     */
    public static function getFinalInvoice($tripId){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $id = Validation::positiveInt($tripId);
        if(!$id){
            return false;
        }
        $tripDBC = new TripDBC();
        $trip = $tripDBC->findTripById($tripId);
        if(!$trip){
            return false;
        }
        if(!$trip->getInvoicesRegistered()){
            echo "invoiceRegistered: ".$trip->getInvoicesRegistered();
            //usually InvoiceRegistered is not set
            //AJAX tell the client that InvoiceRegistered is not set
            return false;
        }
        echo "84";
        include 'pdf/finalSettlement.php';
    }
    
    /**
     * Gets a specific Invoice
     * @return boolean|Invoice
     */
    public static function getUsersInvoice($tripId){
        echo "getInvoice</br>";
        $id = Validation::positiveInt($tripId);
        if(!$id){
            return false;
        }
        $tripDBC = new TripDBC();
        $trip = $tripDBC->findTripById($id);
        if(!$trip){
            return false;
        }
        
        //pdf toDo
    }
    
    /**
     * Deletes an Invoice by the given id
     * @return boolean
     */
    public static function deleteInvoice($invoiceId){
        echo "deleteInvoice</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $invoice = new Invoice();
        $id = Validation::positiveInt($invoiceId);
        if(!$id){
            return false;
        }
        $invoice->setId($id);
        
        return $invoice->delete();
    }
    
}
