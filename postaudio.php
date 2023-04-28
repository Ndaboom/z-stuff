<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");

if (isset($_POST['publish'])) {
	//set_flash('Statut added successfully');
	   extract($_POST);
	   $dir='sounds/';
	   $audio_path = $dir.basename($_FILES['audio']['name']);
	   if(move_uploaded_file($_FILES['audio']['tmp_name'],$audio_path))
	   {
	     $q =$db->prepare('INSERT INTO microposts(user_id,legend,type,urlMedia)
	                  VALUES (:user_id,:legend,:type,:urlMedia)');
	    $q->execute([
           'user_id'=> $_SESSION['user_id'],
           'legend'=>$content,
           'urlMedia'=>$audio_path,
           'type'=>"sound"
	    ]); 
	   }
	   
       if($_GET['device']=="mobile"){
        redirect('mobile/fil.php?id='.get_session('user_id'));    
        }elseif($_GET['device']=="android")
        {
        redirect('android/fil.php?id='.get_session('user_id'));    
        }else{
		redirect('fil.php?id='.get_session('user_id'));	
        }
}
if($_GET['device']=="mobile"){
        redirect('mobile/fil.php?id='.get_session('user_id'));    
        }elseif($_GET['device']=="android")
        {
        redirect('android/fil.php?id='.get_session('user_id'));    
        }else{
		redirect('fil.php?id='.get_session('user_id'));	
 }
