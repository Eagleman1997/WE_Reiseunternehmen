<?php

namespace controllers;

use entities\Hotel;
use helpers\ImageUpload;

/**
 * Description of HotelController
 *
 * @author Lukas
 */
class HotelController {
    
    public static function createHotel(){
        $hotel = new Hotel();
        
        $hotel->setName(filter_input(INPUT_POST, $_POST['name'], FILTER_DEFAULT));
        $hotel->setDescription(filter_input(INPUT_POST, $_POST['description'], FILTER_DEFAULT));
        $hotel->setPricePerPerson(filter_input(INPUT_POST, $_POST['pricePerPerson'], FILTER_DEFAULT));
        $picturePath = $_FILES['picture'];
        if($picturePath){
            $hotel->setPicturePath(ImageUpload::upload());
        }else{
            $hotel->setPicturePath("assets/pictures/defaultHotel.jpg");
        }
        return $hotel->create();
    }
    
    public static function deleteHotel(){
        
    }
    
    public static function getAllHotels(){
        
    }
    
    /**
     * Gets all availabe Hotel-pictures
     */
    public static function hotelCreationView(){
        
    }
    
}
