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
    private $dayNumber;
    private $description;
    private $fk_tripTemplate_id;
    private $fk_hotel_id;
    private $hotel;
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

    public function getDayNumber() {
        return $this->dayNumber;
    }

    public function getDescription() {
        return $this->description;
    }
    
    public function getFkTripTemplateId(){
        return $this->fk_tripTemplate_id;
    }
    
    public function getFkHotelId(){
        return $this->fk_hotel_id;
    }
    
    public function getHotel(){
        return $this->hotel;
    }

    public function setId($id) {
        /* @var $id type int*/
        $this->id = (int) $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
    }

    public function setDayNumber($dayNumber) {
        /* @var $dayNumber type int*/
        $this->dayNumber = (int) $dayNumber;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function setFkTripTemplateId($fk_tripTemplate_id){
        /* @var $fk_tripTemplate_id type int*/
        $this->fk_tripTemplate_id = (int) $fk_tripTemplate_id;
    }
    
    public function setFkHotelId($fk_hotel_id){
        /* @var $fk_hotel_id type int*/
        $this->fk_hotel_id = (int) $fk_hotel_id;
    }
    
    public function setHotel($hotel){
        $this->hotel = $hotel;
    }
    
}
