<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');



if (get_session('user_id')) {
    $id=$_GET['id'];
	$q =$db-> prepare(
		               'DELETE  FROM forum_members
		                WHERE user_id = :user_id AND forum_id= :forum_id');

	$q->execute([
		'user_id'=>get_session('user_id'),
		'forum_id'=>$_GET['fr_i']
	]);
	// Retrait de la notification
      $q = $db->prepare('DELETE FROM forum_notifications
      	                 WHERE poster_id = :poster_id AND forum_id= :forum_id');
                $q->execute([
                'poster_id'=>get_session('user_id'),
		        'forum_id'=>$_GET['fr_i']
]);
	redirect('list_forums.php?id='.$id);
}

