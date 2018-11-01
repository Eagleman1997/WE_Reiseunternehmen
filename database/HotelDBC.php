<?php

namespace database;

use entities\Hotel;

/**
 * Description of HotelDBC
 *
 * @author Lukas
 */
class HotelDBC extends DBConnector {
    
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
    
}
