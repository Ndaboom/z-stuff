<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
if (isset($_POST['publish'])) {
	extract($_POST);
	if (!empty($_FILES)) {
		$file_name =$_FILES['image']['name'];
		$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

		$extensions_autorisees= array('.jpg','.JPG','.jpeg','.png');

		if (in_array($file_extension, $extensions_autorisees)) {

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
		$q->closecursor();
				$q =$db->prepare('INSERT INTO forum_reactions(user_id,content_text,content_img,forum_id,subject_id,created_at)
	                  VALUES (:user_id,:content_text,:content_img,:forum_id,:subject_id,NOW())');
	    $q->execute([
           'user_id'=>get_session('user_id'),
           'content_text'=>$content,
           'content_img'=>$file_dest,
           'subject_id'=>$_GET['rid'],
           'forum_id'=>get_session('fr_i')
	    ]);

	    $q->closecursor();

	             $q=$db->prepare('UPDATE forum_subject 
		             SET reaction= reaction+1 
		             WHERE id= :subject_id');
	   $q->execute([
           'subject_id'=>$_GET['rid']
	   ]);


		redirect('morereaction.php?rid='.$_GET['rid']);	
		}else{
			echo "Aucun fichier detecte";
		}

		
	}else{
		$q->closecursor();
				$q =$db->prepare('INSERT INTO forum_reactions(user_id,content_text,forum_id,subject_id,created_at)
	                  VALUES (:user_id,:content_text,:forum_id,:subject_id,NOW())');
	    $q->execute([
           'user_id'=>get_session('user_id'),
           'content_text'=>$content,
           'subject_id'=>$_GET['rid'],
           'forum_id'=>get_session('fr_i')
	    ]);

	    $q->closecursor();

	             $q=$db->prepare('UPDATE forum_subject 
		             SET reaction= reaction+1 
		             WHERE id= :subject_id');
	   $q->execute([
           'subject_id'=>$_GET['rid']
	   ]);
       	redirect('morereaction.php?rid='.$_GET['rid']);
	}
	
}
}