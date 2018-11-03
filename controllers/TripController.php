<?php

namespace controllers;

use entities\Trip;
use entities\TripTemplate;
use entities\Dayprogram;
use database\TripDBC;
use helpers\Validation;
use helpers\Upload;

/**
 * Controlls the storage and querys of Trips
 *
 * @author Lukas
 */
class TripController {
    
    /**
     * Stores a new TripTemplate
     */
    public static function createTripTemplate(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $tripTemplate = new TripTemplate();
        $tripTemplate->setName(filter_input(INPUT_POST, $_POST['name'], FILTER_DEFAULT));
        $tripTemplate->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $minAllocation = Validation::positiveInt(filter_input(INPUT_POST, $_POST['minAllocation'], FILTER_VALIDATE_INT));
        if(!$minAllocation){
            return false;
        }
        $tripTemplate->setMinAllocation($minAllocation);
        $maxAllocation = Validation::positiveInt(filter_input(INPUT_POST, $_POST['maxAllocation'], FILTER_VALIDATE_INT));
        if(!$maxAllocation){
            return false;
        }
        $tripTemplate->setMaxAllocation($maxAllocation);
        $durationInDays = Validation::positiveInt(filter_input(INPUT_POST, $_POST['durationInDays'], FILTER_VALIDATE_INT));
        if(!$durationInDays){
            return false;
        }
        $tripTemplate->setDurationInDays($durationInDays);
        $picture = $_FILES['picture'];
        if($picture){
            $tripTemplate->setPicturePath(Upload::uploadImage());
        }else{
            $tripTemplate->setPicturePath("assets/pictures/defaultTrip.jpg");
        }
        $fk_bus_id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['busId'], FILTER_VALIDATE_INT));
        if(!$fk_bus_id){
            return false;
        }
        $tripTemplate->setFk_bus_id($fk_bus_id);
        
        return $tripTemplate->create();
    }
    
    /**
     * Gets all TripTemplates (Admins all, the other roles all templates which are finished in creation)
     */
    public static function getAllTripTemplates(){
        $tripDBC = new TripDBC();
        if($_SESSION['role'] != "admin"){
            return $tripDBC->getAllTripTemplates();
        }else{
            return $tripDBC->getBookableTripTemplates();
        }
        
    }
    
    /**
     * Gets the TripTemplate
     * @return boolean|TripTemplate
     */
    public static function getTripTemplate(){
        $tripTemplate = new TripTemplate();
        
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripTemplateId'], FILTER_VALIDATE_INT));
        if(!id){
            return false;
        }
        $tripTemplate->setId($id);
        
        return $tripTemplate->find();
    }
    
    /**
     * Deletes the TripTemplate
     * @return boolean
     */
    public static function deleteTripTemplate(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $tripTemplate = new TripTemplate();
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripTemplateId'], FILTER_VALIDATE_INT));
        if(!id){
            return false;
        }
        $tripTemplate->setId($id);
        
        return $tripTemplate->delete();
    }
    
    /**
     * Stores a Dayprogram into the database
     */
    private static function createDayprogram($tripId){
        
        $numberOfDayprograms = filter_input(INPUT_POST, $_POST['numberOfDayprograms'], FILTER_VALIDATE_INT);
        
        //stores several dayprograms
        for($i = 0; $i < $numberOfDayprograms; $i++){
            $dayprogram = new Dayprogram();
            $dayprogram->setName(filter_input(INPUT_POST, $_POST['name'.$i], FILTER_DEFAULT));
            $dayprogram->setPicturePath(filter_input(INPUT_POST, $_POST['picturePath'.$i], FILTER_DEFAULT));
            $dayprogram->setDayNumber(filter_input(INPUT_POST, $_POST['date'.$i], FILTER_DEFAULT));
            $dayprogram->setDescription(filter_input(INPUT_POST, $_POST['description'.$i], FILTER_DEFAULT));
            $dayprogram->setHotelName(filter_input(INPUT_POST, $_POST['hotelName'.$i], FILTER_DEFAULT));
            $dayprogram->setFkTripTemplateId($tripId);
            
            $dayprogram->storeDayprogram();
        }
        //return html after dayprogram storage
    }
    
    /**
     * Gets the Dayprograms according to the given trip
     */
    public static function getDayprogramsFromTripTemplate(){
        $dbConnection = DBConnection::getDBConnection();
        $tripId = filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT);
        $trip = $dbConnection->getTripById($tripId);
        $trip->addDayprograms();
        //return html of Dayprograms according to the given trip
    }
    
    public static function getAllDayprograms(){
        
    }
    
    public static function deleteDayprogram(){
        
    }
    
    
    
    /**
     * Gets the current (departureDate respected) trips
     */
    public static function getCurrentBookedTrips(){
        $dbConnection = DBConnection::getDBConnection();
        $trips = $dbConnection->findTrips("current");
        //return html of the current trips
    }
    
    public static function getAllBookedTrips(){
        
    }
    
}
