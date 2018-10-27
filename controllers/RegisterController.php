<?php

namespace controllers;

use entities\User;

/**
 * Controls the registration of a new User
 *
 * @author Lukas
 */
class RegisterController {
    
    /**
     * Controlls the registration process of a new User
     * 
     */
    public static function register(){
        $user = new User();
        $user->setFirstName(filter_input(INPUT_POST, $_POST['firstName'], FILTER_DEFAULT));
        $user->setLastName(filter_input(INPUT_POST, $_POST['lastName'], FILTER_DEFAULT));
        $user->setStreet(filter_input(INPUT_POST, $_POST['street'], FILTER_DEFAULT));
        $user->setZipCode(filter_input(INPUT_POST, $_POST['zipCode'], FILTER_VALIDATE_INT));
        $user->setLocation(filter_input(INPUT_POST, $_POST['location'], FILTER_DEFAULT));
        $user->setEmail(filter_input(INPUT_POST, $_POST['email'], FILTER_VALIDATE_EMAIL));
        $user->setBirthDate(filter_input(INPUT_POST, $_POST['birthDate'], FILTER_DEFAULT));
        $user->setPassword(filter_input(INPUT_POST, $_POST['password'], FILTER_DEFAULT));
        //default role user (not admin)
        $user->setRole("user");
        
        $user->register();
        //return html after registering
    }
    
}
