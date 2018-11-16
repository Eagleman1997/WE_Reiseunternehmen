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
     * Changes the InvoicesRegistered
     * @return boolean
     */
    public function changeInvoicesRegistered(){
        return $this->tripDBC->changeInvoicesRegistered($this);
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
        return Margin::addTrip($this->price);
    }
    
    public function getInsurancePrice(){
        if(!$this->insurance){
            return false;
        }
        $insurancePrice = $this->insurance->getPricePerPerson() * $this->numOfParticipation;
        return round($insurancePrice * 20, 0) / 20;//round to the nearest 0.05
    }
    
    public function getInsuranceCustomerPrice(){
        if(!$this->insurance){
            return false;
        }
        $insuranceCustomerPrice = Margin::addInsurance($this->insurance->getPricePerPerson() * $this->numOfParticipation);
        return round($insuranceCustomerPrice * 20, 0) / 20;//round to the nearest 0.05
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
