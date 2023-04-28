<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');



if (!empty($_GET['id']) && $_GET['id'] !== get_session('user_id')) {
	if (!if_a_friend_request_has_already_been_sent(get_session('user_id'), $_GET['id'])) {
	
	$id=$_GET['id'];
	$q =$db-> prepare(
		               'INSERT INTO friends_relationships(user_id1,user_id2,status)
		               VALUES(:user_id1,:user_id2,:status)');

	$q->execute([
		'user_id1'=>get_session('user_id'),
		'user_id2'=>$id,
		'status'=>2
	]);
	// Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)
                         VALUES(:subject_id, :name, :user_id)');
                $q->execute([
                'subject_id' => $id,
                'name' => 'friend_request_sent',
                'user_id' => get_session('user_id'),
]);
	set_flash('Your request has been sent with success');
	redirect('profile.php?id='.$id);
}else{
	set_flash('Cet utilsateur vous a deja envoye une demande...');
	redirect('profile.php?id='.$_GET['id']);
}
}else{
	redirect('profile.php?id='.get_session('user_id'));
}