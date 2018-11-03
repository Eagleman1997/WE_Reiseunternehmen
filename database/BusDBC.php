<?php

namespace database;

use entities\Bus;

/**
 * Description of BusDBC
 *
 * @author Lukas
 */
class BusDBC extends DBConnector {
    
    /** (tested)
     * Creates a new Bus into the database
     * @param type $bus
     * @return boolean\int
     */
    public function createBus($bus){
        $stmt = $this->mysqliInstance->prepare("INSERT INTO bus VALUES (NULL, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssids', $name, $description, $seats, $pricePerDay, $picturePath);
        $name  = $bus->getName();
        $description = $bus->getDescription();
        $seats = $bus->getSeats();
        $pricePerDay = $bus->getPricePerDay();
        $picturePath = $bus->getPicturePath();
        return $this->executeInsert($stmt);
    }
    /**
     * Finds the Bus by the given id
     * @param type $busId
     * @return boolean|Bus
     */
    public function findBusById($busId){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM bus where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $busId;
        $stmt->execute();
        $busObj = $stmt->get_result()->fetch_object("entities\Bus");
        
        //checks whether the Bus exists
        $stmt->close();
        if($busObj){
            return $busObj;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Deletes the Bus by the given id
     * @param type $bus
     * @return boolean
     */
    public function deleteBus($bus){
        $stmt = $this->mysqliInstance->prepare("DELETE FROM bus WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $bus->getId();
        return $this->executeDelete($stmt);
    }
    
    /** (tested)
     * Gets all available Buses from the database
     * @return boolean|array
     */
    public function getAllBuses(){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM bus ORDER BY name ASC");
        if(!$stmt){
            return false;
        }
        $stmt->execute();
        $buses = array();
        $result = $stmt->get_result();
        while($bus = $result->fetch_object("entities\Bus")){
            array_push($buses, $bus);
        }

        $stmt->close();
        return $buses;
    }
    
}
