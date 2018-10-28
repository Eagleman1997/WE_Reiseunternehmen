<?php
namespace helpers\database;
use \helpers\database\Config;
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
    
    private static $dbConnection = null;
    private static $mysqli = null;
    
    /** (tested)
     * Singleton pattern to ensure existence of just one db-connection
     * @return type DBConnection
     */
    public static function getDBConnection(){
        if(self::$dbConnection == null){
            self::$dbConnection = new DBConnection();
        }
        return self::$dbConnection;
    }
    
    /** (tested)
     * Creates the connection to the database
     */
    private function connect(){
        $host = Config::get("database.host");
        $user = Config::get("database.user");
        $password = Config::get("database.password");
        $dbname = Config::get("database.name");
            
        self::$mysqli = new mysqli($host, $user, $password, $dbname);
        /* check connection */
        if (self::$mysqli->connect_error) {
            printf("Connect failed: %s\n", self::$mysqli->connect_error);
            exit();
        }
    }
    
    private function executeInsert($stmt){
        $success = $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();
        if($success){
            return $id;
        }
        return false;
    }
    
    /** (tested)
     * Gets the hashed password to the given email
     * @param type $email
     * @return String stored (hashed) password if query was successful
     *         boolean false if query failed (usually email is not stored in database)
     */
    public function getUserByEmail($user){
        $this->connect();
        $stmt = self::$mysqli->prepare("SELECT password FROM user where email = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('s', $email);
        $email = $user->getEmail();
        $stmt->execute();
        $userObj = $stmt->get_result()->fetch_object("entities\User");
        
        //checks whether the given email from a User exists
        $stmt->close();
        if($userObj){
            return $userObj;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Updates the Users password (new password must be stored in the object)
     * @param type $user
     * @return type
     */
    public function updatePassword($user){
        $this->connect();
        $stmt = self::$mysqli->prepare("UPDATE user SET password = ? WHERE id = ".$user->getId());
        $stmt->bind_param('s', $password);
        $password = $user->getPassword();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Stores a new User into the database
     * @param type $user
     * @return boolean if registration was successful (usually email does already exist)
     */
    public function registerUser($user){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO user VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sssisssss', $firstName, $lastName, $street, $zipCode, 
                $location, $email, $role, $birthDate, $password);
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $street = $user->getStreet();
        $zipCode = $user->getZipCode();
        $location = $user->getLocation();
        $email = $user->getEmail();
        $role = $user->getRole();
        $birthDate = $user->getBirthDate();
        $password = $user->getPassword();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Stores a new Trip into the database
     * @param type $trip
     * @return boolean if storage was successful
     */
    public function storeTrip($trip){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO trip VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssssdii', $name, $picturePath, $description, $departureDate, $price, $durationInDays, $maxStaffing);
        $name = $trip->getName();
        $picturePath = $trip->getPicturePath();
        $description = $trip->getDescription();
        $departureDate = $trip->getDepartureDate();
        $price = $trip->getPrice();
        $durationInDays = $trip->getDurationInDays();
        $maxStaffing = $trip->getMaxStaffing();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     *  Stores a new Dayprogram into the database
     * @param type $dayprogram
     * @return boolean
     */
    public function storeDayprogram($dayprogram){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO dayprogram VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('sssssi', $name, $picturePath, $date, $description, $hotelName, $fk_trip_id);
        $name = $dayprogram->getName();
        $picturePath = $dayprogram->getPicturePath();
        $date = $dayprogram->getDate();
        $description = $dayprogram->getDescription();
        $hotelName = $dayprogram->getHotelName();
        $fk_trip_id = $dayprogram->getFkTripId();
        return $this->executeInsert($stmt);
    }
    
    /** (tested)
     * Get an array of all available Trips (departureDate and maxStaffing considered)
     * @return boolean|array(entities\Trip)
     */
    public function getFreeTrips(){
        $this->connect();
        $stmt = self::$mysqli->prepare("SELECT * FROM trip t1 WHERE departureDate >= '".date("Y-m-d")."' AND "
                ."t1.maxStaffing > (SELECT COUNT(ut.id) FROM usertrip ut JOIN trip t2 ON ut.fk_trip_id = t2.id "
                ."WHERE ut.fk_trip_id = t1.id)");
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
        return $trips;
    }
    
    /** (tested)
     * Gets a Trip object by the given id
     * @param type $id
     * @return boolean|Trip
     */
    public function getTripById($id){
        $this->connect();
         $stmt = self::$mysqli->prepare("SELECT * FROM trip where id = ?;");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $tripObj = $stmt->get_result()->fetch_object("entities\Trip");
        
        $stmt->close();
        return $tripObj;
    }
    
    /** (tested)
     * Gets the Dayprograms of the given Trip
     * @param type $trip
     * @return boolean|array(entities\Dayprogram)
     */
    public function getDayProgramsByTrip($trip){
        $this->connect();
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
            echo "Dayprogram in DBConnector: ".$dayprogram->getName()."</br>";
            array_push($dayprograms, $dayprogram);
        }
        
        $stmt->close();
        return $dayprograms;
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
        $this->executeInsert($stmt);
    }
}
