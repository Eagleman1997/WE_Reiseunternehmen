<?php

namespace database;

use \mysqli;
use database\DBConnection;

/**
 * Description of DatabaseConnector
 *
 * @author Lukas
 */
class DBConnector {
    
    protected $mysqliInstance;
    
    public function __construct(mysqli $mysqliInstance = null) {
        if(is_null($mysqliInstance)){
            $this->mysqliInstance = DBConnection::connect();
        } else {
            $this->mysqliInstance = $mysqliInstance;
        }
    }
    
    /**
     * Helper function to perform an Insert query
     * @param type $stmt
     * @return boolean|int
     */
    protected function executeInsert($stmt){
        $success = $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        if($success){
            return $id;
        }
        return false;
    }
    
    /**
     * Helper function to perform a Delete query
     * @param type $stmt
     * @return boolean
     */
    protected function executeDelete($stmt){
        $success = $stmt->execute();
        $stmt->close();
        if($success){
            return true;
        }
        return false;
    }
    
}
