<?php

namespace controllers;

use views\TemplateView;
use views\LayoutRendering;


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
        $homepage = new TemplateView("homepage.php");
        LayoutRendering::basicLayout($homepage, "headerLoggedOut");
    }
    
    /**
     * Gets the register-view
     */
    public static function registerView(){
        echo "registerView</br>";
        //html toDo
    }

}
