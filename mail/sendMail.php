<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use controllers\InvoiceController;
use database\UserDBC;
use entities\User;

require 'mail/src/Exception.php';
require 'mail/src/OAuth.php';
require 'mail/src/PHPMailer.php';
require 'mail/src/POP3.php';
require 'mail/src/SMTP.php';



$mail = new PHPMailer(TRUE);

try {
   
    $userId = $_SESSION['userId'];
    $userDBC = new UserDBC();
    $user = $userDBC->findUserById($userId);
    
    if(!$user){
        exit;
    }
    
    //$mailAddress = $user->getEmail();
    //$mailAddress = $user->getEmail();
    
   $mail->setFrom('mail.dreamtrips@gmail.com', 'Dream Trips');
   $mail->addAddress('vanessa.cajochen@hotmail.com', 'Emperor');
   $mail->Subject = 'Lukas du hetsch was guet';
   $mail->Body = 'We can finally send mails!!!.';
   $pdf_url = 'pdf/tempInvoices/'.$_SESSION['tripId'].'.pdf';
   $mail->addAttachment($pdf_url, 'invoice.pdf');
   
   

   
   
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
  
     /* Username (email address). */
     $mail->Username = 'mail.dreamtrips@gmail.com';

     /* Google account password. */
     $mail->Password = 'Wnb-6rm-qdT-ttq';

   

   
   $mail->send();
}
catch (Exception $e)
{
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   echo $e->getMessage();
}





   
   
   
