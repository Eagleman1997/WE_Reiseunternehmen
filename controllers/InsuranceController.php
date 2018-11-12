<?php

namespace controllers;

use entities\Insurance;
use database\InsuranceDBC;
use helpers\Validation;
use views\LayoutRendering;
use views\TemplateView;

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
        echo "createInsurance</br>";
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
    public static function deleteInsurance($id){
        echo "deleteInsurance</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $insurance = new Insurance();
        
        $id = Validation::positiveInt($id);
        if(!$id){
            return false;
        }
        $insurance->setId($id);
        
        return $insurance->delete();
    }
    
    /**
     * Gets all Insurances
     */
    public static function getAllInsurances(){
        echo "getAllInsurances</br>";
        $insuranceDBC = new InsuranceDBC();
        $insurances = $insuranceDBC->getAllInsurances();
        //html toDo
    }
    
}
