<?php

namespace database;

use entities\Insurance;

/**
 * Description of InsuranceDBC
 *
 * @author Lukas
 */
class InsuranceDBC extends DBConnector {
    
    /**
     * Creates a new Insurance into the database
     * @param type $insurance
     * @return boolean|int
     */
    public function createInsurance($insurance){
        $stmt = $this->mysqliInstance->prepare("INSERT INTO insurance VALUES (NULL, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssd', $name, $description, $pricePerPerson);
        $name  = $insurance->getName();
        $description = $insurance->getDescription();
        $pricePerPerson = $insurance->getPricePerPerson();
        
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Deletes the Insurance by the given id
     * @param type $insurance
     * @return boolean
     */
    public function deleteInsurance($insurance){
        $stmt = $this->mysqliInstance->prepare("DELETE FROM insurance WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $insurance->getId();
        return $this->executeDelete($stmt);
    }
    
    /** (tested)
     * Gets all available Insurances from the database
     * @return boolean|array
     */
    public function getAllInsurances(){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM insurance ORDER BY name ASC");
        if(!$stmt){
            return false;
        }
        $stmt->execute();
        $insurances = array();
        $result = $stmt->get_result();
        while($insurance = $result->fetch_object("entities\Insurance")){
            array_push($insurances, $insurance);
        }

        $stmt->close();
        return $insurances;
    }
    
    /** (tested)
     * Finds the Insurance by the given id
     * @param type $insuranceId
     * @param type $close (false if closing of connection is NOT desired)
     * @return boolean\Insurance
     */
    public function findInsuranceById($insuranceId, $close = true){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM insurance where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $insuranceId;
        $stmt->execute();
        $insuranceObj = $stmt->get_result()->fetch_object("entities\Insurance");
        
        if($close){
            $stmt->close();
        }
        
        //checks whether the Insurance exists
        if($insuranceObj){
            return $insuranceObj;
        }else{
            return false;
        }
    }
    
}
