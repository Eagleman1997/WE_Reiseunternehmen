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
    private $dbConnection;
    
    function __construct() {
        $this->dbConnection = DBConnection::getDBConnection();
    }
    
    public function storeTrip(){
        if(isset($this)){
            $this->dbConnection->storeTrip($this);
        }
            
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
        /* @var $durationInDays type */
        $this->durationInDays = (int) $durationInDays;
    }


    
}
