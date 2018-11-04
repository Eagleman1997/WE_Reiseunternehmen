<?php

namespace database;

use entities\Invoice;
use entities\Trip;

/**
 * Description of InvoiceDBC
 *
 * @author Lukas
 */
class InvoiceDBC extends DBConnector {
    
    /** (tested)
     * Creates a new Invoice in the database according to the Trip
     * @param type $invoice
     * @return boolean|int
     */
    public function createInvoice($invoice){
        //Validation if the Trip was booked
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM trip WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $tripId);
        $tripId = $invoice->getFkTripId();
        $stmt->execute();
        $success = $stmt->get_result()->fetch_object("entities\Trip");
        $stmt->close();
        if(!$success){
            return false;
        }
        
        //Storage of the Invoice
        $stmt = $this->mysqliInstance->prepare("INSERT INTO invoice VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sdsssi', $description, $price, $date, $type, $pdfPath, $fk_trip_id);
        $description = $invoice->getDescription();
        $price = $invoice->getPrice();
        $date = $invoice->getDate();
        $type = $invoice->getType();
        $pdfPath = $invoice->getPdfPath();
        $fk_trip_id = $invoice->getFkTripId();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Deletes the Invoice from the database
     * @param type $invoice
     * @return boolean
     */
    public function deleteInvoice($invoice){
        $stmt = $this->mysqliInstance->prepare("DELETE FROM invoice WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $invoice->getId();
        return $this->executeDelete($stmt);
    }
    
    /** (tested)
     * Finds the Invoice by the given id
     * @param type $invoiceId
     * @return boolean|Invoice
     */
    public function findInvoiceById($invoiceId, $close = true){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM invoice where id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $invoiceId;
        $stmt->execute();
        $invoiceObj = $stmt->get_result()->fetch_object("entities\Invoice");
        
        if($close){
            $stmt->close();
        }
        
        //checks whether the Invoice exists
        if($invoiceObj){
            return $invoiceObj;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Finds all Invoices according to the given tripId
     * @param type $tripId
     * @return boolean|array
     */
    public function findTripInvoices($tripId){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM invoice WHERE fk_trip_id = ? ORDER BY type ASC");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $tripId;
        $stmt->execute();
        $invoices = array();
        $result = $stmt->get_result();
        while($invoice = $result->fetch_object("entities\Invoice")){
            array_push($invoices, $invoice);
        }

        $stmt->close();
        return $invoices;
    }
    
}
