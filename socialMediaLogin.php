<?php
session_start();
require("includes/functions.php");
require("config/database.php");
include('partials/header.php');

$user = find_user_by_email($_GET['email']);

if($user){

		$_SESSION['user_id'] = $user->id;
		$_SESSION['nom2']=$user->nom2;
		$_SESSION['email']=$user->email;
		redirect("feed.php?id=".$user->id);
	
}else{ 
    $email = $_GET['firstname'].''.$_GET['lastname'].'@gmail.com'; 
	$email = strtolower($email);
	$email = preg_replace('/\s+/', '', $email);

	$user = find_user_by_email($email);

	if($user && $user->email != "undefined"){
		$_SESSION['user_id'] = $user->id;
		$_SESSION['nom2']=$user->nom2;
		$_SESSION['email']=$user->email;
		redirect("feed.php?id=".$user->id);
	}

    $q=$db->prepare('INSERT INTO users(name,nom2,email,profilepic,coverpic,active)
	                 VALUES(:name,:nom2,:email,:profilepic,:coverpic,:active)');
	$q->execute([
	'name'=> $_GET['firstname'],
	'nom2'=>$_GET['lastname'],
	'email'=>$email,
	'profilepic'=>"images/default.png",
	'coverpic'=>"images/cover.jpeg",
	'active'=>1
	]);

	$last_id = $db->lastInsertId();
	$_SESSION['user_id']=$last_id;
	$_SESSION['nom2']=$_GET['lastname'];
	$_SESSION['email']=$email;

  setcookie('nom2', $_GET['lastname'],time()+60*60*24*30,null,null,false,true);
  setcookie('user_id',$last_id ,time()+60*60*24*30,null,null,false,true);

  redirect('explorer.php?id='.$last_id);
}

?>
<div class="alert alert-red">
    L'authentification avec facebook a echoue...
</div>
