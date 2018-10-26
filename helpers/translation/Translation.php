<?php

namespace translation;
/**
 * This class provides the correct translation of an english key
 *
 * @author Lukas
 */
class Translation {
    
    private $fileType = ".inc.php";
    private $translator = null;
    /**
     * Sets the language if valid in the constructon process
     * @param type $language
     */
    public function __construct($language) {
        if($this->checkLanguage($language)){
            include $language.$this->fileType;
            $this->translator = $array;
        }else{
            echo"Language is not valid";
        }
    }
    
    /**
     * Allows to select the language "en" or "de"
     * @param type $language
     * @return boolean, true, if the argument was valid ("en" or "de")
     */
    private function checkLanguage($language){
        if($language == "en" OR $language == "de"){
            return true;
        }
        return false;
    }
    
    /**
     * Returnes the translated word matching the $key
     * @param type $key
     * @return type
     */
    public function get($key){
        if($this->translator != null){
            return $this->translator[$key];
        }else{
            return null;
        }
    }
}
