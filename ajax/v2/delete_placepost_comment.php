<?php 
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if($_SESSION['user_id'] == $_POST['poster_id'])
{
    $q =$db-> prepare(
		               'DELETE  FROM place_comments
		               WHERE id = :id');
	$q->execute([
		'id'=>$_POST['commentid']
	]);
}