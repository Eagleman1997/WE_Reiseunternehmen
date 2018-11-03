<?php

namespace entities;

use database\BusDBC;

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
    private $pricePerDay;
    private $picturePath;
    private $busDBC;
    
    public function __construct() {
        $this->busDBC = new BusDBC();
    }
    
    /**
     * Stores the Bus into the database
     * @return type
     */
    public function create(){
        return $this->busDBC->createBus($this);
    }
    
    /**
     * Gets the Bus from the database by the set id
     * @return type boolean|Bus
     */
    public function find(){
        return $this->busDBC->findBusById($this->id);
    }
    
    /**
     * Deletes the Bus from the database
     * @return type
     */
    public function delete(){
        return $this->busDBC->deleteBus($this);
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

    public function getPricePerDay() {
        return $this->pricePerDay;
    }

    public function getPicturePath() {
        return $this->picturePath;
    }

    public function setId($id) {
        /* @var $id type int*/
        $this->id = (int) $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setSeats($seats) {
        /* @var $seats type int*/
        $this->seats = (int) $seats;
    }

    public function setPricePerDay($pricePerDay) {
        /* @var $pricePerDay type double*/
        $this->pricePerDay = (double) $pricePerDay;
    }

    public function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
    }

}
