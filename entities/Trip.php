<?php

namespace entities;

use database\TripDBC;
use helpers\Margin;
use helpers\Numbers;

/**
 * Trip Entity
 *
 * @author Lukas
 */
class Trip {
    
    private $id;
    private $numOfParticipation;
    private $price;
    private $departureDate;
    private $bookingDate;
    private $invoicesRegistered;
    private $fk_user_id;
    private $fk_insurance_id;
    private $fk_tripTemplate_id;
    private $tripTemplate;
    private $invoices;//array
    private $user;
    private $participantIds;//array
    private $participants;//array
    private $insurance;
    private $tripDBC;
    
    public function __construct() {
        $this->tripDBC = new TripDBC();
    }
    
    /**
     * Stores the Trip into the database
     * @return boolean
     */
    public function book(){
        if($this->numOfParticipation < Numbers::getMinAllocation()){
            $this->numOfParticipation = Numbers::getMinAllocation();
        }
        if($this->numOfParticipation > Numbers::getMaxAllocation()){
            $this->numOfParticipation = Numbers::getMaxAllocation();
        }
        return $this->tripDBC->createTrip($this);
    }
    
    /**
     * Deletes the Trip from the database
     * @return boolean
     */
    public function cancel(){
        return $this->tripDBC->deleteTrip($this);
    }
    
    /**
     * Finds the Trip with the given id
     * @return boolean|Trip
     */
    public function find(){
        return $this->tripDBC->findTripById($this->id);
    }
    
    /**
     * Provides the search for a Trip over the $_SESSION['tripId'] if set
     * @param type $id
     * @return type
     */
    public static function findTrip(){
        $tripDBC = new TripDBC();
        if(isset($_SESSION['tripId'])){
            return $tripDBC->findTripById($_SESSION['tripId']);
        }
        return false;
    }
    
    /**
     * Locks the InvoicesRegistered
     * @return boolean
     */
    public function lockInvoicesRegistered(){
        return $this->tripDBC->lockInvoicesRegistered($this);
    }
    
    /**
     * Unlocks the InvoicesRegistered
     * @return boolean
     */
    public function unlockInvoicesRegistered(){
        return $this->tripDBC->unlockInvoicesRegistered($this);
    }
    
    
    public function getId() {
        return $this->id;
    }

    public function getNumOfParticipation() {
        return $this->numOfParticipation;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDepartureDate() {
        return $this->departureDate;
    }
    
    public function getBookingDate() {
        return $this->bookingDate;
    }
    
    public function getInvoicesRegistered(){
        return $this->invoicesRegistered;
    }

    public function getFkUserId() {
        return $this->fk_user_id;
    }

    public function getFkInsuranceId() {
        return $this->fk_insurance_id;
    }

    public function getFkTripTemplateId() {
        return $this->fk_tripTemplate_id;
    }

    public function getTripTemplate() {
        return $this->tripTemplate;
    }

    public function getInvoices() {
        return $this->invoices;
    }
    
    public function getUser(){
        return $this->user;
    }
    
    public function getParticipantIds(){
        return $this->participantIds;
    }

    public function getParticipants() {
        return $this->participants;
    }
    
    public function getInsurance(){
        return $this->insurance;
    }
    
    public function getCustomerPrice(){
        $customerPrice = 0;
        if($this->tripTemplate){
            $customerPrice += Margin::addTrip(($this->tripTemplate->getPrice() - $this->tripTemplate->getBusPrice()) / $this->tripTemplate->getMinAllocation() * $this->numOfParticipation);
        }
        if($this->insurance){
            $customerPrice += Margin::addInsurance($this->insurance->getPricePerPerson() * $this->numOfParticipation);
        }
        return Numbers::roundPrice($customerPrice);
    }
    
    public function getInsurancePrice(){
        if(!$this->insurance){
            return 0;
        }
        return $this->insurance->getPricePerPerson() * $this->numOfParticipation;
    }
    
    public function getInsuranceCustomerPrice(){
        if(!$this->insurance){
            return 0;
        }
        $insuranceCustomerPrice = Margin::addInsurance($this->insurance->getPricePerPerson() * $this->numOfParticipation);
        return Numbers::roundPrice($insuranceCustomerPrice);
    }
    
    public function getBusPrice(){
        if((!$this->tripTemplate) or (!$this->tripTemplate->getBus())){
            return 0;
        }
        return $this->tripTemplate->getBus()->getPricePerDay() * $this->numOfParticipation;
    }
    
    public function getHotelPrice(){
        if(!$this->tripTemplate){
            return 0;
        }
        return $this->tripTemplate->getHotelPricePerPerson() * $this->numOfParticipation;
    }
    
    public function getInvoicePrice($type = null){
        $invoicePrice = 0;
        //calculates the invoicePrice of all invoices if $type is not set
        if($type == null){
            if(!$this->invoices){
                return $invoicePrice;
            }
            foreach($this->invoices as $invoice){
                $invoicePrice += $invoice->getPrice();
            }
            return $invoicePrice;
        }
        
        //calculates the invoice price of a specific type in case the $type is set
        strtolower($type);
        if((!$this->invoices) or $type != "hotel" or $type != "insurance" or $type != "bus" or $type != "other"){
            return $invoicePrice;
        }
        foreach($this->invoices as $invoice){
            if($invoice->getType() == $type){
                $invoicePrice += $invoice->getPrice();
            }
        }
        return $invoicePrice;
    }
    
    public function setId($id) {
        /* @var $id type int*/
        $this->id = (int) $id;
    }

    public function setNumOfParticipation($numOfParticipation) {
        /* @var $numOfParticipation type int*/
        $this->numOfParticipation = (int) $numOfParticipation;
    }

    public function setPrice($price) {
        /* @var $price type double*/
        $this->price = (double) $price;
    }

    public function setDepartureDate($departureDate) {
        $this->departureDate = $departureDate;
    }
    
    public function setBookingDate($bookingDate) {
        $this->bookingDate = $bookingDate;
    }
    
    public function setInvoicesRegistered($invoicesRegistered){
        $this->invoicesRegistered = $invoicesRegistered;
    }

    public function setFkUserId($fk_user_id) {
        /* @var $fk_user_id type int*/
        $this->fk_user_id = (int) $fk_user_id;
    }

    public function setFkInsuranceId($fk_insurance_id) {
        /* @var $fk_insurance_id type int*/
        $this->fk_insurance_id = (int) $fk_insurance_id;
    }

    public function setFkTripTemplateId($fk_tripTemplate_id) {
        /* @var $fk_tripTemplate_id type int*/
        $this->fk_tripTemplate_id = (int) $fk_tripTemplate_id;
    }

    public function setTripTemplate($tripTemplate) {
        $this->tripTemplate = $tripTemplate;
    }

    public function setInvoices($invoices) {
        $this->invoices = $invoices;
    }
    
    public function setUser($user){
        $this->user = $user;
    }
    
    public function setParticipantIds($participantIds){
        $this->participantIds = $participantIds;
    }

    public function setParticipants($participants) {
        $this->participants = $participants;
    }
    
    public function setInsurance($insurance){
        $this->insurance = $insurance;
    }
 
}
