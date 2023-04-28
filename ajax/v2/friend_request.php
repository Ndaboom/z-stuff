<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if (!if_a_friend_request_has_already_been_sent(get_session('user_id'), $user_id)) {
	
	$q =$db->prepare('INSERT INTO friends_relationships(user_id1,user_id2,status)
		               VALUES(:user_id1,:user_id2,:status)');

	$q->execute([
		'user_id1'=>get_session('user_id'),
		'user_id2'=>$user_id,
		'status'=>2
	]);
	// Sauvegarde de la notification
    $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)
                       VALUES(:subject_id, :name, :user_id)');
    $q->execute([
    'subject_id' => $user_id,
    'name' => 'friend_request_sent',
    'user_id' => get_session('user_id'),
    ]);
	
}