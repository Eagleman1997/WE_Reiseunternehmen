<?php

namespace entities;

use database\InvoiceDBC;

/**
 * Invoice Entity
 *
 * @author Lukas
 */
class Invoice {
    
    private $id;
    private $description;
    private $price;
    private $date;
    private $type;
    private $pdfPath;
    private $fk_trip_id;
    private $invoiceDBC;
    
    public function __construct() {
        $this->invoiceDBC = new InvoiceDBC();
    }
    
    /**
     * Creates a new Invoice
     * @return boolean|int
     */
    public function create(){
        return $this->invoiceDBC->createInvoice($this);
    }
    
    /**
     * Deletes the Invoice
     * @return boolean
     */
    public function delete(){
        return $this->invoiceDBC->deleteInvoice($this);
    }
    
    /**
     * Finds the invoice
     * @return boolean|Invoice
     */
    public function find(){
        return $this->invoiceDBC->findInvoiceById($this->id);
    }
    

    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDate() {
        return $this->date;
    }

    public function getType() {
        return $this->type;
    }

    public function getPdfPath() {
        return $this->pdfPath;
    }

    public function getFkTripId() {
        return $this->fk_trip_id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setPdfPath($pdfPath) {
        $this->pdfPath = $pdfPath;
    }

    public function setFkTripId($fk_trip_id) {
        $this->fk_trip_id = $fk_trip_id;
    }
    
}
