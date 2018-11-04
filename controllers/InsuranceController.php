<?php

namespace controllers;

use entities\Insurance;
use database\InsuranceDBC;
use helpers\Validation;

/**
 * Description of InsuranceController
 *
 * @author Lukas
 */
class InsuranceController {
    
    /**
     * Creates the Insurance
     * @return boolean|int
     */
    public static function createInsurance(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        if(!isset($_POST['submit'])){
            return false;
        }
        $insurance = new Insurance();
        
        $insurance->setName(filter_input(INPUT_POST, $_POST['name'], FILTER_DEFAULT));
        $insurance->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $pricePerPerson = Validation::positivePrice(filter_input(INPUT_POST, $_POST['pricePerPerson'], FILTER_DEFAULT));
        $insurance->setPricePerPerson($pricePerPerson);
        
        return $insurance->create();
    }
    
    /**
     * Deletes the Insurance
     * @return boolean
     */
    public static function deleteInsurance(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        if(!isset($_POST['submit'])){
            return false;
        }
        $insurance = new Insurance();
        
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['insuranceId'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $insurance->setId($id);
        
        return $insurance->delete();
    }
    
    /**
     * Gets all Insurances
     * @return boolean|array
     */
    public static function getAllInsurances(){
        $insuranceDBC = new InsuranceDBC();
        return $insuranceDBC->getAllInsurances();
    }
    
}
