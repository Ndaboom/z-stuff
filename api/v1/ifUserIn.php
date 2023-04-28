<?php
require("../../config/database.php");
require('../../includes/functions.php');

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
       
	if(isset($_POST['identifiant']) && isset($_POST['type'])){
       $keyword = $_POST['identifiant'];
       if($_POST['type'] == "phoneNumber"){
       $keyword = "+243".$_POST['identifiant']; 
       }
       
       $q=$db->prepare("SELECT id,name,nom2,email,phoneNumber FROM users WHERE (phoneNumber= :identifiant OR email= :identifiant) AND active='1'");
       $q->execute([
            'identifiant'=> $keyword
       ]);
       $userHasBeenFound=$q->rowCount();
       if($userHasBeenFound>0){

       $user=$q->fetch(PDO::FETCH_OBJ);
       $response['code'] = "200";
       $response['message'] = "Success";
       $response['error'] = false;
   	  $response['id'] = $user->id;
       $response['firstname'] = $user->name;
       $response['lastname'] = $user->nom2;
	  $response['username'] = $user->nom2;
   	  $response['email'] = $user->email;
       $response['phoneNumber'] = $user->phoneNumber;

       }else{
        $response['code'] = "404";
        $response['error'] = true;
   	 $response['message'] = "User not found";
       }
	}else{
	    $response['error'] = true;
   	    $response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);
