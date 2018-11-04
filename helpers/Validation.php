<?php

namespace helpers;

/**
 * Description of Validation
 *
 * @author Lukas
 */
class Validation {
    
    /** (tested)
     * Checks whether a given number is an integer and positive
     * @param type $number
     * @return boolean
     */
    public static function positiveInt($number){
        $number = (int) $number;
        if(is_int($number) and $number > 0){
            return $number;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Checks whether a given price is a double and positive
     * @param type $price
     * @return boolean
     */
    public static function positivePrice($price){
        $price = (double) $price;
        if(is_double($price) and $price > 0){
            return $price;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Checks whether a given date is in format YYYY-MM-DD
     * @param type $date
     * @return boolean|string
     */
    public static function date($date){
        if(preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date)){
            return $date;
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Checks whether a given date is in format YYYY-MM-DD and lies in the future
     * @param type $date
     * @return boolean|string
     */
    public static function upToDate($date){
        if(!self::date($date)){
            return false;
        }
        $today = date("Y-m-d");
        if($date > $today){
            return $date;
        }
        return false;
    }
    
    /**
     * Checks if the type of the Invoice is valid
     * Allowed: "hotel", "bus", "insurance"
     * @param type $type
     * @return boolean|string
     */
    public static function invoiceType($type){
        $allowed = array("hotel", "bus", "insurance");
        if(in_array(strtolower($type), $allowed)){
            return strtolower($type);
        }else{
            return false;
        }
    }
    
    /** (tested)
     * Checks whether a given $zipCode is in int format and between 0 and 100000
     * @param type $zipCode
     * @return boolean
     */
    public static function zipCode($zipCode){
        $zipCode = (int) $zipCode;
        if(is_int($zipCode) and $zipCode > 0 and $zipCode < 100000){
            return $zipCode;
        }else{
            return false;
        }
    }
    
}
