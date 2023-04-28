<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
$data = array(
	':to_user_id'       => $_POST['to_user_id'],
	':from_user_id'     => get_session('user_id'),
	':chat_message'     => $_POST['chat_message'],
	':conversation_id'	=> $_POST['c_i'],
	':status'           => '1'
);

if (!conversation_started(get_session('user_id'), $_POST['to_user_id'])) {

	$query = "
				INSERT INTO conversations_tb
				(user_id1,user_id2)
				VALUES (:user_id1,:user_id2)
						";
	$statement = $db->prepare($query);
	$statement->execute([
		'user_id1' => get_session('user_id'),
		'user_id2' => $_POST['to_user_id']
	]);
}

$date1 = date("Y-m-d H:i:s");
$q = $db->prepare("UPDATE users
		           SET last_msg= :last_msg
		           WHERE id= :id
		              ");

$q->execute([
	'last_msg' => $date1,
	'id' => $_POST['to_user_id']
]);
$q->closeCursor();
$q = $db->prepare("UPDATE users
		           SET last_msg= :last_msg
		           WHERE id= :id 
		              ");

$q->execute([
	'last_msg' => $date1,
	'id' => get_session('user_id')
]);



$query = "
INSERT INTO chat_message
(to_user_id,from_user_id,chat_message,conversation_id,status)
VALUES (:to_user_id,:from_user_id,:chat_message,:conversation_id,:status)
         ";
$statement = $db->prepare($query);

if ($statement->execute($data)) {
	echo fetch_user_chat_history(get_session('user_id'), $_POST['to_user_id'], $db);
}
