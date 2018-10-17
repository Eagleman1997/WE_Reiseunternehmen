<?php
class StaticClass{
    private static $myStaticField;
    
    public static function setMyStaticField($data){
        self::$myStaticField = $data; // auf private static Variablen mit self:: zugreifen
    }
    
    public static function getMyStaticField(){
        return self::$myStaticField;
    }
    
}

$obj = new StaticClass();

echo $obj->getMyStaticField();

StaticClass::setMyStaticField("data text");
echo StaticClass::getMyStaticField();