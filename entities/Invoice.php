<?php


namespace entities;

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


    
}
