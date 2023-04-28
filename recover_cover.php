<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
if ($_SESSION['user_id']) {
	
		$q= $db->prepare('UPDATE users
	 	            SET coverpic = :coverpic  
	 	            WHERE id = :id');
         $q->execute([
         	'coverpic'=>'images/cover.jpeg',
            'id'=>get_session('user_id')
			]);
	   
	   if($_GET['lang'] == 'fr'){
	       
       if($_GET['device'] == "mobile"){
        redirect('mobile/profile.php?id='.get_session('user_id'));    
       }elseif($_GET['device']=="android")
       {
        redirect('android/fr/profile.php?id='.get_session('user_id'));    
       }else{
		redirect('profile.php?id='.get_session('user_id'));	
       }
       
	   }else{
	       
	   if($_GET['device']=="mobile"){
        redirect('mobile/profile.php?id='.get_session('user_id'));    
       }elseif($_GET['device']=="android")
       {
        redirect('android/profile.php?id='.get_session('user_id'));    
       }else{
		redirect('profile.php?id='.get_session('user_id'));	
       } 
       
	   }
		
	}else{
    
		if($_GET['device']=="mobile"){
        redirect('mobile/profile.php?id='.get_session('user_id'));    
        }elseif($_GET['device']=="android")
        {
        redirect('android/profile.php?id='.get_session('user_id'));    
        }else{
		redirect('profile.php?id='.get_session('user_id'));	
        }
    }