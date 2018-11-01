<?php

namespace entities;

use helpers\database\DBConnection;

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
    private $user;
    private $trip;
    private $dbConnection;
    
    public function __construct() {
        $this->dbConnection = DBConnection::getDBConnection();
    }
    
    /**
     * Stores a new Invoice into the database if the Invoice is valid
     * @return string
     */
    public function recordInvoice(){
        echo "UserId: ".$this->user->getId()."</br>";
        echo "TripId: ".$this->trip->getId()."</br>";
        if($this->price < 0){
            echo "invalidPrice";
            return "invalidPrice";
        }
        if($this->dbConnection->checkBooking($this->user, $this->trip)){
            //Invoice storation is valid
            echo "beforeInsertInvoice";
            return $this->dbConnection->insertInvoice($this);
        }else{
            echo "notBooked";
            return "notBooked";
        }
        
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
    
    public function getUser(){
        return $this->user;
    }
    
    public function getTrip(){
        return $this->trip;
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
    
    public function setUser($user){
        $this->user = $user;
    }

    public function setTrip($trip){
        $this->trip = $trip;
    }
    
}
