<?php

require("../config/database.php");
require('../includes/functions.php');

$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
   $found = false;
   if(!empty($_POST['username'])){

     $q=$db->prepare("SELECT * FROM users");
     $q->execute();
     $users = $q->fetchAll(PDO::FETCH_OBJ);

     foreach($users as $user){

        $firstname = strtolower($user->name);
        $lastname = strtolower($user->nom2);

        $second_name = $firstname." ".$lastname;

        similar_text($_POST['username'], $second_name, $percent);


        if($percent > 55){

          $found = true;

          $response['error'] = false;
          $response['message'] = $_POST['username']." has been found";

          $q=$db->prepare("SELECT * FROM users
               WHERE name= :identifiant
               AND nom2= :nom2");

          $q->execute([
               'identifiant'=> $firstname,
               'nom2'=> $lastname
          ]);

          $result = $q->fetch(PDO::FETCH_OBJ);
          $user_id = $result->id;

        //  if(already_friends(get_session('user_id'), $data->id)){
                $q=$db->prepare('SELECT * FROM users WHERE id=?');
                $q->execute([$user_id]);
                $data=$q->fetch(PDO::FETCH_OBJ);
                $q->closeCursor();

                $response['error'] = false;
                $response['id'] = $data->id;
          //La condition en haut a ete commente suite a un probleme avec l'envoie de l'id de la personne connectee


        }

     }

     if(!$found){

     $response['error'] = true;
     $response['message'] = $_POST['username']." has not been found";

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
