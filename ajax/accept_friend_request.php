<?php 
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
if(get_session('user_id')){
    extract($_POST);
    $q =$db-> prepare("UPDATE friends_relationships
		               SET status ='1'  
		               WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
			   	       OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");

	$q->execute([
		'user_id1'=>get_session('user_id'),
		'user_id2'=>$user_id
	]);

	// Sauvegarde de la notification
    $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)
                       VALUES(:subject_id, :name, :user_id)');
						
						$q->execute([
							'subject_id' => $user_id,
							'name' => 'friend_request_accepted',
							'user_id' => get_session('user_id')
                        ]);
}