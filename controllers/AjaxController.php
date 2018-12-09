<?php

namespace controllers;

use database\UserDBC;


/**
 * Ajax helper
 *
  * @author Vanessa Cajochen
 */

class AjaxController {
    
    public static function checkEmail(){
        $email = filter_input(\INPUT_POST, 'email', \FILTER_VALIDATE_EMAIL);
        if(!$email){
            return false;
        }
        $user = new UserDBC();
        header('Content-type: application/json');
        if($user->checkByEmail($email)){
            $response_array['status'] = 'error';  
        }else {
            $response_array['status'] = 'success';  
        }
        echo json_encode($response_array);
        return true;
     }
      
     
     
     public static function checkLogin(){
        $email = filter_input(\INPUT_POST, 'email', \FILTER_VALIDATE_EMAIL);
        if(!$email){
            return false;
        }
        
        $user = new UserDBC();
        header('Content-type: application/json');
        if($user->checkByEmail($email)){
            $response_array['status'] = 'error';  
        }else {
            $response_array['status'] = 'success';  
        }
        echo json_encode($response_array);
        return true;
         
         
     }
     
     
}