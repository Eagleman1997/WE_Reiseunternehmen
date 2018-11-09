<?php

namespace helpers;
/**
 * Description of ImageUpload
 *
 * @author Lukas
 */
class Upload {
    
    /** (tested)
     * Stores an jpg, jpeg or png into assets/pictures
     * @param type $file
     * @return string filePath if storage succeeded. Otherwise "fileSizeError", "uploadError", "formatError"
     * 
     */
    public static function uploadImage(){
        
        $fileName = $_FILES['img']['name'];
        $fileTmpName = $_FILES['img']['tmp_name'];
        $fileSize = $_FILES['img']['size'];
        $fileError = $_FILES['img']['error'];
        $fileType = $_FILES['img']['type'];
        
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        $allowed = array('jpg', 'jpeg', 'png');
        
        if(in_array($fileActualExt, $allowed)){
            if($fileError === 0){
                if($fileSize < 1000000){
                    $fileNameNew = $fileExt[0].uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'views/assets/img/'.$fileNameNew;
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
    
    /** (tested)
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
                    $fileNameNew = $fileExt[0].uniqid('', true).".".$fileActualExt;
                    $fileDestination = 'views/assets/pdfs/'.$fileNameNew;
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
