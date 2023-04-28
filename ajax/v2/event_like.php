<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if($action == "like"){
    $q=$db->prepare('INSERT INTO event_posts_like(user_id, post_id, event_id)
		             VALUES(:user_id, :post_id, :event_id)');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'post_id'=> $postid,
                 'event_id'=> $event_id
	           ]);

	$q=$db->prepare('UPDATE eventposts
		             SET likes= likes+1 
		             WHERE id= :id');
	   $q->execute([
           'id'=> $postid
	   ]);	
}else{

    $q=$db->prepare('DELETE FROM event_posts_like
        	             WHERE user_id= :user_id AND post_id= :post_id');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'post_id'=> $postid
	           ]);

	$q=$db->prepare('UPDATE eventposts
		             SET likes= likes-1 
		             WHERE id= :id');
	   $q->execute([
           'id'=> $postid
	   ]);	

}
