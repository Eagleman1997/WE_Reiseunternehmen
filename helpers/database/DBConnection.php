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
            echo "success, id: ".$id;
            return $id;
        }
        echo "failure";
        echo $stmt->errno;
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
            $trip->setStaffedUsers($this->getStaffingnumberOfTrip($trip));
            array_push($trips, $trip);
        }

        $stmt->close();
        return $trips;
    }
    
    /** (tested)
     * Gets the number of staffed Users of the given Trip
     * @param type $trip
     * @return boolean|int
     */
    private function getStaffingnumberOfTrip($trip){
        $this->connect();
        $stmt = self::$mysqli->prepare("SELECT id FROM usertrip WHERE fk_trip_id = ?");
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
        $price = $insurance->getPrice();
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
    
    /** (tested) ES MUES NO ABGFRÖGT WERDE OB DR USER SCHO OF DE TRIP BUECHT ESCH + ev. RÖCKGABE ÖBERDÄNKE FÖR GNAUERI ANTWORTE (ÖBERBUECHT, DOPPELBUECHIG ETC.)
     * Tries to store a Booking for a User. 
     * $insuranceId can be set (if chosen) or NULL if User doesn't require Insurance
     * @param type $user
     * @param type $trip
     * @param type $insuranceId
     * @return boolean|int
     */
    public function insertBooking($user, $trip, $insuranceId){
        $actualTrip = $this->getTripById($trip->getId());
        
        $this->connect();
        $stmt = null;
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
        if($actualTrip->getMaxStaffing() > $actualTrip->getStaffedUsers() and 
                $actualTrip->getDepartureDate() > date("Y-m-d")){
            //booking is valid
            return $this->executeInsert($stmt);
        }else{
            //booking failed due to overbooking of this Trip
            $stmt->close();
            return false;
        }
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
