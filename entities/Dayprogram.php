<?php

namespace entities;

use database\DBConnection;

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
    private $fk_trip_id;
    private $fk_hotel_id;
    private $dbConnection;
    
    public function __construct() {
        $this->dbConnection = DBConnection::getDBConnection();
    }
    
    public function storeDayprogram(){
        return $this->dbConnection->createDayprogram($this);
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
    
    public function getFkTripId(){
        return $this->fk_trip_id;
    }
    
    public function getFkHotelId(){
        return $this->fk_hotel_id;
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
    
    public function setFkTripId($fk_trip_id){
        $this->fk_trip_id = $fk_trip_id;
    }
    
    public function setFkHotelId($fk_hotel_id){
        $this->fk_hotel_id = $fk_hotel_id;
    }
    
}
