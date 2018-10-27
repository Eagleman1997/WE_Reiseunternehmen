<?php

namespace controllers;

use entities\Trip;

/**
 * Controlls the storage and querys of Trips
 *
 * @author Lukas
 */
class TripController {
    
    public static function storeTrip(){
        $trip = new Trip();
        $trip->setName($_SESSION['name']);
        $trip->setPicturePath($_SESSION['picturePath']);
        $trip->setDescription($_SESSION['description']);
        $trip->setDepartureDate($_SESSION['departureDate']);
        $trip->setPrice($_SESSION['price']);
        $trip->setDurationInDays($_SESSION['durationInDays']);
        
        $trip->storeTrip();
        //return html after trip storage
    }
    
}
