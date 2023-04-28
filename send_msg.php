<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
 
if(isset($_POST['send'])){
    extract($_POST);
	if(not_empty(['content'])){

	    $q =$db->prepare('INSERT INTO chat_message(to_user_id,from_user_id,chat_message,status)
	                 VALUES (:to_user_id,:from_user_id,:chat_message,:status)');
	    $q->execute([
           'to_user_id'=> $_GET['id'],
           'from_user_id'=>get_session('user_id'),
           'chat_message'=>$content,
           'status'=>1
	    ]);
	    $q->closecursor();
   
}
}
    redirect('profile.php?id='.$_GET['id']);