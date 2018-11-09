<?php

namespace helpers;

/**
 * Computes the margins of the Trip and Insurance
 *
 * @author Lukas
 */
class Margin {
    
    private static $insuranceMargin = 1.1;
    private static $tripMargin = 1.2;
    
    /**
     * Computes Insurance margin
     * @param type $money
     * @return type
     */
    public static function addInsurance($money){
        return $money * self::$insuranceMargin;
    }
    
    /**
     * Computes Trip margin
     * @param type $money
     * @return type
     */
    public static function addTrip($money){
        return $money * self::$tripMargin;
    }
    
}
