<?php

namespace entities;

use helpers\database\DBConnection;

/**
 * User Entity
 *
 * @author Lukas
 */
class User {
    
    private $id;
    private $firstName;
    private $lastName;
    private $street;
    private $zipCode;
    private $location;
    private $email;
    private $role;
    private $birthDate;
    private $password;
    private $dbConnection;
    
    public function __construct() {
        $this->dbConnection = DBConnection::getDBConnection();
    }

    /**
     * Registers a new User
     */
    public function register(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $userId = $this->dbConnection->registerUser($this);
        if($userId){
            $_SESSION['userId'] = $userId;
            // start session
        }else{
            return false;
        }
    }
    
    /**
     * Logs the User in if email and password are correct
     */
    public function login(){
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $userObj = $this->dbConnection->getUserByEmail($this);
        $password = $userObj->getPassword();
        
        if (password_verify($password, $this->password)) {
            if (password_needs_rehash($this->password, PASSWORD_DEFAULT)) {
            $reHashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->password = $reHashedPassword;
            $this->dbConnection->updatePassword($this);
            }
        }else{
            return false;
        }
        $_SESSION['userId'] = $userObj->getId();
        // start session
    }
    
    /**
     * Logs the User out and kills the session if he is logged in
     */
    public function logout(){
        //set this on starting page
        session_unset();
        session_destroy();
        unset($_SESSION);

        if (ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
        }
        //go back to starting page
    }
    
    /**
     * Books a Trip
     * @param type $trip
     * @param type $insurance
     */
    public function bookTrip($trip, $insurance){
        $insuranceId = null;
        if($insurance){
            $insurances = $this->dbConnection->getInsurances();
            $insuranceInstance = $insurances[0];//this assumes that there is just one Insurance to consider
            $insuranceId = $insuranceInstance->getId();
        }
        return $this->dbConnection->insertBooking($this, $trip, $insuranceId);
    }

    
    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getStreet() {
        return $this->street;
    }

    public function getZipCode() {
        return $this->zipCode;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->role;
    }

    public function getBirthDate() {
        return $this->birthDate;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function setStreet($street) {
        $this->street = $street;
    }

    public function setZipCode($zipCode) {
        /* @var $zipCode type integer*/
        $this->zipCode = (int) $zipCode;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setBirthDate($birthDate) {
        $this->birthDate = $birthDate;
    }

    public function setPassword($password) {
        $this->password = $password;
    }


}
