<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");


if(isset($_POST['publish'])){

	if(!empty($_POST['content'])){
		extract($_POST);
	$q =$db->prepare('INSERT INTO placeposts(legend,place_id,user_id,created_at,place_name)
	                  VALUES (:content,:place_id,:user_id,:place_name,NOW())');
	    $q->execute([
           'content'=>$content,
           'place_id'=>$_SESSION['pl_i'],
           'user_id'=> $_SESSION['cr_i'],
           'place_name'=>get_session('pl_n')
	    ]);
	//set_flash('Statut added successfully');
	}
	
}

if (isset($_POST['publish2'])) {

   if(!empty($_POST['content'])){
		extract($_POST);
	//set_flash('Statut added successfully');
	if (!empty($_FILES)) {
		$file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

	    $file_name = rand() . '.' . $file_extension;

		//$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
		$q =$db->prepare('INSERT INTO placeposts(legend,place_id,user_id,type,urlMedia,place_name,created_at)
	                  VALUES (:content,:place_id,:user_id,:type,:urlMedia,:place_name,NOW())');
	    $q->execute([
           'content'=>$content,
           'place_id'=>$_SESSION['pl_i'],
           'user_id'=> $_SESSION['cr_i'],
           'type'=>$type,
           'urlMedia'=>$file_dest,
           'place_name'=>get_session('pl_n')

	    ]);
	    $q->closecursor();

		//Recuperation de tout les followers de la place en cours
	$q =$db->prepare('SELECT user_id FROM places_followers
                      WHERE place_id= :place_id AND user_id != :user_id
                      AND status= :status
                    ');
	$q->execute([
                   'place_id'=>get_session('pl_i'),
                   'user_id'=>get_session('user_id'),
                   'status' =>1
	           ]);
                $users= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor(); 
	//Signalement a tout les followers du nouveau post
	foreach($users as $row)
	{
      $q=$db->prepare('INSERT INTO new_place_post(user_id,place_id,seen)
	                 VALUES(:user_id,:place_id,:seen)');
	  $q->execute([
	  'user_id'=>$row->user_id,
	  'place_id'=>get_session('pl_i'),
	  'seen'=>0
	             ]);
    
	}
		

		
	}
	else{
			echo "Upload failed";
		}
	}else{
		echo "No file detected";
	}
}
}
    if($_GET['device']=="mobile"){
    redirect('mobile/homeplace.php?pl_i='.get_session('pl_i').'#all_post');
    }elseif($_GET['device']=="android"){
	if(isset($_GET['lang']) && $_GET['lang'] == 'fr'){
	redirect('android/fr/homeplace.php?pl_i='.get_session('pl_i').'#all_post');
	}else{
	   redirect('android/homeplace.php?pl_i='.get_session('pl_i').'#all_post');
	}
     
    }else{
     redirect('homeplace.php?pl_i='.get_session('pl_i').'#all_post');    
    }