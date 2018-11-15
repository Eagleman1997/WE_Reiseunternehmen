<?php

namespace entities;

use database\TripDBC;
use database\BusDBC;
use helpers\Margin;

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
    private $bookable;
    private $fk_bus_id;
    private $dayprograms;//array
    private $bus;
    private $tripDBC;
    private $busDBC;
    
    public function __construct() {
        $this->tripDBC = new TripDBC();
        $this->busDBC = new BusDBC();
    }
    
    /** (tested)
     * Stores the TripTemplate into the database. The price is set by the busPricePerDay * durationInDays.
     * Maxallocation is set if there is no definition clientside. 
     * Otherwise, validation if seats and maxAllocation will be performed. 
     * If maxAllocation is bigger than the number of seats according to the bus, maxAllocation will be set automatically to seatNumber of the given bus.
     * If minAllocation is bigger than the number of seats according to the bus, minAllocation will be set automatically to seatNumber of the given bus.
     * minAllocation is min 12. maxAllocatin is max 20;
     * @return boolean|int
     */
    public function create(){
        $this->bus = $this->busDBC->findBusById($this->fk_bus_id);
        if(!$this->bus){
            return false;
        }
        if(!$this->maxAllocation or $this->maxAllocation > 20){
            $this->maxAllocation = 20;
        }
        if(!$this->minAllocation or $this->minAllocation < 12){
            $this->minAllocation = 12;
        }
        if($this->bus->getSeats() < $this->maxAllocation){
            //maxAllocation is bigger than busSeats
            $this->maxAllocation = $this->bus->getSeats();
        }
        if($this->minAllocation > $this->bus->getSeats()){
            //minAllocation is bigger than busSeats
            $this->minAllocation = $this->bus->getSeats();
        }
        if($this->getMinAllocation() > $this->getMaxAllocation()){
            return false;
        }
        $this->price = 0.0;
        $this->durationInDays = 0;
        $this->bookable = false;
        return $this->tripDBC->createTripTemplate($this);
    }
    
    /**
     * Deletes the TripTemplate from the database
     * @return boolean
     */
    public function delete(){
        return $this->tripDBC->deleteTripTemplate($this);
    }
    
    /**
     * Finds the TripTemplate by the given id
     * @return boolean|TripTemplate
     */
    public function find(){
        $tripTemplate = $this->tripDBC->findTripTemplateById($this->id);
        if(!$tripTemplate){
            return false;
        }
        $tripTemplate->setDayprograms($this->tripDBC->getDayprogramsFromTemplate($tripTemplate));
        
        return $tripTemplate;
    }
    
    /**
     * Changes (locks or unlocks) the bookable of the TripTemplate
     * @return boolean
     */
    public function changeBookable(){
        return $this->tripDBC->changeBookable($this);
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
    
    public function getBookable() {
        return boolval($this->bookable);
    }

    public function getFkBusId() {
        return $this->fk_bus_id;
    }

    public function getDayprograms() {
        return $this->dayprograms;
    }
    
    public function getBus(){
        return $this->bus;
    }
    
    public function getCustomerPrice(){
        return round(Margin::addTrip($this->price) * 20, 0) / 20;
    }
    
    public function setId($id) {
        /* @var $id type int*/
        $this->id = intval($id);
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setMinAllocation($minAllocation) {
        /* @var $minAllocation type int*/
        $this->minAllocation = intval($minAllocation);
    }

    public function setMaxAllocation($maxAllocation) {
        /* @var $maxAllocation type int*/
        $this->maxAllocation = intval($maxAllocation);
    }

    public function setDurationInDays($durationInDays) {
        /* @var $durationInDays type int*/
        $this->durationInDays = intval($durationInDays);
    }

    public function setPrice($price) {
        /* @var $price type double*/
        $this->price = doubleval($price);
    }

    public function setPicturePath($picturePath) {
        $this->picturePath = $picturePath;
    }
    
    public function setBookable($bookable) {
        /* @var $bookable type  boolean*/
        $this->bookable = boolval($bookable);
    }

    public function setFkBusId($fk_bus_id) {
        /* @var $fk_bus_id type int*/
        $this->fk_bus_id = intval($fk_bus_id);
    }

    public function setDayprograms($dayprograms) {
        $this->dayprograms = $dayprograms;
    }
    
    public function setBus($bus){
        $this->bus = $bus;
    }

}
