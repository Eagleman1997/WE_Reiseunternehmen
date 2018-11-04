<?php

namespace controllers;

use entities\Bus;
use helpers\Validation;
use helpers\Upload;
use database\BusDBC;

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
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $bus = new Bus();
        
        $bus->setName(filter_input(INPUT_POST, $_POST['name'], FILTER_DEFAULT));
        $bus->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $seats = Validation::positiveInt(filter_input(INPUT_POST, $_POST['seats'], FILTER_VALIDATE_INT));
        if(!$seats){
            return false;
        }
        $bus->setSeats($seats);
        $price = Validation::positivePrice(filter_input(INPUT_POST, $_POST['price'], FILTER_DEFAULT));
        if(!$price){
            return false;
        }
        $bus->setPricePerDay($price);
        $picture = $_FILES['picture'];
        if($picture){
            $bus->setPicturePath(Upload::uploadImage());
        }else{
            $bus->setPicturePath("assets/pictures/defaultBus.jpg");
        }
        
        return $bus->create();
    }
    
    /**
     * Deletes a Bus by the given busId
     * @return boolean
     */
    public static function deleteBus(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $bus = new Bus();
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['busId'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $bus->setId($id);
        
        return $bus->delete();
    }
    
    /**
     * Gets all stored Buses from the database
     * @return boolean|array
     */
    public static function getAllBuses(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $busDBC = new BusDBC();
        
        return $busDBC->getAllBuses();
    }
    
    /**
     * Gets the Bus
     * @return boolean|Bus
     */
    public static function getBus(){
        $bus = new Bus();
        
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['busId'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $bus->setId($id);
        
        return $bus->find();
    }
    
}
