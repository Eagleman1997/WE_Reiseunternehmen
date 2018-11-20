<?php

namespace controllers;

use entities\Insurance;
use database\InsuranceDBC;
use helpers\Validation;
use views\LayoutRendering;
use views\TemplateView;
use http\HTTPHeader;
use http\HTTPStatusCode;

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
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $insurance = new Insurance();
        
        $insurance->setName(\filter_input(\INPUT_POST, 'name', \FILTER_SANITIZE_STRING));
        $insurance->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_SANITIZE_STRING));
        $pricePerPerson = Validation::positivePrice(\filter_input(\INPUT_POST, 'pricePerPerson', \FILTER_SANITIZE_STRING));
        if(!$pricePerPerson){
            return false;
        }
        $insurance->setPricePerPerson($pricePerPerson);
        
        $success = $insurance->create();
        if($success){
            return $success;
        }
        return false;
    }
    
    /**
     * Deletes the Insurance
     * @return boolean
     */
    public static function deleteInsurance($id){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $insurance = new Insurance();
        
        $id = Validation::positiveInt($id);
        if(!$id){
            return false;
        }
        $insurance->setId($id);
        
        $success = $insurance->delete();
        if($success){
            return $success;
        }
        return false;
    }
    
    /**
     * Gets all Insurances
     */
    public static function getAllInsurances(){
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $insuranceDBC = new InsuranceDBC();
            
            $insuranceView = new TemplateView("adminInsurances.php");
            $insuranceView->insurances = $insuranceDBC->getAllInsurances();
            LayoutRendering::basicLayout($insuranceView);
            return true;
        }else{
            return false;
        }
    }
    
}
