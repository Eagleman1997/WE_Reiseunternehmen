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
        $tripTemplate->setFkBusId($fk_bus_id);
        
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
     * Stores any number of Dayprograms in relation to the TripTemplate and Hotel
     * @return boolean
     */
    public static function createDayprogram(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $numberOfDayprograms = Validation::positiveInt(filter_input(INPUT_POST, $_POST['numberOfDayprograms'], FILTER_VALIDATE_INT));
        if(!$numberOfDayprograms){
            return false;
        }
        
        //stores several dayprograms
        $fk_tripTemplate_id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripTemplateId'.$i], FILTER_VALIDATE_INT));
        if(!$fk_tripTemplate_id){
            return false;
        }

        //stores the Dayprograms
        for($i = 0; $i < $numberOfDayprograms; $i++){
            $dayprogram = new Dayprogram();
            $dayprogram->setName(filter_input(INPUT_POST, $_POST['name'.$i], FILTER_DEFAULT));
            $dayNumber = Validation::positiveInt(filter_input(INPUT_POST, $_POST['dayNumber'.$i], FILTER_VALIDATE_INT));
            if(!$dayNumber){
                return false;
            }
            $dayprogram->setDayNumber($dayNumber);
            $dayprogram->setDescription(filter_input(INPUT_POST, $_POST['description'.$i], FILTER_DEFAULT));
            $dayprogram->setFkTripTemplateId($fk_tripTemplate_id);
            $fk_hotel_id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['hotelId'.$i], FILTER_VALIDATE_INT));
            if(!$fk_hotel_id){
                return false;
            }
            $picture = $_FILES['picture'.$i];
            if($picture){
                $dayprogram->setPicturePath(Upload::uploadImage());
            }else{
                $dayprogram->setPicturePath("assets/pictures/defaultDayprogram.jpg");
            }
            
            $success = $dayprogram->create();
            if(!$success){
                return false;
            }
        }
        //storage of dayprograms succeeded
        return true;
    }
    
    /**
     * Deletes the selected Dayprogram
     * @return boolean
     */
    public static function deleteDayprogram(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        
        $dayprogram = new Dayprogram();
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['dayprogramId'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $dayprogram->setId($id);
        
        return $dayprogram->delete();
    }
    
    /**
     * Changes the bookable of the TripTemplate
     * @return boolean
     */
    public static function changeBookableOfTripTemplate(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        if(isset($_POST['bookable'])){
            $tripDBC = new TripDBC();
            $tripTemplate = new TripTemplate();
            
            $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripTemplateId'], FILTER_VALIDATE_INT));
            if(!$id){
                return false;
            }
            $tripTemplate->setId($id);
            
            return $tripTemplate->changeBookable();
        }
    }
    
    /**
     * Books a Trip
     * @return boolean
     */
    public static function bookTrip(){
        if(!isset($_POST['submit'])){
            return false;
        }
        $fkTripTemplateId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripTemplateId'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $trip = new Trip();
        $numOfParticipation = Validation::positiveInt(filter_input(INPUT_POST, $_POST['numOfParticipation'], FILTER_VALIDATE_INT));
        if(!$numOfParticipation){
            return false;
        }
        $numOfParticipation++;//To count the User 
        $trip->setNumOfParticipation($numOfParticipation);
        $departureDate = Validation::upToDate(filter_input(INPUT_POST, $_POST['departureDate'], FILTER_DEFAULT));
        if(!$departureDate){
            return false;
        }
        $trip->setDepartureDate($departureDate);
        $trip->setFkUserId($_SESSION['userId']);
        $trip->setFkTripTemplateId($fkTripTemplateId);
        if(isset($_POST['insuranceId'])){
            $insuranceId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['insuranceId'], FILTER_VALIDATE_INT));
            if(!$insuranceId){
                return false;
            }
            $trip->setFkInsuranceId($insuranceId);
        }
        
        $participantIds = array();
        for($i = 0; $i < $numOfParticipation - 1; $i++){
            $participantId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['participantId'.$i], FILTER_VALIDATE_INT));
            if(!$participantId){
                return false;
            }
            array_push($participantIds, $participantId);
        }
        $trip->setParticipantIds($participantIds);
        
        return $trip->book();
    }
    
    /**
     * Deletes the Trip
     * @return boolean
     */
    public static function cancelTrip(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $tripId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT));
        if(!$tripId){
            return false;
        }
        $trip = new Trip();
        $trip->setId($tripId);
        
        return $trip->cancel();
    }
    
    /**
     * Get all booked Trips whether from a user or if an admin is requesting, he/she gets all the booked Trips
     * (Trip and TripTemplate)
     * @return boolean|array
     */
    public static function getBookedTrips(){
        $tripDBC = new TripDBC();
        if($_SESSION['role'] == "admin"){
            return $tripDBC->getBookedTrips();
        }else{
            return $tripDBC->getBookedTrips($_SESSION['userId']);
        }
    }
    
    /**
     * Get the requested booked Trip (TripTemplate, Bus, Hotel, Dayprograms, Insurance inclusive)
     * @return boolean|Trip
     */
    public static function getBookedTrip(){
        $tripId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT));
        if(!$tripId){
            return false;
        }
        $trip = new Trip();
        $trip->setId($tripId);
        
        return $trip->find();
    }
    
}
