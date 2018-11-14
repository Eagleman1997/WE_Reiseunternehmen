<?php

namespace controllers;

use entities\Trip;
use entities\TripTemplate;
use entities\Dayprogram;
use database\TripDBC;
use database\BusDBC;
use database\HotelDBC;
use helpers\Validation;
use helpers\Upload;
use views\LayoutRendering;
use views\TemplateView;

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
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $tripTemplate = new TripTemplate();
        $tripTemplate->setName(\filter_input(\INPUT_POST, 'name', \FILTER_DEFAULT));
        $tripTemplate->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_DEFAULT));
        $minAllocation = Validation::positiveInt(\filter_input(\INPUT_POST, 'minAllocation', \FILTER_VALIDATE_INT));
        if(!$minAllocation){
            return false;
        }
        $tripTemplate->setMinAllocation($minAllocation);
        $maxAllocation = Validation::positiveInt(\filter_input(\INPUT_POST, 'maxAllocation', \FILTER_VALIDATE_INT));
        if(!$maxAllocation){
            return false;
        }
        $tripTemplate->setMaxAllocation($maxAllocation);
        if(isset($_FILES['img'])){
            $tripTemplate->setPicturePath(Upload::uploadImage());
        }else{
            $tripTemplate->setPicturePath("views/assets/img/defaultTrip.jpg");
        }
        $fk_bus_id = Validation::positiveInt(\filter_input(\INPUT_POST, 'busId', \FILTER_VALIDATE_INT));
        if(!$fk_bus_id){
            return false;
        }
        $tripTemplate->setFkBusId($fk_bus_id);
        
        $tripTemplate->create();
    }
    
    /**
     * Gets all TripTemplates (Admins all, the other roles all templates which are finished in creation)
     */
    public static function getAllTrips(){
        $tripDBC = new TripDBC();
        $homepage = new TemplateView("allTrips.php");
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $homepage->tripTemplates = $tripDBC->getAllTripTemplates();
            $homepage->trips = $tripDBC->getBookedTrips();
            LayoutRendering::basicLayout($homepage);
        }else{
            $homepage->tripTemplates = $tripDBC->getBookableTripTemplates();
            if(isset($_SESSION['login'])){
                LayoutRendering::basicLayout($homepage, "headerUserLoggedIn");
                $homepage->trips = $tripDBC->getBookedTrips($_SESSION['userId']);
            }else{
                LayoutRendering::basicLayout($homepage, "headerLoggedOut");
            }
        }
        
    }
    
    /**
     * Gets to the admins TripTemplate overview
     */
    public static function getAllTripTemplates(){
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $tripDBC = new TripDBC();
            $busDBC = new BusDBC();
            $tripTemplates = new TemplateView("adminTripTemplates.php");
            $tripTemplates->buses = $busDBC->getAllBuses();
            $tripTemplates->tripTemplates = $tripDBC->getAllTripTemplates();
            LayoutRendering::basicLayout($tripTemplates);
        }
    }
    
    /**
     * Gets the TripTemplate
     * @return boolean|TripTemplate
     */
    public static function getTripTemplate($tripTemplateId){
        $tripTemplate = new TripTemplate();
        $id = Validation::positiveInt($tripTemplateId);
        if(!$id){
            return false;
        }
        $tripTemplate->setId($id);
        
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $hotelDBC = new HotelDBC();
            $adminTripOverview = new TemplateView("adminUnbookedTripOverview.php");
            $adminTripOverview->tripTemplate = $tripTemplate->find();
            $adminTripOverview->hotels = $hotelDBC->findAllHotels();
            LayoutRendering::basicLayout($adminTripOverview);
        }else{
            $userTripOverview = new TemplateView("userUnbookedTripOverview.php");
            $userTripOverview->tripTemplate = $tripTemplate->find();
            if(isset($_SESSION['login'])){
                LayoutRendering::basicLayout($userTripOverview, "headerUserLoggedIn");
            }else{
                LayoutRendering::basicLayout($userTripOverview, "headerLoggedOut");
            }
        }
        
    }
    
    /**
     * Deletes the TripTemplate
     * @return boolean
     */
    public static function deleteTripTemplate($tripTemplateId){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $tripTemplate = new TripTemplate();
        $id = Validation::positiveInt($tripTemplateId);
        if(!id){
            return false;
        }
        $tripTemplate->setId($id);
        
        $tripTemplate->delete();
    }
    
    /**
     * Stores any number of Dayprograms in relation to the TripTemplate and Hotel
     * @return boolean
     */
    public static function createDayprogram(){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        
        //stores the Dayprogram
        $dayprogram = new Dayprogram();
        $fk_tripTemplate_id = Validation::positiveInt(\filter_input(\INPUT_POST, 'tripTemplateId', \FILTER_VALIDATE_INT));
        if(!$fk_tripTemplate_id){
            return false;
        }
        $dayprogram->setFkTripTemplateId($fk_tripTemplate_id);
        $dayprogram->setName(\filter_input(\INPUT_POST, 'name', \FILTER_DEFAULT));
        $dayNumber = Validation::positiveInt(\filter_input(\INPUT_POST, 'dayNumber', \FILTER_VALIDATE_INT));
        if(!$dayNumber){
            return false;
        }
        $dayprogram->setDayNumber($dayNumber);
        $dayprogram->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_DEFAULT));
        $fk_hotel_id = Validation::positiveInt(\filter_input(\INPUT_POST, 'hotelId', \FILTER_VALIDATE_INT));
        if(!$fk_hotel_id){
            return false;
        }
        $dayprogram->setFkHotelId($fk_hotel_id);
        $img = $_FILES['img'];
        if($img){
            $dayprogram->setPicturePath(Upload::uploadImage());
        }else{
            $dayprogram->setPicturePath("views/assets/img/defaultDayprogram.jpg");
        }
        
        $dayprogram->create();
        return $fk_tripTemplate_id;//to ensure correct routing
    }
    
    /**
     * Deletes the selected Dayprogram
     * @return boolean
     */
    public static function deleteDayprogram($dayprogramId){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
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
     * Get the requested booked Trip (TripTemplate, Bus, Hotel, Dayprograms, Insurance inclusive)
     */
    public static function getBookedTrip($tripId){
        $id = Validation::positiveInt($tripId);
        if(!$id){
            return false;
        }
        $trip = new Trip();
        $trip->setId($id);
        
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $adminBookedTripOverview = new TemplateView("adminBookedTripOverview.php");
            $adminBookedTripOverview->trip = $trip->find();
            LayoutRendering::basicLayout($adminBookedTripOverview);
        }else{
            $userBookedTripOverview = new TemplateView("userBookedTripOverview.php");
            $userBookedTripOverview->trip = $trip->find();
            LayoutRendering::basicLayout($userBookedTripOverview);
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
