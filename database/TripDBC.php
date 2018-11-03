<?php

namespace database;

use entities\Trip;
use entities\TripTemplate;
use entities\Dayprogram;
use entities\Hotel;

/**
 * Description of TripDBC
 *
 * @author Lukas
 */
class TripDBC extends DBConnector {
    
    /** (tested)
     * Creates a new TripTemplate. Price is per default busPricePerDay * durationInDays
     * @param type $tripTemplate
     * @return boolean|int
     */
    public function createTripTemplate($tripTemplate){
        $stmt = $this->mysqliInstance->prepare("INSERT INTO triptemplate VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssiiidsii', $name, $description, $minAllocation, $maxAllocation, 
                $durationInDays, $price, $picturePath, $bookable, $fk_bus_id);
        $name = $tripTemplate->getName();
        $description = $tripTemplate->getDescription();
        $minAllocation = $tripTemplate->getMinAllocation();
        $maxAllocation = $tripTemplate->getMaxAllocation();
        $durationInDays = $tripTemplate->getDurationInDays();//Important to show just TripTemplates which allocated  Dayprograms
        $price = $tripTemplate->getPrice();
        $picturePath = $tripTemplate->getPicturePath();
        $bookable = intval($tripTemplate->getBookable());//Converting boolean to int
        $fk_bus_id = $tripTemplate->getBus()->getId();
        return $this->executeInsert($stmt);
    }
    
    /** (teste)
     * Deletes the TripTemplate from the database
     * @param type $tripTemplate
     * @return boolean
     */
    public function deleteTripTemplate($tripTemplate){
        $stmt = $this->mysqliInstance->prepare("DELETE FROM triptemplate WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $tripTemplate->getId();
        return $this->executeDelete($stmt);
    }
    
    /**
     * Gets all available TripTemplates from the database order by name asc
     * @return boolean|array
     */
    public function getAllTripTemplates(){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM triptemplate ORDER BY name ASC");
        if(!$stmt){
            return false;
        }
        $stmt->execute();
        $templates = array();
        $result = $stmt->get_result();
        while($tripTemplate = $result->fetch_object("entities\TripTemplate")){
            array_push($templates, $tripTemplate);
        }

        $stmt->close();
        return $templates;
    }
    
    /**
     * Gets all TripTemplates which are bookable
     * @return boolean|array
     */
    public function getBookableTripTemplates(){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM triptemplate WHERE bookable = ? ORDER BY name ASC");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $bookable);
        $bookable = intval(true); 
        $stmt->execute();
        $templates = array();
        $result = $stmt->get_result();
        while($tripTemplate = $result->fetch_object("entities\TripTemplate")){
            array_push($templates, $tripTemplate);
        }

        $stmt->close();
        return $templates;
    }
    
    /** (tested)
     * Finds the TripTemplate by the given id from the database
     * @param type $templateId
     * @return boolean|TripTemplate
     */
    public function findTripTemplateById($templateId){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM triptemplate where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $templateId;
        $stmt->execute();
        $templateObj = $stmt->get_result()->fetch_object("entities\TripTemplate");
        
        //checks whether the TripTemplate exists
        $stmt->close();
        if($templateObj){
            return $templateObj;
        }else{
            return false;
        }
    }
    
    /**
     * Gets all Dayprograms from the database which belongs to the TripTemplate
     * @param type $tripTemplate
     * @return boolean|array
     */
    public function getDayprogramsFromTemplate($tripTemplate){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM dayprogram WHERE fk_tripTemplate_id = ? ORDER BY dayNumber ASC");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $fk_tripTemplate_id);
        $fk_tripTemplate_id = $tripTemplate->getId(); 
        $stmt->execute();
        $dayprograms = array();
        $result = $stmt->get_result();
        while($dayprogram = $result->fetch_object("entities\TripTemplate")){
            array_push($dayprograms, $dayprogram);
        }
        $stmt->close();
        
        //Adds the Hotels to the Dayprograms
        foreach($dayprograms as $daypgrm){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM hotel where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $fk_hotel_id);
        $fk_hotel_id = $daypgrm->getFkHotelId();
        $stmt->execute();
        $daypgrm->setHotel($stmt->get_result()->fetch_object("entities\Hotel"));
        $stmt->close();
        }

        return $dayprograms;
    }
    
    
    
    
    
    
    
    
    
    
    /**
     *  Stores a new Dayprogram into the database
     * @param type $dayprogram
     * @return boolean
     */
    public function createDayprogram($dayprogram){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO dayprogram VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sssssii', $name, $picturePath, $date, $description, $hotelName, $fk_trip_id, $fk_hotel_id);
        $name = $dayprogram->getName();
        $picturePath = $dayprogram->getPicturePath();
        $date = $dayprogram->getDayNumber();
        $description = $dayprogram->getDescription();
        $hotelName = $dayprogram->getHotelName();
        $fk_trip_id = $dayprogram->getFkTripTemplateId();
        $fk_hotel_id = $dayprogram->getFkHotelId();
        return $this->executeInsert($stmt);
    }
    
    
}
