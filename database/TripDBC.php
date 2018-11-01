<?php

namespace database;

use entities\Trip;
use entities\Dayprogram;

/**
 * Description of TripDBC
 *
 * @author Lukas
 */
class TripDBC extends DBConnection {
    
        /**
     * Stores a new Trip into the database
     * @param type $trip
     * @return boolean if storage was successful
     */
    public function createTrip($trip){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO trip VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssssdiiii', $name, $picturePath, $description, $departureDate, 
                $pricePerPerson, $durationInDays, $maxAllocation, $minAllocation, $fk_bus_id);
        $name = $trip->getName();
        $picturePath = $trip->getPicturePath();
        $description = $trip->getDescription();
        $departureDate = $trip->getDepartureDate();
        $pricePerPerson = $trip->getPricePerPerson();
        $durationInDays = $trip->getDurationInDays();
        $maxAllocation = $trip->getMaxAllocation();
        $minAllocation = $trip->getMinAllocation();
        $fk_bus_id = $trip->getFkBusId();
        return $this->executeInsert($stmt);
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
        $date = $dayprogram->getDate();
        $description = $dayprogram->getDescription();
        $hotelName = $dayprogram->getHotelName();
        $fk_trip_id = $dayprogram->getFkTripId();
        $fk_hotel_id = $dayprogram->getFkHotelId();
        return $this->executeInsert($stmt);
    }
    
    /**
     * * Get an array of all available Trips (restriciton considered)
     * @param type $restriction 
     *                          "all": gets all Trips without any restriction
     *                          "current": gets all Trips with departureDate >= today
     *                          "bookable": gets all Trips which are bookable (date and outbooking considered)
     * @return boolean|array(entities\Trip)
     */
    public function findTrips($restriction){
        $query = "";
        switch($restriction){
            case "all":
                $query."SELECT * FROM trip t1";
                break;
            case "current":
                $query."SELECT * FROM trip t1 WHERE departureDate >= '".date("Y-m-d");
                break;
            case "bookable":
                $query."SELECT * FROM trip t1 WHERE departureDate >= '".date("Y-m-d")."' AND "
                ."t1.minAllocation > (SELECT COUNT(ut.id) FROM usertrip ut JOIN trip t2 ON ut.fk_trip_id = t2.id "
                ."WHERE ut.fk_trip_id = t1.id)";
                break;
            default:
                return false;
        }
        $this->connect();
        $stmt = self::$mysqli->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->execute();
            
        $trips = array();
        $result = $stmt->get_result();
        while($trip = $result->fetch_object("entities\Trip")){
            array_push($trips, $trip);
        }

        $stmt->close();
        foreach($trips as $oneTrip){
            $oneTrip->setAllocatedUsers($this->getAllocationNumberOfTrip($oneTrip));
        }
        return $trips;
    }
    
    /** DOES NOT WORK THIS WAY
     * Gets the number of allocated Users of the given Trip
     * @param type $trip
     * @return boolean|int
     */
    private function getAllocationNumberOfTrip($trip){
        $this->connect();
        $stmt = self::$mysqli->prepare("SELECT id FROM participant WHERE fk_trip_id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);    
        $id = $trip->getId();
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $stmt->close();
        /* @var $result type int*/
        return (int) $result;
    }
    
}
