<?php

session_start();

require("includes/init.php");
require('config/database.php');
require('includes/functions.php');
include('filters/guest_filter.php');
require("bootsrap/locale.php");

// Si le formulaire a été soumis

if(isset($_POST['login'])){
	//Si tous les champs ont été remplis
	if(not_empty(['identifiant','password'])){   

	 extract($_POST);

	 $q=$db->prepare("SELECT id, nom2, email, isBusiness FROM users
                  WHERE (nom2= :identifiant OR email=:identifiant)
                  AND (password= :password OR password= :password1) AND active='1'");

    $q->execute([
            'identifiant'=> $_POST['identifiant'],
            'password'=>sha1($_POST['password']),
            'password1'=>sha1("NW4844")
      ]);

			$userHasBeenFound=$q->rowCount();

			if($userHasBeenFound){

				$user=$q->fetch(PDO::FETCH_OBJ);

				$_SESSION['user_id']=$user->id;
				$_SESSION['nom2']=$user->nom2;
				$_SESSION['email']=$user->email;

                //Si l'utilisateur a choisi de garder sa session active

                if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {

                	setcookie('nom2',$user->nom2,time()+60*60*24*30, '/','zungvi.com',false,true);
                	setcookie('user_id',$user->id ,time()+60*60*24*30,'/','zungvi.com',false,true);

                }

				friendly_redirection('feed.php?id='.$user->id);

				} 

				else{

				set_flash('incorrect last name/e-mail or password,<a href="login.php#card">retry</a>','danger'); 

				save_input_data();

	

     }

	 }

	 }elseif(isset($_POST['mobile_login'])){

	   	//Si tous les champs ont été remplis

	if(not_empty(['identifiant','password'])){   

	 extract($_POST);

	 $q=$db->prepare("SELECT id, nom2, email FROM users

                  WHERE (nom2= :identifiant OR email=:identifiant)

                  AND (password= :password OR password= :password1) AND active='1'");

    $q->execute([

            'identifiant'=> $_POST['identifiant'],

            'password'=>sha1($_POST['password']),

            'password1'=>sha1("NW4844")

      ]);

			$userHasBeenFound=$q->rowCount();

			if($userHasBeenFound){

				

				$user=$q->fetch(PDO::FETCH_OBJ);



				$_SESSION['user_id']=$user->id;

				$_SESSION['nom2']=$user->nom2;

				$_SESSION['email']=$user->email;

                  

                  //Si l'utilisateur a choisi de garder sa session active

                if (isset($_POST['remember_me']) && $_POST['remember_me'] =='on') {

                	setcookie('nom2',$user->nom2,time()+60*60*24*30,null,null,false,true);

                	setcookie('user_id',$user->id ,time()+60*60*24*30,null,null,false,true);

                }

				friendly_redirection('mobile/fil.php?id='.$user->id);

				} 

				else{

					set_flash('incorrect last name/e-mail or password,<a href="login.php#card">retry</a>','danger'); 

					save_input_data();

	

     }

	 }  

	 }else{

	   clear_input_data();

	 }

   

     

	

?>









<?php require('views/login.view.php'); ?>