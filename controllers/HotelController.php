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
        echo "createHotel</br>";
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
            $hotel->setPicturePath("views/assets/img/defaultHotel.jpg");
        }
        return $hotel->create();
    }
    
    /**
     * Deletes the Hotel
     * @return boolean
     */
    public static function deleteHotel($id){
        echo "deleteHotel</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $hotel = new Hotel();
        
        $id = Validation::positiveInt($id);
        if(!$id){
            return false;
        }
        $hotel->setId($id);
        
        return $hotel->delete();
    }
    
    /**
     * Get all Hotels
     * @return boolean
     */
    public static function getAllHotels(){
        echo "getAllHotels</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $hotelDBC = new HotelDBC();
        $hotels = $hotelDBC->findAllHotels();
        //html toDo
    }
}
