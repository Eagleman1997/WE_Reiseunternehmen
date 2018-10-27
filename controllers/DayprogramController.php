<?php

namespace controllers;

use entities\Dayprogram;

/**
 * Controls the storage and querys of the day programs
 *
 * @author Lukas
 */
class DayprogramController {
    
    public static function storeDayprogram(){
        
        $numberOfDayprograms = filter_input(INPUT_POST, $_POST['numberOfDayprograms'], FILTER_VALIDATE_INT);
        
        //stores several dayprograms
        for($i = 0; $i < $numberOfDayprograms; $i++){
            $dayprogram = new Dayprogram();
            $dayprogram->setName(filter_input(INPUT_POST, $_POST['name'.$i], FILTER_DEFAULT));
            $dayprogram->setPicturePath(filter_input(INPUT_POST, $_POST['picturePath'.$i], FILTER_DEFAULT));
            $dayprogram->setDate(filter_input(INPUT_POST, $_POST['date'.$i], FILTER_DEFAULT));
            $dayprogram->setDescription(filter_input(INPUT_POST, $_POST['description'.$i], FILTER_DEFAULT));
            $dayprogram->setHotelName(filter_input(INPUT_POST, $_POST['hotelName'.$i], FILTER_DEFAULT));
            $dayprogram->setFkTripId($_SESSION['tripId']);
            
            $dayprogram->storeDayprogram();
        }
        //return html after dayprogram storage
    }
    
}
