<?php

namespace entities;

use database\UserDBC;

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
    private $participants;
    private $userDBC;
    
    public function __construct() {
        $this->userDBC = new UserDBC();
    }

    /** (tested)
     * Registers a new User
     */
    public function register(){
        if($this->userDBC->findUserByEmail($this)){
            //doublicate of e-mails are not allowed
            return false;
        }
        
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $userId = $this->userDBC->createUser($this);
        if($userId){
            $_SESSION['userId'] = $userId;
            $_SESSION['login'] = true;
            $_SESSION['role'] = $this->role;
            return $userId;
        }else{
            //creation failed
            return false;
        }
    }
    
    /** (tested)
     * Logs the User in if email and password are correct
     */
    public function login(){
        $userObj = $this->userDBC->findUserByEmail($this);
        if($userObj){
            $password = $userObj->getPassword();
        }else{
            //User doesn't exist
            return false;
        }
        
        if (password_verify($this->password, $password)) {
            if (password_needs_rehash($password, PASSWORD_DEFAULT)) {
                $reHashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->password = $reHashedPassword;
                $this->userDBC->updatePassword($this);
            }
            echo "userId: ".$userObj->getId()."</br>";
            $_SESSION['userId'] = $userObj->getId();
            $_SESSION['login'] = true;
            $_SESSION['role'] = $userObj->getRole();
        return true;
        }else{
            //password is incorrect
            return false;
        }
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
        //logout succeeded
        return true;
    }
    
    /** (tested)
     * Deletes the User
     * @return type
     */
    public function delete(){
        return $this->userDBC->deleteUser($this);
    }
    
    /**
     * Finds any Participant in relation to the User
     * @return type
     */
    public function findParticipants(){
        $user = $this->userDBC->findUserById($this);
        if(!$user){
            return false;
        }
        $participants = $this->userDBC->findParticipants($user);
        $user->setParticipants($participants);
        return $user;
    }
    
    /**
     * Books a Trip
     * @param type $trip
     * @param type $insurance
     */
    public function bookTrip($trip, $insurance){
        $insuranceId = null;
        if($insurance){
            $insurances = $this->userDBC->getInsurances();
            $insuranceInstance = $insurances[0];//this assumes that there is just one Insurance to consider
            $insuranceId = $insuranceInstance->getId();
        }
        return $this->userDBC->insertBooking($this, $trip, $insuranceId);
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
        /* @var $id type int*/
        $this->id = (int) $id;
    }
    
    public function getParticipants(){
        return $this->participants;
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
        /* @var $zipCode type int*/
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
    
    public function setParticipants($participants){
        $this->participants = $participants;
    }

}
