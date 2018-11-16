<?php

namespace helpers;

/**
 * Description of Numbers
 *
 * @author Lukas
 */
class Numbers {
    
    private static $minAllocation = 12;
    private static $maxAllocation = 20;
    
    public static function getMinAllocation(){
        return self::$minAllocation;
    }
    
    public static function getMaxAllocation(){
        return self::$maxAllocation;
    }
    
    /**
     * Rounds the given price to the nearest 0.5
     * @param type $price
     * @return type
     */
    public static function roundPrice($price){
        return round($price * 20, 0) / 20;
    }
    
}
