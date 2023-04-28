<?php 
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

$owner = find_place_by_id($_POST['place_id']);

if($_SESSION['user_id'] == $owner->creator_id || $_SESSION['user_id'] == $_POST['user_id'])
{
    $q =$db-> prepare(
		               'DELETE  FROM placeposts
		               WHERE id = :id');
	$q->execute([
		'id'=>$_POST['post_id']
	]);

    echo "Post deleted successfully";
}else{
    echo "Something went wrong";
}