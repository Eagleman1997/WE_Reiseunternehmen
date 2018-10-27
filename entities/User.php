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
        if(isset($this)){
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            if($this->dbConnection->registerUser($this)){
                // start session
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    /**
     * Logs the User in if email and password are correct
     */
    public function login(){
        if(isset($this)){
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
            $password = $this->dbConnection->getPasswordByEmail($this);
        
            if (password_verify($password, $this->password)) {
                if (password_needs_rehash($this->password, PASSWORD_DEFAULT)) {
                $reHashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->password = $reHashedPassword;
                $this->dbConnection->updatePassword($this);
                }
            }else{
                return false;
            }
            // start session
        }else{
            return false;
        }
    }
    
    /**
     * Logs the User out and kills the session if he is logged in
     */
    public function logout(){
        if (ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]);
        }
        session_destroy();
        //go back to starting page page
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
