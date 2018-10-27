<?php

namespace controllers;

use entities\User;

/**
 * Controlls the registration of a new User
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
        $user->setFirstName($_SESSION['firstName']);
        $user->setLastName($_SESSION['lastName']);
        $user->setStreet($_SESSION['street']);
        $user->setZipCode($_SESSION['zipCode']);
        $user->setLocation($_SESSION['location']);
        $user->setEmail($_SESSION['email']);
        $user->setBirthDate($_SESSION['birthDate']);
        $user->setPassword($_SESSION['password']);
        //default role user (not admin)
        $user->setRole("user");
        
        $user->register();
        //return html after registering
    }
    
}
