<?php

namespace controllers;

use entities\Invoice;
use database\InvoiceDBC;
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
        if(!isset($_POST['uploadPdf'])){
            return false;
        }
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
            $invoice->setPdfPath("assets/pictures/defaultInvoice.jpg");
        }
        $fk_trip_id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT));
        if(!$fk_trip_id){
            return false;
        }
        $invoice->setFkTripId($fk_trip_id);
        
        return $invoice->create();
    }
    
    /**
     * Gets an array of the Invoices of the chosen Trip
     * @return boolean|array
     */
    public static function getTripInvoices(){
        $tripId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT));
        if(!$tripId){
            return false;
        }
        $invoiceDBC = new InvoiceDBC();
        return $invoiceDBC->findTripInvoices($tripId);
    }
    
    /**
     * Gets a specific Invoice
     * @return boolean|Invoice
     */
    public static function getInvoice(){
        $invoice = new Invoice();
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['invoiceId'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $invoice->setId($id);
        
        return $invoice->find();
    }
    
    /**
     * Deletes an Invoice by the given id
     * @return boolean
     */
    public static function deleteInvoice(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $invoice = new Invoice();
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['invoiceId'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $invoice->setId($id);
        
        return $invoice->delete();
    }
    
}
