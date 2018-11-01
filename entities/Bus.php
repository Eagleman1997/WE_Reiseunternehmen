<?php

namespace entities;

/**
 * Description of Bus
 *
 * @author Lukas
 */
class Bus {
    
    private $id;
    private $name;
    private $description;
    private $seats;
    private $price;
    private $picturePath;
    
    public function __construct() {
        
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

    public function getSeats() {
        return $this->seats;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPicturePath() {
        return $this->picturePath;
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

    public function setSeats($seats) {
        $this->seats = $seats;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
    }

}
