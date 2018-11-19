<?php

namespace controllers;

use entities\User;
use entities\Trip;
use entities\Participant;
use database\UserDBC;
use helpers\Validation;
use views\LayoutRendering;
use views\TemplateView;
use http\HTTPException;
use http\HTTPHeader;
use http\HTTPStatusCode;

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
        $user->setFirstName(\filter_input(\INPUT_POST, 'firstName', \FILTER_DEFAULT));
        $user->setLastName(\filter_input(\INPUT_POST, 'lastName', \FILTER_DEFAULT));
        $user->setGender(\filter_input(\INPUT_POST, 'gender', \FILTER_DEFAULT));
        $user->setStreet(\filter_input(\INPUT_POST, 'street', \FILTER_DEFAULT));
        $zipCode = Validation::zipCode(\filter_input(\INPUT_POST, 'zipCode', \FILTER_VALIDATE_INT));
        if(!$zipCode){
            return false;
        }
        $user->setZipCode($zipCode);
        $user->setLocation(\filter_input(\INPUT_POST, 'location', \FILTER_DEFAULT));
        $email = filter_input(\INPUT_POST, 'email', \FILTER_VALIDATE_EMAIL);
        if(!$email){
            return false;
        }
        $user->setEmail($email);
        $birthDate = Validation::date(\filter_input(\INPUT_POST, 'birthDate', \FILTER_DEFAULT));
        if(!$birthDate){
            return false;
        }
        $user->setBirthDate($birthDate);
        $user->setPassword(\filter_input(\INPUT_POST, 'password', \FILTER_DEFAULT));
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
        $email = \filter_input(\INPUT_POST, 'email', \FILTER_VALIDATE_EMAIL);
        if(!$email){
            return false;
        }
        $user->setEmail($email);
        $user->setPassword(\filter_input(\INPUT_POST, 'password', \FILTER_DEFAULT));
        
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
     */
    public static function getAllUsers(){
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $userDBC = new UserDBC();
            $users = $userDBC->getAllUsers();
            
            $adminUsers = new TemplateView("adminUsers.php");
            $adminUsers->users = $users;
            LayoutRendering::basicLayout($adminUsers);
        }
    }
    
    
    /**
     * Deletes a User
     */
    public static function deleteUser($userId){
        $user = new User();
        
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $id = Validation::positiveInt($userId);
            if(!$id){
                return false;
            }
            $user->setId($id);
            $user->delete();
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
        $participant = new Participant();
        
        $participant->setFirstName(\filter_input(\INPUT_POST, 'firstName', \FILTER_DEFAULT));
        $participant->setLastName(\filter_input(\INPUT_POST, 'lastName', \FILTER_DEFAULT));
        $birthDate = Validation::date(\filter_input(\INPUT_POST, 'birthDate', \FILTER_DEFAULT));
        if(!$birthDate){
            return false;
        }
        $participant->setBirthDate($birthDate);
        $participant->setFkUserId($_SESSION['userId']);
        
        $participant->create();
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
     * Gets a complete User-object with the related Participants if available
     */
    public static function getParticipants(){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "user")){
            return false;
        }
        $user = new User();

        $user->setId($_SESSION['userId']);
            
        $travelersView = new TemplateView("addTravelers.php");
        $travelersView->participants = $user->findParticipants()->getParticipants();
        LayoutRendering::basicLayout($travelersView, "headerUserLoggedIn");
    }
    
    /**
     * Updates the role of a given User to the given role
     * @return boolean
     */
    public static function changeRole($userId){
        if(!isset($_SESSION['role']) or (isset($_SESSION['role']) and $_SESSION['role'] != "admin")){
            return false;
        }
        $user = new User();
        $id = Validation::positiveInt($userId);
        if(!$id){
            return false;
        }
        $user->setId($id);
        
        $user->changeRole();
        HTTPHeader::setStatusHeader(HTTPStatusCode::HTTP_204_NO_CONTENT);
    }
    
    /**
     * Provides the homepage (after login) of a admin or user
     */
    public static function getHomepage(){
        if(isset($_SESSION['role']) and $_SESSION['role'] == "admin"){
            $homepage = new TemplateView("adminMain.php");
            LayoutRendering::basicLayout($homepage);
        }
        if(isset($_SESSION['role']) and $_SESSION['role'] == "user"){
            $homepage = new TemplateView("homepage.php");
            LayoutRendering::basicLayout($homepage, "headerUserLoggedIn");
        }
    }
}
