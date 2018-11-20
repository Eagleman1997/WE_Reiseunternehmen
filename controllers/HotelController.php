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
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $hotel = new Hotel();
        
        $hotel->setName(\filter_input(\INPUT_POST, 'name', \FILTER_DEFAULT));
        $hotel->setDescription(\filter_input(\INPUT_POST, 'description', \FILTER_DEFAULT));
        $hotelPrice = Validation::positivePrice(\filter_input(\INPUT_POST, 'pricePerPerson', \FILTER_DEFAULT));
        if(!$hotelPrice){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $hotel->setPricePerPerson($hotelPrice);
        if(isset($_FILES['img'])){
            $upload = $hotel->setPicturePath(Upload::uploadImage());
            if(!$upload){
                HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
                return false;
            }
        }else{
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $hotel->create();
    }
    
    /**
     * Deletes the Hotel
     * @return boolean
     */
    public static function deleteHotel($id){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
            return false;
        }
        $hotel = new Hotel();
        
        $id = Validation::positiveInt($id);
        if(!$id){
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
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
        }else{
            HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
        }
    }
}
