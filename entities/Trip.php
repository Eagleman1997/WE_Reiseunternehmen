<?php

namespace entities;

use helpers\database\DBConnection;

/**
 * Trip Entity
 *
 * @author Lukas
 */
class Trip {
    
    private $id;
    private $name;
    private $picturePath;
    private $description;
    private $departureDate;
    private $price;
    private $durationInDays;
    private $maxStaffing;
    private $staffedUsers;
    private $dayprograms;//array
    private $dbConnection;
    
    function __construct() {
        $this->dbConnection = DBConnection::getDBConnection();
    }
    
    public function storeTrip(){
        $_SESSION['tripId'] = $this->dbConnection->storeTrip($this);    
    }
    
    public function addDayprograms(){
        $this->dayprograms = $this->dbConnection->getDayprogramsByTrip($this);
    }

    
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPicturePath() {
        return $this->picturePath;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getDepartureDate() {
        return $this->departureDate;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getDurationInDays() {
        return $this->durationInDays;
    }
    
    public function getMaxStaffing(){
        return $this->maxStaffing;
    }
    
    public function getDayprograms(){
        return $this->dayprograms;
    }
    
    public function getStaffedUsers(){
        return $this->staffedUsers;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setDepartureDate($departureDate) {
        $this->departureDate = $departureDate;
    }

    public function setPrice($price) {
        /* @var $price type double */
        $this->price = (double) $price;
    }

    public function setDurationInDays($durationInDays) {
        /* @var $durationInDays type int */
        $this->durationInDays = (int) $durationInDays;
    }
    
    public function setMaxStaffing($maxStaffing){
        /* @var $durationInDays type int */
        $this->maxStaffing = (int) $maxStaffing;
    }
    
    public function setStaffedUsers($staffedUsers){
        $this->staffedUsers = $staffedUsers;
    }
 
}
