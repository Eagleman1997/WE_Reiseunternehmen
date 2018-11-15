<?php

namespace entities;

use database\InsuranceDBC;
use helpers\Margin;

/**
 * Insurance Entity
 *
 * @author Lukas
 */
class Insurance {
    
    private $id;
    private $name;
    private $description;
    private $pricePerPerson;
    private $insuranceDBC;
    
    public function __construct() {
        $this->insuranceDBC = new InsuranceDBC();
    }
    
    /**
     * Creates the Insurance in the database
     * @return boolean|int
     */
    public function create(){
        return $this->insuranceDBC->createInsurance($this);
    }
    
    /**
     * Deletes the Insurance
     * @return boolean
     */
    public function delete(){
        return $this->insuranceDBC->deleteInsurance($this);
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

    public function getPricePerPerson() {
        return $this->pricePerPerson;
    }
    
    public function getCustomerPricePerPerson(){
        return round(Margin::addInsurance($this->pricePerPerson) * 20, 0) / 20;;
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

    public function setPricePerPerson($pricePerPerson) {
        $this->pricePerPerson = $pricePerPerson;
    }
    
}
