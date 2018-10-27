<?php

namespace controllers;

use entities\User;

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
    
}
