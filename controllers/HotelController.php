<?php

namespace controllers;

use entities\Hotel;
use database\HotelDBC;
use helpers\Upload;
use helpers\Validation;

/**
 * Controls the actions of a Hotel
 *
 * @author Lukas
 */
class HotelController {
    
    /**
     * Creates a new Hotel
     * @return type
     */
    public static function createHotel(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $hotel = new Hotel();
        
        $hotel->setName(filter_input(INPUT_POST, $_POST['name'], FILTER_DEFAULT));
        $hotel->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $hotelPrice = Validation::positivePrice(filter_input(INPUT_POST, $_POST['pricePerPerson'], FILTER_DEFAULT));
        if(!$hotelPrice){
            return false;
        }
        $hotel->setPricePerPerson($hotelPrice);
        $picture = $_FILES['picture'];
        if($picture){
            $hotel->setPicturePath(Upload::uploadImage());
        }else{
            $hotel->setPicturePath("assets/pictures/defaultHotel.jpg");
        }
        return $hotel->create();
    }
    
    /**
     * Deletes the Hotel
     * @return boolean
     */
    public static function deleteHotel(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $hotel = new Hotel();
        
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['id'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $hotel->setId($id);
        
        return $hotel->delete();
    }
    
    public static function getAllHotels(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $hotelDBC = new HotelDBC();
        return $hotelDBC->findAllHotels();
    }
}
