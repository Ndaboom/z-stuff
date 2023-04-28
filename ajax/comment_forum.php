<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);

$q=$db->prepare('INSERT INTO forum_comments(user_id, forum_id,subject_id,content_text,created_at)
		             VALUES(:user_id, :forum_id,:subject_id ,:content_text,NOW())');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'forum_id'=>get_session('fr_i'),
                 'subject_id'=> $reactionId,
                 'content_text'=>$message
	           ]);
	$q->closecursor();

echo display_comment(get_session('fr_i'),$reactionId,$user_id);