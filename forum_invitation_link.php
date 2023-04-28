<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
if (get_session('user_id')) {
   
	$q =$db-> prepare(
		               'INSERT INTO forum_members(user_id,forum_id,etat)
		               VALUES(:user_id,:forum_id,:etat)');

	$q->execute([
		'user_id'=>get_session('user_id'),
		'forum_id'=>$_GET['id'],
		'etat'=>1
	]);
	
	redirect('homeforum.php?name='.$_GET['name']);	
}