<?php

session_start();

require("includes/init.php"); 

include('filters/auth_filter.php');

require("includes/functions.php");
require("bootsrap/locale.php");
require("config/database.php");





if(!empty($_GET['id'])){

    $user=find_user_by_id($_GET['id']);

    $user2=selectUserProfilePic($_GET['id']);

   $q=$db->prepare("SELECT F.status,U.id,U.name,U.nom2,U.profilepic

   	                       FROM users U,friends_relationships F

	                            WHERE (F.user_id1 = :user_connected OR F.user_id2 = :user_connected)

	                            AND status ='1'");

	           $q->execute([

                   'user_connected'=> get_session('user_id')

	           ]);

    	$friends = $q->fetchAll(PDO::FETCH_OBJ);

    	$q->closecursor();





    



    if(!$user){

    	redirect('index.php');

    }

}else{

	redirect('message.php?id='.get_session('user_id'));

}







require('views/message.view.php');

