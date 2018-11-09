<?php

namespace controllers;


/**
 * Controls the registration of a new User
 *
 * @author Lukas
 */
class AuthController {
    
    /**
     * Checks whether the User is logged-in
     * @return boolean
     */
    public static function authenticate(){
        if (isset($_SESSION["login"])) {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Gets the login-view
     */
    public static function loginView(){
        echo "loginView</br>";
        //html toDo
    }
    
    /**
     * Gets the register-view
     */
    public static function registerView(){
        echo "registerView</br>";
        //html toDo
    }

}
