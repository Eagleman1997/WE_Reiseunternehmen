<?php

namespace controllers;

use entities\Hotel;
use database\HotelDBC;
use helpers\Upload;
use helpers\Validation;
use views\LayoutRendering;
use views\TemplateView;

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
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $hotel = new Hotel();
        
        $hotel->setName(\filter_input(\INPUT_POST, 'name', \FILTER_DEFAULT));
        $hotel->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_DEFAULT));
        $hotelPrice = Validation::positivePrice(\filter_input(\INPUT_POST, 'pricePerPerson', \FILTER_DEFAULT));
        if(!$hotelPrice){
            return false;
        }
        $hotel->setPricePerPerson($hotelPrice);
        if(isset($_FILES['img'])){
            $hotel->setPicturePath(Upload::uploadImage());
        }else{
            $hotel->setPicturePath("views/assets/img/defaultHotel.jpg");
        }
        $hotel->create();
    }
    
    /**
     * Deletes the Hotel
     * @return boolean
     */
    public static function deleteHotel($id){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $hotel = new Hotel();
        
        $id = Validation::positiveInt($id);
        if(!$id){
            return false;
        }
        $hotel->setId($id);
        
        $hotel->delete();
    }
    
    /**
     * Get all Hotels
     * @return boolean
     */
    public static function getAllHotels(){
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $hotelDBC = new HotelDBC();
            
            $hotelView = new TemplateView("adminHotels.php");
            $hotelView->hotels = $hotelDBC->findAllHotels();
            LayoutRendering::basicLayout($hotelView);
        }
    }
}
