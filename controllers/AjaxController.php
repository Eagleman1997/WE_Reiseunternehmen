<?php

namespace controllers;

use database\UserDBC;


/**
 * Ajax helper
 *
 */
class AjaxController {
    
    public static function checkEmail($email){
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