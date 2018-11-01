<?php

namespace controllers;

use entities\Trip;
use entities\Dayprogram;
use helpers\database\DBConnection;

/**
 * Controlls the storage and querys of Trips
 *
 * @author Lukas
 */
class TripController {
    
    /**
     * Stores a Trip and the according Dayprograms into the database
     */
    public static function createTripTemplate(){
        $trip = new Trip();
        $trip->setName(filter_input(INPUT_POST, $_POST['name'], FILTER_DEFAULT));
        $trip->setPicturePath(filter_input(INPUT_POST, $_POST['picturePath'], FILTER_DEFAULT));
        $trip->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $trip->setDepartureDate(filter_input(INPUT_POST, $_POST['departureDate'], FILTER_DEFAULT));
        $trip->setPricePerPerson(filter_input(INPUT_POST, $_POST['price'], FILTER_DEFAULT));
        $trip->setDurationInDays(filter_input(INPUT_POST, $_POST['durationInDays'], FILTER_VALIDATE_INT));
        $trip->setMaxAllocation(filter_input(INPUT_POST, $_POST['maxStaffing'], FILTER_VALIDATE_INT));
        
        $tripId = $trip->storeTrip();
        TripController::createDayprogram($tripId);
    }
    
    /**
     * Gets the free (respecting maxStaffing and departureDate) trips
     */
    public static function getAllTripTemplates(){
        $dbConnection = DBConnection::getDBConnection();
        $trips = $dbConnection->findTrips("bookable");
        //return html of free trips
    }
    
    public static function getTripTemplate(){
        
    }
    
    public static function deleteTripTemplate(){
        
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
            $dayprogram->setDate(filter_input(INPUT_POST, $_POST['date'.$i], FILTER_DEFAULT));
            $dayprogram->setDescription(filter_input(INPUT_POST, $_POST['description'.$i], FILTER_DEFAULT));
            $dayprogram->setHotelName(filter_input(INPUT_POST, $_POST['hotelName'.$i], FILTER_DEFAULT));
            $dayprogram->setFkTripId($tripId);
            
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
