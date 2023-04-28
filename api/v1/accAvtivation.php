<?php
require("../../config/database.php");
require('../../includes/functions.php');

$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){

   $q=$db->prepare("SELECT id FROM users
                  WHERE phoneNumber= :phoneNumber 
                  AND account_activation_code= :account_activation_code");
    $q->execute([
            'phoneNumber'=> $_POST['user_phone'],
            'account_activation_code'=>$_POST['activation_code']
      ]);
      $userHasBeenFound=$q->rowCount();
       if($userHasBeenFound>0){
        
        $q=$db->prepare("UPDATE users
                  SET number_verified= :number_verified 
                  WHERE phoneNumber= :phoneNumber");
        $q->execute([
            'number_verified'=> 1,
            'phoneNumber'=>$_POST['user_phone']
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
