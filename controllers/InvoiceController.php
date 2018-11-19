<?php

namespace controllers;

use entities\Invoice;
use database\TripDBC;
use helpers\Validation;
use helpers\Upload;
use http\HTTPHeader;
use http\HTTPStatusCode;
use views\LayoutRendering;
use views\TemplateView;

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
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $invoice = new Invoice();
        $fk_trip_id = Validation::positiveInt(\filter_input(\INPUT_POST, 'tripId', \FILTER_VALIDATE_INT));
        if(!$fk_trip_id){
            return false;
        }
        $invoice->setFkTripId($fk_trip_id);
        $invoice->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_DEFAULT));
        $price = Validation::positivePrice(\filter_input(\INPUT_POST, 'price', \FILTER_DEFAULT));
        if(!$price){
            return false;
        }
        $invoice->setPrice($price);
        $date = Validation::date(\filter_input(\INPUT_POST, 'date', \FILTER_DEFAULT));
        if(!$date){
            return false;
        }
        $invoice->setDate($date);
        $type = Validation::invoiceType(\filter_input(\INPUT_POST, 'type', \FILTER_DEFAULT));
        if(!$type){
            return false;
        }
        $invoice->setType($type);
        if(isset($_FILES['invoice'])){
            $invoice->setPdfPath(Upload::uploadPdf());
        }else{
            $invoice->setPdfPath("views/assets/pdfs/defaultInvoice.jpg");
        }
        $fk_trip_id = Validation::positiveInt(\filter_input(\INPUT_POST, 'tripId', \FILTER_VALIDATE_INT));
        if(!$fk_trip_id){
            return false;
        }
        $invoice->setFkTripId($fk_trip_id);
        
        $invoice->create();
        return $fk_trip_id;
    }
    
    /**
     * Gets the final Invoice of the Trip if invoiceRegistered is set on the Trip
     */
    public static function getFinalSettlement($tripId){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
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
            //usually InvoiceRegistered is not set
            //AJAX tell the client that InvoiceRegistered is not set
            return false;
        }
        include 'pdf/finalSettlement.php';
    }
    
    /**
     * Gets a specific Invoice
     * @return boolean|Invoice
     */
    public static function getCustomersInvoice($tripId){
        if(!isset($_SESSION['role'])){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $id = Validation::positiveInt($tripId);
        if(!$id){
            return false;
        }
        $tripDBC = new TripDBC();
        $trip = $tripDBC->findTripById($id);
        if(!$trip){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        if(($trip->getUser()->getId() != $_SESSION['userId']) and ($_SESSION['role'] != "admin")){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $customerInvoice = new TemplateView("pdf/customerInvoice.php");
        $customerInvoice->trip = $trip;
        $customerInvoice->render();
    }
    
    /**
     * Deletes an Invoice by the given id
     * @return boolean
     */
    public static function deleteInvoice($invoiceId){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $invoice = new Invoice();
        $id = Validation::positiveInt($invoiceId);
        if(!$id){
            return false;
        }
        $invoice->setId($id);
        
        $invoice->delete();
    }
    
}
