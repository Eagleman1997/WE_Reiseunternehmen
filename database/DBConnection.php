<?php
namespace database;
use database\Config;
use entities\User;
use entities\Trip;
use entities\Invoice;
use entities\Insurance;
use entities\Dayprogram;
use \mysqli;

/**
 * This class provides an appropriate access to the DB
 * @author Lukas
 */
class DBConnection {
    
    protected static $mysqliInstance = null;
    
    public function __construct() {
        $host = Config::get("database.host");
        $user = Config::get("database.user");
        $password = Config::get("database.password");
        $dbname = Config::get("database.name");
            
        self::$mysqliInstance = new mysqli($host, $user, $password, $dbname);
        /* check connection */
        if (self::$mysqliInstance->connect_error) {
            printf("Connect failed: %s\n", self::$mysqliInstance->connect_error);
            exit();
        }
    }

    
    /**
     * Gets an instance of DBConnection (singleton pattern)
     * @return type
     */
    public static function connect()
    {
        if (self::$mysqliInstance) {
            return self::$mysqliInstance;
        }

        new self();

        return self::$mysqliInstance;
    }
    
    /** (tested)
     * Gets a Trip object by the given id
     * @param type $id
     * @return boolean|Trip
     */
    public function getTripById($tripId){
        $this->connect();
         $stmt = self::$mysqli->prepare("SELECT * FROM trip where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $tripId;
        $stmt->execute();
        $trip = $stmt->get_result()->fetch_object("entities\Trip");
        
        $stmt->close();
        $trip->setStaffedUsers($this->getStaffingnumberOfTrip($trip));
        return $trip;
    }
    
    /** (tested)
     * Gets the Dayprograms of the given Trip
     * @param type $trip
     * @return boolean|array(entities\Dayprogram)
     */
    public function getDayProgramsByTrip($trip){
        $this->connect();
        //explicit allocation of the variables to avoid conflicts caused by identical column 'name' of Trip and Dayprogram
         $stmt = self::$mysqli->prepare("SELECT d.id, d.name, d.picturePath, d.date, d.description, d.hotelName "
                 ."FROM dayprogram d JOIN trip t ON d.fk_trip_id = t.id WHERE t.id = ?");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $id = $trip->getId();
        $stmt->execute();
        
        $dayprograms = array();
        $result = $stmt->get_result();
        while($dayprogram = $result->fetch_object("entities\Dayprogram")){
            array_push($dayprograms, $dayprogram);
        }
        
        $stmt->close();
        return $dayprograms;
    }
    
    /** (tested)
     * Stores a new Insurance
     * @param type $insurance
     * @return boolean
     */
    public function insertInsurance($insurance){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO insurance VALUES (NULL, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssd', $name, $description, $price);
        $name = $insurance->getName();
        $description = $insurance->getDescription();
        $price = $insurance->getPricePerPerson();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Gets the Insurances
     * @return boolean|array(entities\Insurance)
     */
    public function getInsurances(){
        $this->connect();
         $stmt = self::$mysqli->prepare("SELECT * FROM insurance;");
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
     * Tries to store a Booking for a User. 
     * $insuranceId can be set (if chosen) or NULL if User doesn't require Insurance
     * @param type $user
     * @param type $trip
     * @param type $insuranceId
     * @return boolean|int
     */
    public function insertBooking($user, $trip, $insuranceId){
        if($this->checkBooking($user, $trip)){//checks whether the User is already booked in the trip he/she wants to book
            return "doublebooked";
        }
        
        $actualTrip = $this->getTripById($trip->getId());
        
        $this->connect();
        //This case if the User decided to take an Insurance for the chosen Trip
        $stmt = self::$mysqli->prepare("INSERT INTO usertrip VALUES (NULL, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('iii', $fk_user_id, $fk_trip_id, $fk_insurance_id);
        $fk_user_id = $user->getId();
        $fk_trip_id = $trip->getId();
        if($insuranceId){
            $fk_insurance_id = $insuranceId;
        }else{
            $fk_insurance_id = null;
        }
            
        //Validation if the Trip booked out (possible if multiple Users want to book in a short period of time)
        if($actualTrip->getMaxAllocation() > $actualTrip->getAllocatedUsers()){
            if($actualTrip->getDepartureDate() > date("Y-m-d")){
                //booking is valid
                return $this->executeInsert($stmt);
            }else{
                $stmt->close();
                return "outdated";
            }
        }else{
            //booking failed due to overbooking of this Trip
            $stmt->close();
            return "overbooked";
        }
    }
    
    /** (tested)
     * Checks whether the given User has already booked the Trip
     * @param type $user
     * @param type $trip
     * @return boolean
     */
    public function checkBooking($user, $trip){
        $this->connect();
        $stmt = self::$mysqli->prepare("SELECT id FROM usertrip WHERE fk_user_id = ? AND fk_trip_id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ii', $userId, $tripId);
        $userId = $user->getId();
        $tripId = $trip->getId();
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $stmt->close();
        if($result > 0){
            return true;
        }
        return false;
    }
    
    /** (tested)
     * Stores an Invoice into the database
     * @param type $invoice
     * @return boolean|int
     */
    public function insertInvoice($invoice){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO invoice VALUES (NULL, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sdssi', $description, $price, $date, $type, $fk_userTrip_id);
        $description = $invoice->getDescription();
        $price = $invoice->getPricePerPerson();
        $date = $invoice->getDate();
        $type = $invoice->getType();
        $fk_userTrip_id = $_SESSION['userId'];//userTripId required, not userId
        return $this->executeInsert($stmt);
    }
    
    //not ready
    public function getInvoiceOverview($user, $trip){
        $this->connect();
        $stmt = self::$mysqli->prepare("SELECT * FROM invoice WHERE fk_user_id = ? AND fk_trip_id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ii', $userId, $tripId);
        $userId = $user->getId();
        $tripId = $trip->getId();
        $stmt->execute();
        $result = $stmt->get_result()->num_rows;
        $stmt->close();
        if($result > 0){
            return true;
        }
        return false;
    }
    
    //toDo (overview of users of a trip to select of which one u want to get an InvoiceOverview)
    public function getUsersByTrip($trip){
        
    }
    
    //JUST FOR TESTING PURPOSE
    public function insertUserTrip(){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO usertrip VALUES (NULL, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('iii', $num1, $num2, $num3);
        $num1 = 4;
        $num2 = 11;
        $num3 = 1;
        return $this->executeInsert($stmt);
    }
}
