<?php

namespace database;

use entities\Trip;
use entities\TripTemplate;
use entities\Dayprogram;
use entities\Hotel;
use entities\Bus;
use database\BusDBC;
use database\HotelDBC;

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
    
    /** (tested)
     * Deletes the TripTemplate and all related Dayprograms from the database
     * @param type $tripTemplate
     * @return boolean
     */
    public function deleteTripTemplate($tripTemplate){
        //Begins the transaction
        $this->mysqliInstance->begin_transaction();
        $this->mysqliInstance->autocommit(false);
        
        //Deletes the TripTemplate
        $stmt = $this->mysqliInstance->prepare("DELETE FROM triptemplate WHERE id = ?");
        if(!$stmt){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('i', $id);
        $id = $tripTemplate->getId();
        if(!$stmt->execute()){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Deletes the Dayprograms according to the TripTemplate
        $dayprograms = $this->getDayprogramsFromTemplate($tripTemplate);
        foreach($dayprograms as $dayprogram){
            $stmt = $this->mysqliInstance->prepare("DELETE FROM dayprogram WHERE id = ?");
            if(!$stmt){
                // rollback if prep stat execution fails
                $this->mysqliInstance->rollback();
                exit();
            }
            $stmt->bind_param('i', $id);
            $id = $dayprogram->getId();
            if(!$stmt->execute()){
                // rollback if prep stat execution fails
                $this->mysqliInstance->rollback();
                exit();
            }
        }
        
        $this->mysqliInstance->commit();
        $this->mysqliInstance->autocommit(true);
        $stmt->close();
        return true;
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
     * @param type $templateId, $close (false if closing of connection is NOT desired)
     * @return boolean|TripTemplate
     */
    public function findTripTemplateById($templateId, $close = true){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM triptemplate where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $templateId;
        $stmt->execute();
        $templateObj = $stmt->get_result()->fetch_object("entities\TripTemplate");
        
        //closing of the connection if desired
        if($close){
            $stmt->close();
        }
        
        //checks whether the TripTemplate exists
        if($templateObj){
            return $templateObj;
        }else{
            return false;
        }
    }
    
    /** (tested)
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
        while($dayprogram = $result->fetch_object("entities\Dayprogram")){
            array_push($dayprograms, $dayprogram);
        }
        $stmt->close();
        
        //Adds the Hotels to the Dayprograms
        $hotelDBC = new HotelDBC();
        foreach($dayprograms as $daypgrm){
            $daypgrm->setHotel($hotelDBC->findHotelById($daypgrm->getFkHotelId()));
        }

        return $dayprograms;
    }

    /** (tested)
     *  Stores a new Dayprogram into the database and updates the price and dutationInDays of the according TripTemplate
     * @param type $dayprogram
     * @return boolean
     */
    public function createDayprogram($dayprogram){
        //Begins the transaction
        $this->mysqliInstance->begin_transaction();
        $this->mysqliInstance->autocommit(false);
        
        //Insert of Dayprogram
        $stmt = $this->mysqliInstance->prepare("INSERT INTO dayprogram VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('ssisii', $name, $picturePath, $dayNumber, $description, 
                $fk_tripTemplate_id, $fk_hotel_id);
        $name = $dayprogram->getName();
        $picturePath = $dayprogram->getPicturePath();
        $dayNumber = $dayprogram->getDayNumber();
        $description = $dayprogram->getDescription();
        $fk_tripTemplate_id = $dayprogram->getFkTripTemplateId();
        $fk_hotel_id = $dayprogram->getFkHotelId();
        if(!$stmt->execute()){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the TripTemplate to update
        $tripTemplate = $this->findTripTemplateById($fk_tripTemplate_id, false);
        if(!$tripTemplate){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the Bus of the TripTemplate to calculate with pricePerDay
        $busDBC = new BusDBC();
        $bus = $busDBC->findBusById($tripTemplate->getFk_bus_id(), false);
        if(!$bus){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the Hotel of the Dayprogram to calculate with pricePerPerson
        $hotelDBC = new HotelDBC();
        $hotel = $hotelDBC->findHotelById($dayprogram->getFkHotelId(), false);
        if(!$hotel){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //updates the price and durationInDays of the TripTemplate
        $stmt = $this->mysqliInstance->prepare("UPDATE triptemplate SET price = ?, durationInDays = ? WHERE id = ?");
        if(!$stmt){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('dii', $price, $durationInDays, $tripTemplateId);
        //Calculates and adds the minPrice for the TripTemplate
        $price = $tripTemplate->getPrice() + $bus->getPricePerDay() + $tripTemplate->getMinAllocation() * $hotel->getPricePerPerson();
        $price = round($price * 20, 0) / 20;//round to the nearest 0.05
        $durationInDays = $tripTemplate->getDurationInDays() + 1;
        $tripTemplateId = $tripTemplate->getId();
        if(!$stmt->execute()){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        $this->mysqliInstance->commit();
        $this->mysqliInstance->autocommit(true);
        $stmt->close();
        return true;
    }
    
    /** (tested)
     * Deletes the Dayprogram from the TripTemplate
     * @param type $dayprogram
     * @return boolean
     */
    public function deleteDayprogram($dayprogram){
        //Begins the transaction
        $this->mysqliInstance->begin_transaction();
        $this->mysqliInstance->autocommit(false);
        
        //Gets the real object of the Dayprogram
        $dayprogram = $this->findDayprogramById($dayprogram->getId(), false);
        
        //Elimination of Dayprogram
        $stmt = $this->mysqliInstance->prepare("DELETE FROM dayprogram WHERE id = ?");
        if(!$stmt){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('i', $dayprogramId);
        $dayprogramId = $dayprogram->getId();
        if(!$stmt->execute()){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the TripTemplate to update
        $tripTemplate = $this->findTripTemplateById($dayprogram->getFkTripTemplateId(), false);
        if(!$tripTemplate){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the Bus of the TripTemplate to calculate with pricePerDay
        $busDBC = new BusDBC();
        $bus = $busDBC->findBusById($tripTemplate->getFk_bus_id(), false);
        if(!$bus){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the Hotel of the Dayprogram to calculate with pricePerPerson
        $hotelDBC = new HotelDBC();
        $hotel = $hotelDBC->findHotelById($dayprogram->getFkHotelId(), false);
        if(!$hotel){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //updates the price and durationInDays of the TripTemplate
        $stmt = $this->mysqliInstance->prepare("UPDATE triptemplate SET price = ?, durationInDays = ? WHERE id = ?");
        if(!$stmt){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('dii', $price, $durationInDays, $tripTemplateId);
        //Calculates and decreases the minPrice for the TripTemplate
        $price = $tripTemplate->getPrice() - $bus->getPricePerDay() - $tripTemplate->getMinAllocation() * $hotel->getPricePerPerson();
        $price = round($price * 20, 0) / 20;//round to the nearest 0.05
        $durationInDays = $tripTemplate->getDurationInDays() - 1;
        $tripTemplateId = $tripTemplate->getId();
        if(!$stmt->execute()){
            // rollback if prep stat execution fails
            $this->mysqliInstance->rollback();
            exit();
        }
        
        $this->mysqliInstance->commit();
        $this->mysqliInstance->autocommit(true);
        $stmt->close();
        return true;
    }
    
    /** (tested)
     * Finds the Dayprogram by the given id from the database
     * @param type $templateId, $close (false if closing of connection is NOT desired)
     * @return boolean|Dayprogram
     */
    public function findDayprogramById($dayprogramId, $close = true){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM dayprogram where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $dayprogramId;
        $stmt->execute();
        $dayprogramObj = $stmt->get_result()->fetch_object("entities\Dayprogram");
        
        //closing of the connection if desired
        if($close){
            $stmt->close();
        }
        
        //checks whether the Dayprogram exists
        if($dayprogramObj){
            return $dayprogramObj;
        }else{
            return false;
        }
    }
    
    
}
