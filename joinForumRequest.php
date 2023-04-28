<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');

if (get_session('user_id')) {
	if(!is_already_in_forum(get_session('user_id'),$_GET['fr_i']))
	{
	$id=$_GET['id'];
	$q =$db-> prepare(
		               'INSERT INTO forum_members(user_id,forum_id,etat)
		               VALUES(:user_id,:forum_id,:etat)');

	$q->execute([
		'user_id'=>get_session('user_id'),
		'forum_id'=>$_GET['fr_i'],
		'etat'=>0
	]);
	// Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO forum_notifications(poster_id, type, forum_id,seen,posted_at)
                         VALUES(:poster_id, :type, :forum_id, :seen,NOW())');
                $q->execute([
                'poster_id' =>get_session('user_id'),
                'type' => 'demande de rejoindre',
                'forum_id' => $_GET['fr_i'],
                'seen'=>0
                ]);

	redirect('list_forums.php?id='.$id);
	}else{
	    echo "You are already in this forum";
	}
}else{
	redirect('profile.php?id='.get_session('user_id'));
}
