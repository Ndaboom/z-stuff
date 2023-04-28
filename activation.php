<?php
session_start();
include('filters/guest_filter.php');
require "config/database.php";
require "includes/functions.php";

if (!empty($_GET['p']) && 
is_already_in_use('nom2', $_GET['p'],'users')
&& !empty ($_GET['token'])
){
	$nom2=$_GET['p'];
	$token=$_GET['token'];
	
	$q=$db->prepare('SELECT id,email,password FROM users WHERE nom2=?');
	$q->execute([$nom2]);
	$data=$q->fetch(PDO::FETCH_OBJ);
	
	
	$token_verif=sha1($nom2.$data->email.$data->password);
	
	if($token == $token_verif){
		$q=$db->prepare("UPDATE users SET active='1' WHERE nom2=?");
	$q->execute([$nom2]);

	$q=$db->prepare("INSERT INTO friends_relationships(user_id1,user_id2,status) VALUES (?,?,?)");
	$q->execute([$data->id,$data->id,'2']);

	set_flash('Compte activé avec success');
	redirect('login.php');
		
	}else{
		
		set_flash('Invalid parameters','danger');
		redirect('index.php');
		}
	
	}else{
		redirect('index.php');
		}