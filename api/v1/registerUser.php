<?php
require("../../config/database.php");
require('../../includes/functions.php');

$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){

   if(!empty($_POST['name']) and
       !empty($_POST['nom2']) and
        !empty($_POST['email']) and !empty($_POST['pass'])){
   	    if (!is_already_in_use('email',$_POST['email'],'users')){
   	
   	$activation_code = rand(1000, 9999);        
   	
    //           $q=$db->prepare('INSERT INTO users(name,nom2,email,password,profilepic,coverpic,active,account_activation_code)
    // 	                 VALUES(:name,:nom2,:email,:password,:profilepic,:coverpic,:active,:account_activation_code)');
    // 	if($q->execute([
    // 	'name'=> $_POST['name'],
    // 	'nom2'=>$_POST['nom2'],
    // 	'email'=>$_POST['email'],
    // 	'password'=>sha1($_POST['pass']),
    // 	'profilepic'=>"images/default.png",
    // 	'coverpic'=>"images/cover.jpeg",
    // 	'active'=>1,
    // 	'account_activation_code'=> $activation_code
    // 	])){
	     
	     
        //  $subject = "Account activation code";
         
        //  $message = '<b>Your account activation code is "'.$activation_code.'"</b><br>';
        //  $header = "From:info@zungvi.com \r\n";
        //  $header .= "Cc:info@zungvi.com \r\n";
        //  $header .= "MIME-Version: 1.0\r\n";
        //  $header .= "Content-type: text/html\r\n";
         
        //  $retval = mail($to,$subject,$message,$header);
         
         $response['error'] = true;
         $response['message'] = "Cette version est expiree, Telechargez la derniere version sur le playstore...";
        
        //  $last_id = $db->lastInsertId();
         
        
        //  $response['id'] = $last_id;
        //  $response['email'] = $_POST['email'];
        //  $response['name'] = $_POST['name'];


// 	}else{
// 	$response['error'] = true;
//   	$response['message'] = "Some errors occured...";
// 	}
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
