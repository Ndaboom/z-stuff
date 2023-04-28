<?php
require("../../config/database.php");
require('../../includes/functions.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'pvendor/autoload.php';


$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){

   if(!empty($_POST['name']) and
       !empty($_POST['nom2']) and
        !empty($_POST['email']) and !empty($_POST['pass'])){
            
   	    if (!is_already_in_use('email',$_POST['email'],'users')){
   	
   	       $activation_code = rand(1000, 9999); 
   	       
   	
           $q=$db->prepare('INSERT INTO users(name,nom2,email,password,profilepic,coverpic,active,account_activation_code)
	                 VALUES(:name,:nom2,:email,:password,:profilepic,:coverpic,:active,:account_activation_code)');
	if($q->execute([
	'name'=> $_POST['name'],
	'nom2'=>$_POST['nom2'],
	'email'=>$_POST['email'],
	'password'=>sha1($_POST['pass']),
	'profilepic'=>"images/default.png",
	'coverpic'=>"images/cover.jpeg",
	'active'=>0,
	'account_activation_code'=> $activation_code
	])){
	     
	     $to = $_POST['email'];
	     $last_id = $db->lastInsertId();
	     
	     //Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer();
      
            // $mail->SMTPDebug = true;            
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.supremecluster.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'registration@zungvi.com';                     //SMTP username
            $mail->Password   = 'SN085@gmail.com';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('registration@zungvi.com', 'Zungvi');
            $mail->addAddress($_POST['email'], $_POST['name']);  
            //$mail->addReplyTo('info@zungvi.com', 'Information');
            $mail->addCC('registrationinfo@zungvi.com');
           
            $mail->Subject = 'Zungvi activation code';
            $mail->Body    = 'Hey '.$_POST['name'].', your activation code is <b>'.$activation_code.'.</b>';
            $mail->AltBody = 'Thanks for being among us';
        
            $mail->send();
             
             $response['id'] = $last_id;
             $response['email'] = $_POST['email'];
             $response['name'] = $_POST['name'];
             
             $response['error'] = false;
             $response['message'] = "Account created successfully";
            

}else{
	$response['error'] = true;
   	$response['message'] = "Some errors occured...";
	}
   }else{
      
        $response['error'] = true; 
        $response['message'] = "Email already in use...";   
        
   }

   }else{
   	$response['error'] = true;
   	$response['message'] = "Required fields are missing";
   }

}else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}
echo json_encode($response);
