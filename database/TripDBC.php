<?php

namespace database;

use entities\Trip;
use entities\TripTemplate;
use entities\Dayprogram;
use database\BusDBC;
use database\HotelDBC;
use database\InsuranceDBC;
use database\UserDBC;
use database\InvoiceDBC;

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
     * Finds the TripTemplate and the according Bus by the given id from the database.
     * @param type $templateId, $close (false if closing of connection is NOT desired)
     * @return boolean|TripTemplate
     */
    public function findTripTemplateById($templateId, $close = true){
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM triptemplate where id = ?");
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
            $busDBC = new BusDBC();
            $bus = $busDBC->findBusById($templateObj->getFkBusId());
            $templateObj->setBus($bus);
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
     * Ensures rollback of the transaction if any exception occures in the creation of a Dayprogram
     * @param type $dayprogram
     * @return boolean
     */
    public function createDayprogram($dayprogram){
        $this->mysqliInstance->begin_transaction();
        $this->mysqliInstance->autocommit(false);
        try{
            $result = $this->createDayprogram2($dayprogram);
            $this->mysqliInstance->autocommit(true);
            return $result;
        } catch (Exception $ex) {
            $this->mysqliInstance->rollback();
            $this->mysqliInstance->autocommit(true);
            return false;
        }
    }

    /** (tested)
     *  Stores a new Dayprogram into the database and updates the price and dutationInDays of the according TripTemplate
     * @param type $dayprogram
     * @return boolean
     */
    public function createDayprogram2($dayprogram){
        //Insert of Dayprogram
        $stmt = $this->mysqliInstance->prepare("INSERT INTO dayprogram VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
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
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the TripTemplate to update
        $tripTemplate = $this->findTripTemplateById($fk_tripTemplate_id, false);
        if(!$tripTemplate){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the Bus of the TripTemplate to calculate with pricePerDay
        $busDBC = new BusDBC();
        $bus = $busDBC->findBusById($tripTemplate->getFkBusId(), false);
        if(!$bus){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the Hotel of the Dayprogram to calculate with pricePerPerson
        $hotelDBC = new HotelDBC();
        $hotel = $hotelDBC->findHotelById($dayprogram->getFkHotelId(), false);
        if(!$hotel){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //updates the price and durationInDays of the TripTemplate
        $stmt = $this->mysqliInstance->prepare("UPDATE triptemplate SET price = ?, durationInDays = ? WHERE id = ?");
        if(!$stmt){
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
            $this->mysqliInstance->rollback();
            exit();
        }
        
        $this->mysqliInstance->commit();
        $stmt->close();
        return true;
    }
    
    /** (tested)
     * Ensures rollback of the transaction if any exception occures in the elimination of a Dayprogram
     * @param type $dayprogram
     * @return boolean
     */
    public function deleteDayprogram($dayprogram){
        $this->mysqliInstance->begin_transaction();
        $this->mysqliInstance->autocommit(false);
        try{
            $result = $this->deleteDayprogram2($dayprogram);
            $this->mysqliInstance->autocommit(true);
            return $result;
        } catch (Exception $ex) {
            $this->mysqliInstance->rollback();
            $this->mysqliInstance->autocommit(true);
            return false;
        }
    }
    
    /** (tested)
     * Deletes the Dayprogram from the TripTemplate
     * @param type $dayprogram
     * @return boolean
     */
    public function deleteDayprogram2($dayprogram){
        //Gets the real object of the Dayprogram
        $dayprogram = $this->findDayprogramById($dayprogram->getId(), false);
        
        //Elimination of Dayprogram
        $stmt = $this->mysqliInstance->prepare("DELETE FROM dayprogram WHERE id = ?");
        if(!$stmt){
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('i', $dayprogramId);
        $dayprogramId = $dayprogram->getId();
        if(!$stmt->execute()){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the TripTemplate to update
        $tripTemplate = $this->findTripTemplateById($dayprogram->getFkTripTemplateId(), false);
        if(!$tripTemplate){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the Bus of the TripTemplate to calculate with pricePerDay
        $busDBC = new BusDBC();
        $bus = $busDBC->findBusById($tripTemplate->getFkBusId(), false);
        if(!$bus){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Gets the Hotel of the Dayprogram to calculate with pricePerPerson
        $hotelDBC = new HotelDBC();
        $hotel = $hotelDBC->findHotelById($dayprogram->getFkHotelId(), false);
        if(!$hotel){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //updates the price and durationInDays of the TripTemplate
        $stmt = $this->mysqliInstance->prepare("UPDATE triptemplate SET price = ?, durationInDays = ? WHERE id = ?");
        if(!$stmt){
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
            $this->mysqliInstance->rollback();
            exit();
        }
        
        $this->mysqliInstance->commit();
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
    
    /** (tested)
     * Changes the bookable of the given TripTemplate
     * @param type $tripTemplate
     * @return boolean
     */
    public function changeBookable($tripTemplate){
        //Gets the object of the TripTemplate
        $tripTemplateObj = $this->findTripTemplateById($tripTemplate->getId());
        if(!$tripTemplateObj){
            return false;
        }
        
        //Locks or unlocks the bookable
        $stmt = $this->mysqliInstance->prepare("UPDATE triptemplate SET bookable = ? WHERE id = ?");
        $stmt->bind_param('ii', $bookable, $id);
        $id = $tripTemplateObj->getId();
        if($tripTemplateObj->getBookable()){
            //Locks bookable
            $bookable = intval(false);
        }else{
            //Unlocks bookable
            $bookable = intval(true);
        }
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
    /** (tested)
     * Ensures rollback of the transaction if any exception occures in the creation of the Trip
     * @param type $trip
     * @return boolean
     */
    public function createTrip($trip){
        $this->mysqliInstance->begin_transaction();
        $this->mysqliInstance->autocommit(false);
        try{
            $result = $this->createTrip2($trip);
            $this->mysqliInstance->autocommit(true);
            return $result;
        } catch (Exception $ex) {
            $this->mysqliInstance->rollback();
            $this->mysqliInstance->autocommit(true);
            return false;
        }
    }
    
    /**
     * Creates and stores the Trip and the Participants into the database
     * @param type $trip
     * @return boolean
     */
    public function createTrip2($trip){
        //Gets the TripTemplate
        $tripTemplate = $this->findTripTemplateById($trip->getFkTripTemplateId(), false);
        if(!$tripTemplate){
            return false;
        }
        
        //Validation of min- and maxAllocation
        if($trip->getNumOfParticipation() < $tripTemplate->getMinAllocation() or
                $trip->getNumOfParticipation() > $tripTemplate->getMaxAllocation()){
            return false;
        }
        
        //Gets the Insurance if chosen
        $insurance = null;
        if($trip->getFkInsuranceId()){
            $insuranceDBC = new InsuranceDBC();
            $insurance = $insuranceDBC->findInsuranceById($trip->getFkInsuranceId(), false);
            if(!$insurance){
                return false;
            }
        }
        
        //Insert of Trip
        $stmt = $this->mysqliInstance->prepare("INSERT INTO trip VALUES (NULL, ?, ?, ?, NULL, ?, ?, ?)");
        if(!$stmt){
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('idsiii', $numOfParticipation, $price, $departureDate, $fk_user_id, 
                $fk_insurance_id, $fk_tripTemplate_id);
        $numOfParticipation = $trip->getNumOfParticipation();
        
        //Calculates the price (tripTemplatePrice / minAllocation is price per person without any insurance)
        $price = $tripTemplate->getPrice() / $tripTemplate->getMinAllocation() * $numOfParticipation;
        $price = round($price * 20, 0) / 20;//round to the nearest 0.05
        
        $departureDate = $trip->getDepartureDate();
        $fk_user_id = $trip->getFkUserId();
        $fk_insurance_id = $trip->getFkInsuranceId();
        $fk_tripTemplate_id = $trip->getFkTripTemplateId();
        if(!$stmt->execute()){
            $this->mysqliInstance->rollback();
            exit();
        }
        $tripId = $stmt->insert_id;
        
        //Storage of Participants
        $participantIds = $trip->getParticipantIds();
        foreach($participantIds as $participantId){
            $stmt = $this->mysqliInstance->prepare("INSERT INTO tripparticipant VALUES (?, ?)");
            if(!$stmt){
                $this->mysqliInstance->rollback();
                exit();
            }
            $stmt->bind_param('ii', $fk_trip_id, $fk_participant_id);
            $fk_trip_id = $tripId;
            $fk_participant_id = $participantId;
            if(!$stmt->execute()){
                $this->mysqliInstance->rollback();
                exit();
            }
        }
        
        $this->mysqliInstance->commit();
        $stmt->close();
        return true;
    }
    
    /** (tested)
     * Ensures rollback of the transaction if any exception occures in the elimination of the Trip
     * @param type $trip
     * @return boolean
     */
    public function deleteTrip($trip){
        $this->mysqliInstance->begin_transaction();
        $this->mysqliInstance->autocommit(false);
        try{
            $result = $this->deleteTrip2($trip);
            $this->mysqliInstance->autocommit(true);
            return $result;
        } catch (Exception $ex) {
            $this->mysqliInstance->rollback();
            $this->mysqliInstance->autocommit(true);
            return false;
        }
    }
    
    /** (tested)
     * Deletes the Trip and the according Participants (from the Trip-booking)
     * @param type $trip
     * @return boolean
     */
    public function deleteTrip2($trip){
        //Deletes the Trip
        $stmt = $this->mysqliInstance->prepare("DELETE FROM trip WHERE id = ?");
        if(!$stmt){
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('i', $tripId);
        $tripId = $trip->getId();
        if(!$stmt->execute()){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        //Deletes all Participants from the Trip
        $stmt = $this->mysqliInstance->prepare("DELETE FROM tripparticipant WHERE fk_trip_id = ?");
        if(!$stmt){
            $this->mysqliInstance->rollback();
            exit();
        }
        $stmt->bind_param('i', $tripId);
        $tripId = $trip->getId();
        if(!$stmt->execute()){
            $this->mysqliInstance->rollback();
            exit();
        }
        
        $this->mysqliInstance->commit();
        $stmt->close();
        return true;
    }
    
    /** (tested)
     * Gets the booked Trips
     * @param type $userId (if request is restricted to a single User)
     * @return boolean|array
     */
    public function getBookedTrips($userId = null){
        //Gets all the Trips from the database
        $stmt;
        if(!$userId){
            //Admins query
            $stmt = $this->mysqliInstance->prepare("SELECT * FROM trip ORDER BY departureDate DESC");
        }else{
            //Users query
            $stmt = $this->mysqliInstance->prepare("SELECT * FROM trip WHERE fk_user_id = ? ORDER BY departureDate DESC");
            $stmt->bind_param('i', $fk_user_id);
            $fk_user_id = $userId;
        }
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
        if(sizeof($trips) < 1){
            return $trips;
        }
        
        //Adds the TripTemplates to the Trips
        foreach($trips as $trip){
            $trip->setTripTemplate($this->findTripTemplateById($trip->getFkTripTemplateId()));
        }
        
        return $trips;
    }
    
    /** (tested)
     * Finds the Trip and all (User, Participant, Insurance, Invoices, TripTemplate, Bus, Dayprograms, Hotels) data according to the Trip
     * @param type $tripId
     * @return boolean|Trip
     */
    public function findTripById($tripId, $shallow = false){
        //Gets the Trip object from the database
        $stmt = $this->mysqliInstance->prepare("SELECT * FROM trip where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $tripId;
        $stmt->execute();
        $tripObj = $stmt->get_result()->fetch_object("entities\Trip");
        if(!$tripObj){
            $stmt->close();
            return false;
        }
        
        //If it is just a shallow query, then it returns just a Part of the entity Trip some unnecessary deep objects
        if($shallow){
            $stmt->close();
            return $tripObj;
        }
        
        //Adds the Insurance to the Trip
        $insuranceDBC = new InsuranceDBC();
        $insurance = $insuranceDBC->findInsuranceById($tripObj->getFkInsuranceId());
        $tripObj->setInsurance($insurance);
        
        //Adds the Participants to the Trip
        $userDBC = new UserDBC();
        $participants = $userDBC->findParticipantsToTrip($tripId);
        $tripObj->setParticipants($participants);
        
        //Adds the User to the Trip
        $user = $userDBC->findUserById($tripObj->getFkUserId());
        $tripObj->setUser($user);
        
        //Adds the invoices to the Trip
        $invoiceDBC = new InvoiceDBC();
        $invoices = $invoiceDBC->findTripInvoices($tripId);
        $tripObj->setInvoices($invoices);
        
        //Adds the TripTemplate, Bus, Dayprograms, Hotel to the Trip
        $tripTemplate = $this->findTripTemplateById($tripObj->getFkTripTemplateId());
        if($tripTemplate){
            $tripTemplate->setDayprograms($this->getDayprogramsFromTemplate($tripTemplate));
            $tripObj->setTripTemplate($tripTemplate);
        }
        
        return $tripObj;
        
    }
    
    /** (tested)
     * Changes the parameter of InvoicesRegistered in the Trip
     * @param type $trip
     * @return boolean
     */
    public function changeInvoicesRegistered($trip){
        //Gets the object of the Trip (shallow request)
        $tripObj = $this->findTripById($trip->getId(), true);
        if(!$tripObj){
            return false;
        }
        
        //Locks or unlocks the invoicesRegistered
        $stmt = $this->mysqliInstance->prepare("UPDATE trip SET invoicesRegistered = ? WHERE id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('si', $invoicesRegistered, $id);
        $id = $tripObj->getId();
        if($tripObj->getInvoicesRegistered()){
            //Locks invoicesRegistered
            $invoicesRegistered = null;
        }else{
            //Unlocks invoicesRegistered
            $invoicesRegistered = date("Y-m-d");
        }
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    
}