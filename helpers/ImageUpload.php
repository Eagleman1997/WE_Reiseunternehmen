<?php


/**
 * Description of ImageUpload
 *
 * @author Lukas
 */
class ImageUpload {
    
    /**
     * Stores an jpg, jpeg or png into assets/pictures
     * @param type $file
     * @return string filePath if storage succeeded. Otherwise "fileSizeError", "uploadError", "formatError"
     * 
     */
    public static function upload($file){
        
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        
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
    
}
