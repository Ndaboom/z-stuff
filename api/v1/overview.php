<?php
require("../../config/database.php");
require('../../includes/functions.php');

$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){

   if(!empty($_POST['user_id'])){

     $user_id = $_POST['user_id'];
     $query = "
       SELECT * FROM chat_message
       WHERE to_user_id = '$user_id'
       AND status = '1'
      ";
  $statement = $db->prepare($query);
	if($statement->execute()){

     $count= $statement->rowCount();
     $output= '';
     
     if($count > 0)
     {
        $output= 'You have '.$count.' new notifications';
     }
     else
     {
        $output= 'No new notification';
     }

	$response['error'] = false;
  $response['message'] = $output;

	}else{
	$response['error'] = true;
   	$response['message'] = "Some errors occured...";
	}


   }else{
   	$response['error'] = true;
   	$response['message'] = "Something went wrong";
   }

}else{
    $response['error'] = true;
    $response['message'] = "Invalid Request";
}
echo json_encode($response);
