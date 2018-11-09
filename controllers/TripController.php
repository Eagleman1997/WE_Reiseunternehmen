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
        echo "createTripTemplate</br>";
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
            $tripTemplate->setPicturePath("views/assets/img/defaultTrip.jpg");
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
        if($_SESSION['role'] == "admin"){
            echo "getAllTripTemplates (admin)</br>";
            $tripTemplates = $tripDBC->getAllTripTemplates();
            //html toDo
        }else{
            echo "getAllTripTemplates (user & co)</br>";
            $tripTemplates = $tripDBC->getBookableTripTemplates();
            if($_SESSION['login']){
                //html toDo
            }else{
                //html toDo
            }
        }
        
    }
    
    /**
     * Gets the TripTemplate
     * @return boolean|TripTemplate
     */
    public static function getTripTemplate($tripTemplateId){
        echo "getTripTemplate</br>";
        $tripTemplate = new TripTemplate();
        
        $id = Validation::positiveInt($tripTemplateId);
        if(!id){
            return false;
        }
        $tripTemplate->setId($id);
        
        $tripTemplate = $tripTemplate->find();
        
        if($_SESSION['role'] == "admin"){
            //html toDo
        }else{
            if($_SESSION['login']){
                //html toDo
            }else{
                //html toDo
            }
        }
        
    }
    
    /**
     * Deletes the TripTemplate
     * @return boolean
     */
    public static function deleteTripTemplate($tripTemplateId){
        echo "deleteTripTemplate</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $tripTemplate = new TripTemplate();
        $id = Validation::positiveInt($tripTemplateId);
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
        echo "createDayprogram</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        
        //stores the Dayprogram
        $dayprogram = new Dayprogram();
        $fk_tripTemplate_id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripTemplateId'], FILTER_VALIDATE_INT));
        if(!$fk_tripTemplate_id){
            return false;
        }
        $dayprogram->setFkTripTemplateId($fk_tripTemplate_id);
        $dayprogram->setName(filter_input(INPUT_POST, $_POST['name'], FILTER_DEFAULT));
        $dayNumber = Validation::positiveInt(filter_input(INPUT_POST, $_POST['dayNumber'], FILTER_VALIDATE_INT));
        if(!$dayNumber){
            return false;
        }
        $dayprogram->setDayNumber($dayNumber);
        $dayprogram->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $fk_hotel_id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['hotelId'], FILTER_VALIDATE_INT));
        if(!$fk_hotel_id){
            return false;
        }
        $img = $_FILES['img'];
        if($img){
            $dayprogram->setPicturePath(Upload::uploadImage());
        }else{
            $dayprogram->setPicturePath("views/assets/img/defaultDayprogram.jpg");
        }
        
        $success = $dayprogram->create();
        if(!$success){
            return false;
        }
        //storage of dayprograms succeeded
        return true;
    }
    
    /**
     * Deletes the selected Dayprogram
     * @return boolean
     */
    public static function deleteDayprogram($dayprogramId){
        echo "deleteDayprogram</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        
        $dayprogram = new Dayprogram();
        $id = Validation::positiveInt($dayprogramId);
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
    public static function changeBookableOfTripTemplate($tripTemplateId){
        echo "changeBookableOfTripTemplate</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $tripTemplate = new TripTemplate();
        
        $id = Validation::positiveInt($tripTemplateId);
        if(!$id){
            return false;
        }
        $tripTemplate->setId($id);
        
        return $tripTemplate->changeBookable();
    }
    
    /**
     * Books a Trip
     * @return boolean
     */
    public static function bookTrip(){
        echo "bookTrip</br>";
        $trip = new Trip();
        
        $fkTripTemplateId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['tripTemplateId'], FILTER_VALIDATE_INT));
        if(!$fkTripTemplateId){
            return false;
        }
        $trip->setFkTripTemplateId($fkTripTemplateId);
        
        //Adds the participants
        $numOfParticipation = Validation::positiveInt(filter_input(INPUT_POST, $_POST['numOfParticipation'], FILTER_VALIDATE_INT));
        if(!$numOfParticipation){
            return false;
        }
        $participantIds = array();
        for($i = 0; $i < $numOfParticipation; $i++){
            $participantId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['participantId'.$i], FILTER_VALIDATE_INT));
            if(!$participantId){
                return false;
            }
            array_push($participantIds, $participantId);
        }
        $trip->setParticipantIds($participantIds);
        $numOfParticipation++;//To count the User 
        $trip->setNumOfParticipation($numOfParticipation);
        
        $departureDate = Validation::upToDate(filter_input(INPUT_POST, $_POST['departureDate'], FILTER_DEFAULT));
        if(!$departureDate){
            return false;
        }
        $trip->setDepartureDate($departureDate);
        $trip->setFkUserId($_SESSION['userId']);
        if(isset($_POST['insuranceId'])){
            $insuranceId = Validation::positiveInt(filter_input(INPUT_POST, $_POST['insuranceId'], FILTER_VALIDATE_INT));
            if(!$insuranceId){
                return false;
            }
            $trip->setFkInsuranceId($insuranceId);
        }

        return $trip->book();
    }
    
    /**
     * Deletes the Trip
     * @return boolean
     */
    public static function cancelTrip($tripId){
        echo "cancelTrip</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $id = Validation::positiveInt($tripId);
        if(!$id){
            return false;
        }
        $trip = new Trip();
        $trip->setId($id);
        
        return $trip->cancel();
    }
    
    /**
     * Get all booked Trips whether from a user or if an admin is requesting, he/she gets all the booked Trips
     * (Trip and TripTemplate)
     * @return boolean|array
     */
    public static function getBookedTrips(){
        echo "getBookedTrips</br>";
        $tripDBC = new TripDBC();
        if($_SESSION['role'] == "admin"){
            $trips = $tripDBC->getBookedTrips();
            //html toDo
        }else{
            $trips = $tripDBC->getBookedTrips($_SESSION['userId']);
            //html toDo
        }
    }
    
    /**
     * Get the requested booked Trip (TripTemplate, Bus, Hotel, Dayprograms, Insurance inclusive)
     * @return boolean|Trip
     */
    public static function getBookedTrip($tripId){
        echo "getBookedTrip</br>";
        $id = Validation::positiveInt($tripId);
        if(!$id){
            return false;
        }
        $trip = new Trip();
        $trip->setId($id);
        
        $trip = $trip->find();
        
        if($_SESSION['role'] == "admin"){
            //html toDo
        }else{
            //html toDo
        }
    }
    
    /**
     * Changes the InvoiceRegistered
     * @param type $tripId
     * @return boolean
     */
    public static function changeInvoicesRegistered($tripId){
        echo "changeInvoicesRegistered</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $id = Validation::positiveInt($tripId);
        if(!$id){
            return false;
        }
        $trip = new Trip();
        $trip->setId($id);
        
        return $trip->changeInvoicesRegistered();
    }
    
}
