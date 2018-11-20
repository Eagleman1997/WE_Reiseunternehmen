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
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $insurance = new Insurance();
        
        $insurance->setName(\filter_input(\INPUT_POST, 'name', \FILTER_DEFAULT));
        $insurance->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_DEFAULT));
        $pricePerPerson = Validation::positivePrice(\filter_input(\INPUT_POST, 'pricePerPerson', \FILTER_DEFAULT));
        if(!$pricePerPerson){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $insurance->setPricePerPerson($pricePerPerson);
        
        $insurance->create();
    }
    
    /**
     * Deletes the Insurance
     * @return boolean
     */
    public static function deleteInsurance($id){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $insurance = new Insurance();
        
        $id = Validation::positiveInt($id);
        if(!$id){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $insurance->setId($id);
        
        $insurance->delete();
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
        }else{
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
        }
    }
    
}
