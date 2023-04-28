<?php 
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if($_SESSION['user_id'] == $_POST['poster_id'])
{
    $q =$db-> prepare(
		               'DELETE  FROM games_comments
		               WHERE id = :comment_id');

	$q->execute([
		'comment_id'=>$_POST['comment_id']
	]);
}