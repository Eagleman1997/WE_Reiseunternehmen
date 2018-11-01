<?php

namespace entities;

use database\TripDBC;

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
    private $fk_user_id;
    private $fk_insurance_id;
    private $fk_tripTemplate_id;
    private $tripTemplate;
    private $invoices;
    private $participants;
    private $tripDBC;
    
    public function __construct() {
        $this->tripDBC = new TripDBC();
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

    public function getFk_user_id() {
        return $this->fk_user_id;
    }

    public function getFk_insurance_id() {
        return $this->fk_insurance_id;
    }

    public function getFk_tripTemplate_id() {
        return $this->fk_tripTemplate_id;
    }

    public function getTripTemplate() {
        return $this->tripTemplate;
    }

    public function getInvoices() {
        return $this->invoices;
    }

    public function getParticipants() {
        return $this->participants;
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

    public function setFk_user_id($fk_user_id) {
        /* @var $fk_user_id type int*/
        $this->fk_user_id = (int) $fk_user_id;
    }

    public function setFk_insurance_id($fk_insurance_id) {
        /* @var $fk_insurance_id type int*/
        $this->fk_insurance_id = (int) $fk_insurance_id;
    }

    public function setFk_tripTemplate_id($fk_tripTemplate_id) {
        /* @var $fk_tripTemplate_id type int*/
        $this->fk_tripTemplate_id = (int) $fk_tripTemplate_id;
    }

    public function setTripTemplate($tripTemplate) {
        $this->tripTemplate = $tripTemplate;
    }

    public function setInvoices($invoices) {
        $this->invoices = $invoices;
    }

    public function setParticipants($participants) {
        $this->participants = $participants;
    }
 
}
