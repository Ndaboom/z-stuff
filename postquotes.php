<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");


if(isset($_POST['publish'])){
    extract($_POST);
	if(not_empty(['content','author'])){

	    $q =$db->prepare('INSERT INTO microposts(user_id,legend,type,quote_author)
	                  VALUES (:user_id,:legend,:type,:quote_author)');
	    $q->execute([
           'user_id'=> $_SESSION['user_id'],
           'legend'=>$content,
           'type'=>"quotes",
           'quote_author'=>$author
	    ]);
	    $q->closecursor();
   
}
}
    if(!$_GET['device']){
    redirect('fil.php?id='.get_session('user_id'));
    }elseif($_GET['device']=="android")
    {
    redirect('android/fil.php?id='.get_session('user_id'));    
    }