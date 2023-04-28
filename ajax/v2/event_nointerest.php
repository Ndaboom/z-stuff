<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);
if(get_session('user_id'))
 {
 	
	$q =$db-> prepare(
		               'DELETE  FROM event_followers
		               WHERE event_id = :event_id AND user_id = :user_id');

	$q->execute([
		'event_id'=>$event_id,
		'user_id'=>get_session('user_id')
	]);
	
 }
