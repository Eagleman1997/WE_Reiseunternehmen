<?php

namespace controllers;

use entities\Hotel;
use database\HotelDBC;
use helpers\Upload;
use helpers\Validation;
use views\LayoutRendering;
use views\TemplateView;
use http\HTTPHeader;
use http\HTTPStatusCode;

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
        
        $hotel->setName(\filter_input(\INPUT_POST, 'name', \FILTER_SANITIZE_STRING));
        $hotel->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_SANITIZE_STRING));
        $hotelPrice = Validation::positivePrice(\filter_input(\INPUT_POST, 'pricePerPerson', \FILTER_SANITIZE_STRING));
        if(!$hotelPrice){
            return false;
        }
        $hotel->setPricePerPerson($hotelPrice);
        if(isset($_FILES['img'])){
            $upload = Upload::uploadImage();
            if(!$upload){
                return false;
            }
            $hotel->setPicturePath($upload);
        }else{
            return false;
        }
        $success = $hotel->create();
        if($success){
            return $success;
        }
        return false;
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
        
        $success = $hotel->delete();
        if($success){
            return $success;
        }
        return false;
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
            return true;
        }else{
            return false;
        }
    }
}
