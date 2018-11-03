<?php

namespace helpers;
/**
 * Description of ImageUpload
 *
 * @author Lukas
 */
class Upload {
    
    /**
     * Stores an jpg, jpeg or png into assets/pictures
     * @param type $file
     * @return string filePath if storage succeeded. Otherwise "fileSizeError", "uploadError", "formatError"
     * 
     */
    public static function uploadImage(){
        
        $fileName = $_FILES['picture']['name'];
        $fileTmpName = $_FILES['picture']['tmp_name'];
        $fileSize = $_FILES['picture']['size'];
        $fileError = $_FILES['picture']['error'];
        $fileType = $_FILES['picture']['type'];
        
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        $allowed = array('jpg', 'jpeg', 'png');
        
        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 1000000){
                    $fileNameNew = $fileName.uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'assets/pictures/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return $fileNameNew;
                }else{
                    return "fileSizeError";
                }
            }else{
                return "uploadError";
            }
        }else{
            return "formatError";
        }
        
    }
    
    /**
     * Stores an pdf into assets/pdfs
     * @param type $file
     * @return string filePath if storage succeeded. Otherwise "fileSizeError", "uploadError", "formatError"
     * 
     */
    public static function uploadPdf(){
        
        $fileName = $_FILES['pdf']['name'];
        $fileTmpName = $_FILES['pdf']['tmp_name'];
        $fileSize = $_FILES['pdf']['size'];
        $fileError = $_FILES['pdf']['error'];
        $fileType = $_FILES['pdf']['type'];
        
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        $allowed = array('pdf');
        
        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 1000000){
                    $fileNameNew = $fileName.uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'assets/pdfs/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return $fileNameNew;
                }else{
                    return "fileSizeError";
                }
            }else{
                return "uploadError";
            }
        }else{
            return "formatError";
        }
        
    }
    
}
