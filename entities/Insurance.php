<?php

namespace entities;

use helpers\database\DBConnection;

/**
 * Insurance Entity
 *
 * @author Lukas
 */
class Insurance {
    
    private $id;
    private $name;
    private $description;
    private $price;
    private $dbConnection;
    
    public function __construct() {
        $this->dbConnection = DBConnection::getDBConnection();
    }
    
    public function storeInsurance(){
        $this->dbConnection->insertInsurance($this);
    }

    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setPrice($price) {
        $this->price = $price;
    }
    
}
