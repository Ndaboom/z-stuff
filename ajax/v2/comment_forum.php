<?php 
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);
$user_id = $_SESSION['user_id'];

        $q =$db->prepare('INSERT INTO forum_reactions(user_id,content_text,forum_id,subject_id,created_at)
	                  VALUES (:user_id,:content_text,:forum_id,:subject_id,NOW())');
	    $q->execute([
           'user_id'=>get_session('user_id'),
           'content_text'=>$content,
           'subject_id'=>$reactionId,
           'forum_id'=>get_session('fr_i')
	    ]);

	    $q->closecursor();

	   $q=$db->prepare('UPDATE forum_subject 
		             SET reaction= reaction+1 
		             WHERE id= :subject_id');
	   $q->execute([
           'subject_id'=>$reactionId
	   ]);
	   
echo display_reactions($reactionId);