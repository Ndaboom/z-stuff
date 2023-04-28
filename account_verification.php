<?php
session_start();
require("includes/init.php");
include('filters/guest_filter.php');
require('config/database.php');
require('includes/functions.php');

$_SESSION['isActivated'] = false;
$_SESSION['current_id'] = $_GET['user_id'];
$_SESSION['current_email'] = $_GET['email'];
$_SESSION['current_nom2'] = $_GET['nom2'];

if(isset($_POST['validate'])){
    extract($_POST);
    
    $q=$db->prepare("SELECT account_activation_code FROM users 
                     WHERE id= :id");
        $q->execute([
            'id'=>$_GET['user_id']
        ]);
        
    $data=$q->fetch(PDO::FETCH_OBJ);
    
    if($data->account_activation_code == $_POST['activation_code']){

        $q=$db->prepare("UPDATE users
                  SET email_verified= :email_verified, active= :active
                  WHERE id= :id");
        $q->execute([
            'email_verified'=> 1,
            'active'=>1,
            'id'=>$_GET['user_id']
        ]);
        
         $_SESSION['isActivated'] = 'true';
         $_SESSION['user_id'] = $_GET['user_id'];
	     $_SESSION['nom2'] = $_GET['nom2'];
	     $_SESSION['email'] = $_GET['email'];
	     
         setcookie('nom2', $_GET['nom2'],time()+60*60*24*30,null,null,false,true);
         setcookie('user_id',$_GET['user_id'] ,time()+60*60*24*30,null,null,false,true);
         
        if($_GET['device'] == "mobile"){
        redirect('mobile/profile.php?id='.$_GET['user_id']);
        }else{
        redirect('explorer.php?id='.$_GET['user_id']);
        }
        
    }else{
        set_flash("code de validation invalide ",'success');
    }
    
}
	
require("views/account_verification.view.php");