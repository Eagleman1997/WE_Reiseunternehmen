<?php

namespace controllers;

use entities\User;

/**
 * Controlls the Login and Logout of a User
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
        $user->setEmail($_SESSION['email']);
        $user->setPassword($_SESSION['password']);
        $user->setId($_SESSION['user_id']);
        
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
