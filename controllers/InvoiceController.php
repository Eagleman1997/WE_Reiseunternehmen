<?php

namespace controllers;

use entities\Invoice;
use entities\User;
use entities\Trip;
use helpers\database\DBConnection;

/**
 * Controlls the Invoice storage and querys
 *
 * @author Lukas
 */
class InvoiceController{
    
    /**
     * Records an Invoice on the chosen Trip
     */
    public static function createInvoice(){
        $invoice = new Invoice();
        $user = new User();
        $trip = new Trip();
        
        $invoice->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $invoice->setPrice(filter_input(INPUT_POST, $_POST['price'], FILTER_DEFAULT));
        $invoice->setDate(date("Y-m-d"));
        $invoice->setType(filter_input(INPUT_POST, $_POST['type'], FILTER_DEFAULT));
        $trip->setTripId(filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT));
        $invoice->setTrip($trip);
        $user->setId($_SESSION['userId']);
        $invoice->setUser($user);
        
        $result = $invoice->recordInvoice();
        //do something with the result
    }
    
    /**
     * Gets a financial overview of the Invoices of the chosen User and Trip
     * Admins only
     */
    public static function getTripInvoices(){
        $dbConnection = DBConnection::getDBConnection();
        $user = new User();
        $trip = new Trip();
        
        $user->setId(filter_input(INPUT_POST, $_POST['userId'], FILTER_VALIDATE_INT));
        $trip->setTripId(filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT));
        
        $result = $dbConnection->getTripInvoices($user, $trip);
        //do something with the result
    }
    
    public static function deleteInvoice(){
        
    }
    
}
