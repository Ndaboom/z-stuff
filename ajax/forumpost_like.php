<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);
if($action == 'like'){
    $q=$db->prepare('INSERT INTO forumpost_like(user_id, forumpost_id)
		             VALUES(:user_id, :forumpost_id)');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'forumpost_id'=> $id
	           ]);

	$q=$db->prepare('UPDATE forum_subject 
		             SET like_count= like_count+1 
		             WHERE id= :forumpost_id');
	   $q->execute([
           'forumpost_id'=>$id
	   ]);	
}else{
	$q=$db->prepare('DELETE FROM forumpost_like
        	             WHERE user_id= :user_id AND forumpost_id= :forumpost_id');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'forumpost_id'=>$id
	           ]);

	$q=$db->prepare('UPDATE forum_subject
		             SET like_count= like_count-1 
		             WHERE id= :forumpost_id');
	   $q->execute([
           'forumpost_id'=>$id
	   ]);
}