<?php
session_start();
require '../../../../config/database.php';
require '../../../../includes/functions.php';
extract($_POST);

if($_SESSION['user_id'] == $_POST['msg_owner'])
{
    $q =$db-> prepare(
		               'DELETE  FROM chat_message
		               WHERE id = :id');

	$q->execute([
		'id'=>$_POST['msg_id']
	]);
}