<?php
require("../../config/database.php");
require('../../includes/functions.php');

$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){

   $q=$db->prepare("SELECT id FROM users
                  WHERE email= :email 
                  AND account_activation_code= :account_activation_code");
    $q->execute([
            'email'=> $_POST['user_email'],
            'account_activation_code'=>$_POST['activation_code']
      ]);
      $userHasBeenFound=$q->rowCount();
       if($userHasBeenFound>0){
        
        $q=$db->prepare("UPDATE users
                  SET email_verified= :email_verified, active= :active
                  WHERE email= :email");
        $q->execute([
            'email_verified'=> 1,
            'active'=>1,
            'email'=>$_POST['user_email']
        ]);
        
         $response['error'] = false;
         $response['message'] = "Account activated!";
           
       }else{
         $response['error'] = true;
         $response['message'] = "Invalid activation code!";  
       }


}else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}
echo json_encode($response);
