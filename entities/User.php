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
    private $gender;
    private $street;
    private $zipCode;
    private $location;
    private $email;
    private $role;
    private $birthDate;
    private $password;
    private $participants;
    private $lastBooking;
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
            //AJAX to tell this to the User
            return false;
        }
        
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $userId = $this->userDBC->createUser($this);
        if($userId){
            session_regenerate_id();
            if((isset($_SESSION['role']) and $_SESSION['role'] == "admin")){
                //nothing toDo here
            }else{
                $_SESSION['userId'] = $userId;
                $_SESSION['login'] = true;
                $_SESSION['role'] = $this->role;
            }
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
            session_regenerate_id();
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
    * Checks if the email already exists.
    * If the email exists, it will check if the entered password is correct.
    *
    * @author Vanessa Cajochen
    */
    public function loginPreCheck(){
        $userObj = $this->userDBC->findUserByEmail($this);
        if($userObj){
            $password = $userObj->getPassword();
        }else{
            //User doesn't exist
            return false;
        }
        
        if (password_verify($this->password, $password)) {                        
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
     * @return boolean|User
     */
    public function findParticipants(){
        $user = $this->userDBC->findUserById($this->id);
        if(!$user){
            return false;
        }
        $participants = $this->userDBC->findParticipants($user);
        $user->setParticipants($participants);
        return $user;
    }
    
    /**
     * Changes and updates the role of a User
     * @return type
     */
    public function changeRole(){
        $user = $this->userDBC->findUserById($this->getId());
        if($user->getRole() == "user"){
            $this->setRole("admin");
        }else if($user->getRole() == "admin"){
            if(!($this->userDBC->checkLastAdmin($user))){
                return false;
            }
            $this->setRole("user");
        }
        $result = $this->userDBC->updateRole($this);
        if($result){
            $_SESSION['role'] = $this->getRole();
        }
        return $result;
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
    
    public function getGender()
    {
        return $this->gender;
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
    
    public function getLastBooking(){
        return $this->lastBooking;
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
    
    public function setGender($gender){
        $this->gender = $gender;
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
    
    public function setLastBooking($lastBooking){
        $this->lastBooking = $lastBooking;
    }
    
    public function setParticipants($participants){
        $this->participants = $participants;
    }

}
