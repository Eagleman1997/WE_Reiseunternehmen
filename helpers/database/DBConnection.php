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
        $stmt->close();
        if(!$success){
            return false;
        }
        return true;
    }
    
    /** (tested)
     * Gets the hashed password to the given email
     * @param type $email
     * @return String stored (hashed) password if query was successful
     *         boolean false if query failed (usually email is not stored in database)
     */
    public function getPasswordByEmail($user){
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
            return $userObj->getPassword();
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
        $stmt = self::$mysqli->prepare("INSERT INTO trip VALUES (NULL, ?, ?, ?, ?, ?, ?)");
        if(!$stmt){
            return false;
        }
        $stmt->bind_param('ssssdi', $name, $picturePath, $description, $departureDate, $price, $durationInDays);
        $name = $trip->getName();
        $picturePath = $trip->getPicturePath();
        $description = $trip->getDescription();
        $departureDate = $trip->getDepartureDate();
        $price = $trip->getPrice();
        $durationInDays = $trip->getDurationInDays();
        return $this->executeInsert($stmt);
    }
}
