<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

	$q=$db->prepare('INSERT INTO favorite_posts(post_id, user_id)
		             VALUES(:post_id, :user_id)');
	$q->execute([
                 'post_id'=> $post_id,
                 'user_id'=> get_session('user_id')
	           ]);
