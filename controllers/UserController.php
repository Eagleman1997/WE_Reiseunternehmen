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
        echo "register</br>";
        $user = new User();
        $user->setFirstName(filter_input(INPUT_POST, $_POST['firstName'], FILTER_DEFAULT));
        $user->setLastName(filter_input(INPUT_POST, $_POST['lastName'], FILTER_DEFAULT));
        $user->setGender(filter_input(INPUT_POST, $_POST['gender'], FILTER_DEFAULT));
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
        echo "login</br>";
        return true;
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
        echo "logout</br>";
        $user = new User();
        
        return $user->logout();
    }
    
    /**
     * Gets all Users
     * @return boolean\array
     */
    public static function getAllUsers(){
        echo "getAllUsers</br>";
        if($_SESSION['role'] == "admin"){
            $userDBC = new UserDBC();
            $users = $userDBC->getAllUsers();
            //html toDo
        }
    }
    
    
    /**
     * Deletes a User
     */
    public static function deleteUser($userId){
        echo "deleteUser</br>";
        $user = new User();
        
        if($_SESSION['role'] == "admin"){
            $id = Validation::positiveInt($userId);
            if(!$id){
                return false;
            }
            $user->setId($id);
            return $user->delete();
        }
    }
    
    /**
     * Deletes the own account
     */
    public static function deleteSelf(){
        $user = new User();
        $user->setId($_SESSION['userId']);
        return $user->delete();
    }
    
    /**
     * Creates ONE new Participant to the User
     * @return type
     */
    public static function createParticipant(){
        echo "createParticipant</br>";
        $participant = new Participant();
        
        $participant->setFirstName(filter_input(INPUT_POST, $_POST['firstName'], FILTER_DEFAULT));
        $participant->setLastName(filter_input(INPUT_POST, $_POST['lastName'], FILTER_DEFAULT));
        $birthDate = Validation::date(filter_input(INPUT_POST, $_POST['birthDate'], FILTER_DEFAULT));
        if(!$birthDate){
            return false;
        }
        $participant->setBirthDate($birthDate);
        $participant->setFkUserId($_SESSION['userId']);
        
        return $participant->create();
    }
    
    /**
     * Deletes the Participant
     * @return boolean
     */
    public static function deleteParticipant($participantId){
        echo "deleteParticipant</br>";
        $participant = new Participant();
        
        $id = Validation::positiveInt($participantId);
        if(!$id){
            return false;
        }
        $participant->setId($id);
        
        return $participant->delete();
    }
    
    /**
     * Gets a complete User-object with the related Participants if available (Admin can select other Users)
     * @return type
     */
    public static function getParticipants(){
        echo "getParticipants</br>";
        $user = new User();

        $user->setId($_SESSION['userId']);
            
        $participants = $user->findParticipants();
        //html toDo
    }
    
    /**
     * Updates the role of a given User to the given role
     * @return boolean
     */
    public static function changeRole($userId){
        echo "updateRole</br>";
        if($_SESSION['role'] != "admin"){
            return false;
        }
        $user = new User();
        $id = Validation::positiveInt($userId);
        if(!$id){
            return false;
        }
        $user->setId($id);
        
        return $user->changeRole();
    }
    
    /**
     * Provides the homepage (after login) of a admin or user
     */
    public static function getHomepage(){
        echo "getHomepage</br>";
        if($_SESSION['role'] == "admin"){
            echo "homepage admin</br>";
            //html toDo
        }
        if($_SESSION['role'] == "user"){
            echo "homepage user</br>";
            //html toDo
        }
    }
}
