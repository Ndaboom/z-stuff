<?php
require("../../config/database.php");
require('../../includes/functions.php');

$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){

   	
   	$activation_code = rand(1000, 9999);        
   	
           $q=$db->prepare('UPDATE users SET activation_code= :activation_code
                            WHERE email= :email)');
	if($q->execute([
	'account_activation_code'=> $activation_code,
	'email'=>$_POST['user_email']
	])){
	     
	     $to = $_POST['user_email'];
	     
         $subject = "Account activation code";
         
         $message = '<b>Your account activation code is "'.$activation_code.'"</b><br>';
         $header = "From:info@zungvi.com \r\n";
         $header .= "Cc:info@zungvi.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         $response['error'] = false;
         $response['message'] = "Email resent!";
    


	}else{
	$response['error'] = true;
   	$response['message'] = "Some errors occured...";
	}
   	
}else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}
echo json_encode($response);
