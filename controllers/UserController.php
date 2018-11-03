<?php

namespace controllers;

use entities\User;
use entities\Trip;
use entities\Participant;
use database\UserDBC;
use helpers\Validation;

/**
 * Controls the Login and Logout of a User
 *
 * @author Lukas
 */
class UserController {
    
    /**
     * Controlls the registration process of a new User
     * 
     */
    public static function register(){
        $user = new User();
        $user->setFirstName(filter_input(INPUT_POST, $_POST['firstName'], FILTER_DEFAULT));
        $user->setLastName(filter_input(INPUT_POST, $_POST['lastName'], FILTER_DEFAULT));
        $user->setStreet(filter_input(INPUT_POST, $_POST['street'], FILTER_DEFAULT));
        $zipCode = Validation::zipCode(filter_input(INPUT_POST, $_POST['zipCode'], FILTER_VALIDATE_INT));
        if(!$zipCode){
            return false;
        }
        $user->setZipCode($zipCode);
        $user->setLocation(filter_input(INPUT_POST, $_POST['location'], FILTER_DEFAULT));
        $email = filter_input(INPUT_POST, $_POST['email'], FILTER_VALIDATE_EMAIL);
        if(!$email){
            return false;
        }
        $user->setEmail($email);
        $birthDate = Validation::date(filter_input(INPUT_POST, $_POST['birthDate'], FILTER_DEFAULT));
        if(!$birthDate){
            return false;
        }
        $user->setBirthDate($birthDate);
        $user->setPassword(filter_input(INPUT_POST, $_POST['password'], FILTER_DEFAULT));
        //default role user (not admin)
        $user->setRole("user");
        
        return $user->register();
    }
    
    /**
     * Controlls the login process of a User
     * 
     * @param type $email
     * @param type $password
     */
    public static function login(){
        $user = new User();
        $email = filter_input(INPUT_POST, $_POST['email'], FILTER_VALIDATE_EMAIL);
        if(!$email){
            return false;
        }
        $user->setEmail($email);
        $user->setPassword(filter_input(INPUT_POST, $_POST['password'], FILTER_DEFAULT));
        
        return $user->login();
    }
    
    /**
     * Controlls the logout process of a User
     */
    public static function logout(){
        $user = new User();
        
        return $user->logout();
    }
    
    public static function getAllUsers(){
        if($_SESSION['role'] == "admin"){
            $userDBC = new UserDBC();
            return $userDBC->getAllUsers();
        }else{
            return false;
        }
    }
    
    
    /**
     * Deletes the User (Admins can delete other Users)
     * @return type
     */
    public static function deleteUser(){
        //router must perform the role validation too to guide to the correct side (i.e. login if it was an user)
        $user = new User();
        
        if($_SESSION['role'] == "admin"){
            $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['userId'], FILTER_VALIDATE_INT));
            if(!$id){
                return false;
            }
            $user->setId($id);
        }else{
            $user->setId($_SESSION['userId']);
        }
        
        return $user->delete();
    }
    
    /**
     * Creates ONE new Participant to the User
     * @return type
     */
    public static function createParticipant(){
        $participant = new Participant();
        
        $participant->setFirstName(filter_input(INPUT_POST, $_POST['firstName'], FILTER_DEFAULT));
        $participant->setLastName(filter_input(INPUT_POST, $_POST['lastName'], FILTER_DEFAULT));
        $birthDate = Validation::date(filter_input(INPUT_POST, $_POST['birthDate'], FILTER_DEFAULT));
        if(!$birthDate){
            return false;
        }
        $participant->setBirthDate($birthDate);
        $participant->setFkUserId($_SESSION['userId']);
        
        return $participant->createParticipant();
    }
    
    /**
     * Gets a complete User-object with the related Participants if available (Admin can select other Users)
     * @return type
     */
    public static function getParticipants(){
        $user = new User();
        
        if($_SESSION['role'] == "admin"){
            $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['userId'], FILTER_VALIDATE_INT));
            if(!$id){
                return false;
            }
            $user->setId($id);
        }else{
            $user->setId($_SESSION['userId']);
        }
        return $user->findParticipants();
    }
    
    /**
     * Updates the role of a given User to the given role
     * @return boolean
     */
    public static function updateRole(){
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $user = new User();
        $id = Validation::positiveInt(filter_input(INPUT_POST, $_POST['userId'], FILTER_VALIDATE_INT));
        if(!$id){
            return false;
        }
        $user->setId($id);
        $user->setRole(filter_input(INPUT_POST, $_POST['role'], FILTER_DEFAULT));
        
        return $user->updateRole();
    }
    
    /**
     * Books a Trip
     */
    public static function bookTrip(){
        $user = new User();
        $trip = new Trip();
        
        $trip->setId(filter_input(INPUT_POST, $_POST['tripId'], FILTER_VALIDATE_INT));
        $insurance = filter_input(INPUT_POST, $_POST['insurance'], FILTER_VALIDATE_BOOLEAN);
        $user->setId($_SESSION['userId']);
        
        $answer = $user->bookTrip($trip, $insurance);
        //do something with the answer, possible:(overbooked, outdated, doublebooked, id, false)
    }
}
