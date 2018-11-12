<?php

namespace controllers;

use entities\Bus;
use helpers\Validation;
use helpers\Upload;
use database\BusDBC;
use views\LayoutRendering;
use views\TemplateView;

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
        echo "createBus</br>";
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
            $bus->setPicturePath("views/assets/img/defaultBus.jpg");
        }
        
        return $bus->create();
    }
    
    /**
     * Deletes a Bus by the given busId
     * @return boolean
     */
    public static function deleteBus($busId){
        echo "deleteBus</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $bus = new Bus();
        $id = Validation::positiveInt($busId);
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
        echo "getAllBuses</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $busDBC = new BusDBC();
        
        $buses = $busDBC->getAllBuses();
        //html toDo
    }
    
    /**
     * Gets the Bus
     * @return boolean|Bus
     */
    public static function getBus($id){
        echo "getBus</br>";
        $bus = new Bus();
        
        $id = Validation::positiveInt($id);
        if(!$id){
            return false;
        }
        $bus->setId($id);
        
        $bus = $bus->find();
        //not in use
    }
    
}
