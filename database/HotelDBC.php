<?php

namespace database;

use entities\Hotel;

/**
 * Description of HotelDBC
 *
 * @author Lukas
 */
class HotelDBC extends DBConnector {
    
    /** (tested)
     * Creates a new Hotel
     * @param type $hotel
     * @return boolean
     */
    public function createHotel($hotel){
        $stmt = $this->mysqliInstance->prepare("INSERT INTO hotel VALUES (NULL, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssds', $name, $description, $pricePerPerson, $picturePath);
        $name = $hotel->getName();
        $description = $hotel->getDescription();
        $pricePerPerson = $hotel->getPricePerPerson();
        $picturePath = $hotel->getPicturePath();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Deletes a Hotel by the given id
     * @param type $hotel
     * @return boolean
     */
    public function deleteHotel($hotel){
        $hotel = $this->findHotelById($hotel->getId());
        if(!$hotel){
            return false;
        }
        $stmt = $this->mysqliInstance->prepare("DELETE FROM hotel WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $hotel->getId();
        $result = $this->executeDelete($stmt);
        $picturePath = $hotel->getPicturePath();
        if(file_exists($picturePath)  and strpos($picturePath, 'default') == false){
            unlink($picturePath);
        }
        return $result;
    }
    
    /** (tested)
     * Finds all Hotels ordered by name asc
     * @return boolean|array
     */
    public function findAllHotels(){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM hotel ORDER BY name ASC");
        if(!$stmt){
            return false;
        }
        $stmt->execute();
        $hotels = array();
        $result = $stmt->get_result();
        while($hotel = $result->fetch_object("entities\Hotel")){
            array_push($hotels, $hotel);
        }
        
        $stmt->close();
        return $hotels;
    }
    
    /**
     * Finds the Hotel by the given id
     * @param type $hotelId
     * @param type $close (false if closing of the database connection is NOT desired)
     * @return boolean
     */
    public function findHotelById($hotelId, $close = true){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM hotel where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $hotelId;
        $stmt->execute();
        $hotelObj = $stmt->get_result()->fetch_object("entities\Hotel");
        
        if($close){
            $stmt->close();
        }
        
        //checks whether the User exists
        if($hotelObj){
            return $hotelObj;
        }else{
            return false;
        }
    }
    
    
}
