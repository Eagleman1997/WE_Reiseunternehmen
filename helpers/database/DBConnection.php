<?php
namespace helpers\database;
use \helpers\database\Config;
use \mysqli;

/**
 * This class provides an appropriate access to the DB
 * @author Lukas
 */
class DBConnection {
    
    private static $dbConnection = null;
    private static $mysqli = null;
    
    /**
     * Singleton pattern to ensure existence of just one db-connection
     * @return type DBConnection
     */
    public static function getDBConnection(){
        if(self::$dbConnection == null){
            self::$dbConnection = new DBConnection();
        }
        return self::$dbConnection;
    }
    
    /**
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
    
    public function checkLogin($email, $password){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if (password_verify($password, $hashedPassword)) {
            // start session
            if (password_needs_rehash($hashedPassword, PASSWORD_DEFAULT)) {
            $reHashedPassword = password_hash($password, PASSWORD_DEFAULT);
                // store the $reHashedPassword in DB
             }
        }
    }
    
    public function insertUser($firstName, $lastName, $street, $zipCode, $location, $email, $birthDate, $password, $role = "user"){
        $this->connect();
        $stmt = self::$mysqli->prepare("INSERT INTO user VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        var_dump($stmt);
        $stmt->bind_param('sssisssss', $firstName, $lastName, $street, $zipCode, $location, $email, $role, $birthDate, $password);
        $stmt->execute();
        $stmt->close();
    }
}
