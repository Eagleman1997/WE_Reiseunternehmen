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
        $trip->setName(filter_input(INPUT_POST, $_POST['name'], FILTER_DEFAULT));
        $trip->setPicturePath(filter_input(INPUT_POST, $_POST['picturePath'], FILTER_DEFAULT));
        $trip->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $trip->setDepartureDate(filter_input(INPUT_POST, $_POST['departureDate'], FILTER_DEFAULT));
        $trip->setPrice(filter_input(INPUT_POST, $_POST['price'], FILTER_DEFAULT));
        $trip->setDurationInDays(filter_input(INPUT_POST, $_POST['durationInDays'], FILTER_VALIDATE_INT));
        
        $trip->storeTrip();
    }
    
}
