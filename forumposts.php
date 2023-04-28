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
        
    if (!empty($_FILES)){
    	$file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

	    $file_name = rand() . '.' . $file_extension;

		//$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;
		if (move_uploaded_file($file_tmp_name,$file_dest)) {


	$q =$db->prepare('INSERT INTO forum_subject(subject,poster_id,forum_id,type,urlmedia1,created_at)
	                 VALUES (:subject,:poster_id,:forum_id,:type,:urlmedia1,NOW())');
	    $q->execute([
           'subject'=>$content,
           'poster_id'=>get_session('user_id'),
           'forum_id'=>get_session('fr_i'),
           'type'=>"subject",
           'urlmedia1'=>$file_dest
	    ]);
	    $q->closecursor();

    //Recuperation de tout les membres du forum en session
	$q =$db->prepare('SELECT user_id FROM forum_members
                      WHERE forum_id= :forum_id AND user_id != :user_id
                    ');
	$q->execute([
                   'forum_id'=>get_session('fr_i'),
                   'user_id'=>get_session('user_id')
	           ]);
                $users= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor(); 
	//Signalement a tout le membre du nouveau post
	foreach($users as $row)
	{
      $q=$db->prepare('INSERT INTO new_forum_post(user_id,forum_id,seen)
	                 VALUES(:user_id,:forum_id,:seen)');
	  $q->execute([
	'user_id'=>$row->user_id,
	'forum_id'=>get_session('fr_i'),
	'seen'=>0
	             ]);
    }
	    //set_flash('Statut added successfully');
	    if($_GET['device'] == "android"){
			if($_GET['lang']){
				redirect('android/fr/homeforum.php?name='.get_session('fr_n'));
			}else{
				redirect('android/homeforum.php?name='.get_session('fr_n'));
			}   
	    }
	    redirect('homeforum.php?name='.get_session('fr_n'));
	}else{
       
        $q =$db->prepare('INSERT INTO forum_subject(subject,poster_id,forum_id,type,created_at)
	                 VALUES (:subject,:poster_id,:forum_id,:type,NOW())');
	    $q->execute([
           'subject'=>$content,
           'poster_id'=> $_SESSION['user_id'],
           'forum_id'=>get_session('fr_i'),
           'type'=>"subject"

	    ]);
	    $q->closecursor();
	    //Recuperation de tout les membres du forum en session
	$q =$db->prepare('SELECT user_id FROM forum_members
                      WHERE forum_id = :forum_id AND user_id != :current_id
                    ');
	$q->execute([
                   'forum_id'=>get_session('fr_i'),
                   'current_id'=>get_session('user_id')
	           ]);
                $users= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor(); 
	//Signalement a tout le membre du nouveau post
	foreach($users as $row)
	{
      $q=$db->prepare('INSERT INTO new_forum_post(user_id,forum_id,seen)
	                 VALUES(:user_id,:forum_id,:seen)');
	  $q->execute([
	'user_id'=>$row->user_id,
	'forum_id'=>get_session('fr_i'),
	'seen'=>0
	             ]);
    }
	    if($_GET['device'] == "android"){
	     redirect('android/homeforum.php?name='.get_session('fr_n'));   
	    }
	    redirect('homeforum.php?name='.get_session('fr_n'));
}
}
}
}
    