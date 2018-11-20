<?php

namespace controllers;

use entities\Bus;
use helpers\Validation;
use helpers\Upload;
use database\BusDBC;
use views\LayoutRendering;
use views\TemplateView;
use http\HTTPHeader;
use http\HTTPStatusCode;

/**
 * Description of BusController
 *
 * @author Lukas
 */
class BusController {
    
    /**
     * Creates a new Bus
     * @return boolean|int
     */
    public static function createBus(){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $bus = new Bus();
        
        $bus->setName(\filter_input(\INPUT_POST, 'name', \FILTER_SANITIZE_STRING));
        $bus->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_SANITIZE_STRING));
        $seats = Validation::positiveInt(\filter_input(\INPUT_POST, 'seats', \FILTER_VALIDATE_INT));
        if(!$seats){
            return false;
        }
        $bus->setSeats($seats);
        $pricePerDay = Validation::positivePrice(\filter_input(\INPUT_POST, 'pricePerDay', \FILTER_SANITIZE_STRING));
        if(!$pricePerDay){
            return false;
        }
        $bus->setPricePerDay($pricePerDay);
        if($_FILES['img']){
            $upload = Upload::uploadImage();
            if(!$upload){
                return false;
            }
            $bus->setPicturePath($upload);
        }else{
            return false;
        }
        
        $success = $bus->create();
        if($success){
            return $success;
        }
        return false;
    }
    
    /**
     * Deletes a Bus by the given busId
     * @return boolean
     */
    public static function deleteBus($busId){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $bus = new Bus();
        $id = Validation::positiveInt($busId);
        if(!$id){
            return false;
        }
        $bus->setId($id);
        
        $success = $bus->delete();
        if($success){
            return $success;
        }
        return false;
    }
    
    /**
     * Gets all stored Buses from the database
     * @return boolean|array
     */
    public static function getAllBuses(){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $busDBC = new BusDBC();
            
        $busesView = new TemplateView("adminBuses.php");
        $busesView->buses = $busDBC->getAllBuses();
        LayoutRendering::basicLayout($busesView);
        return true;
    }
    
    /**
     * Gets the Bus
     * @return boolean|Bus
     */
    public static function getBus($id){
        $bus = new Bus();
        
        $id = Validation::positiveInt($id);
        if(!$id){
            return false;
        }
        $bus->setId($id);
        
        $success = $bus->find();
        if($success){
            return $success;
        }
        return false;
        //not in use yet
    }
    
}
