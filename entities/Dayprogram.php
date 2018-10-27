<?php

namespace entities;

use helpers\database\DBConnection;

/**
 * Dayprogram Entity
 *
 * @author Lukas
 */
class Dayprogram {
    
    private $id;
    private $name;
    private $picturePath;
    private $date;
    private $description;
    private $hotelName;
    private $fk_trip_id;
    private $dbConnection;
    
    public function __construct() {
        $this->dbConnection = DBConnection::getDBConnection();
    }
    
    public function storeDayprogram(){
        $this->dbConnection->storeDayprogram($this);
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

    public function getDate() {
        return $this->date;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getHotelName() {
        return $this->hotelName;
    }
    
    public function getFkTripId(){
        return $this->fk_trip_id;
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

    public function setDate($date) {
        $this->date = $date;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setHotelName($hotelName) {
        $this->hotelName = $hotelName;
    }
    
    public function setFkTripId($fkTripId){
        $this->fk_trip_id = $fkTripId;
    }
    
}
