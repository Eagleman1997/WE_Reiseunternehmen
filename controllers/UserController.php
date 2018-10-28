<?php

namespace controllers;

use entities\User;
use entities\Trip;
use controllers\TripController;

/**
 * Controls the Login and Logout of a User
 *
 * @author Lukas
 */
class UserController {
    
    /**
     * Controlls the login process of a User
     * 
     * @param type $email
     * @param type $password
     */
    public static function login(){
        $user = new User();
        $user->setEmail(filter_input(INPUT_POST, $_POST['email'], FILTER_VALIDATE_EMAIL));
        $user->setPassword(filter_input(INPUT_POST, $_POST['password'], FILTER_DEFAULT));
        
        $user->login();
        //return html after login
    }
    
    /**
     * Controlls the logout process of a User
     */
    public static function logout(){
        $user = new User();
        
        $user->logout();
        //return html title page
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
        
        $user->bookTrip($trip, $insurance);
    }
}
