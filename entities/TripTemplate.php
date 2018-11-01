<?php

namespace entities;

use database\TripDBC;

/**
 * Description of TripTemplate
 *
 * @author Lukas
 */
class TripTemplate {
    
    private $id;
    private $name;
    private $description;
    private $minAllocation;
    private $maxAllocation;
    private $durationInDays;
    private $price;
    private $picturePath;
    private $fk_bus_id;
    private $dayprograms;//array
    private $bus;
    private $tripDBC;
    
    public function __construct() {
        $this->tripDBC = new TripDBC();
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

    public function getMinAllocation() {
        return $this->minAllocation;
    }

    public function getMaxAllocation() {
        return $this->maxAllocation;
    }

    public function getDurationInDays() {
        return $this->durationInDays;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getPicturePath() {
        return $this->picturePath;
    }

    public function getFk_bus_id() {
        return $this->fk_bus_id;
    }

    public function getDayprograms() {
        return $this->dayprograms;
    }
    
    public function getBus(){
        return $this->bus;
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

    public function setMinAllocation($minAllocation) {
        /* @var $minAllocation type int*/
        $this->minAllocation = (int) $minAllocation;
    }

    public function setMaxAllocation($maxAllocation) {
        /* @var $maxAllocation type int*/
        $this->maxAllocation = (int) $maxAllocation;
    }

    public function setDurationInDays($durationInDays) {
        /* @var $durationInDays type int*/
        $this->durationInDays = (int) $durationInDays;
    }

    public function setPrice($price) {
        /* @var $price type double*/
        $this->price = (double) $price;
    }

    public function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
    }

    public function setFk_bus_id($fk_bus_id) {
        /* @var $fk_bus_id type int*/
        $this->fk_bus_id = (int) $fk_bus_id;
    }

    public function setDayprograms($dayprograms) {
        $this->dayprograms = $dayprograms;
    }
    
    public function setBus($bus){
        $this->bus = $bus;
    }

}
