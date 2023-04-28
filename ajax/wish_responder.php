<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
$data = array(
              ':to_user_id'       =>$_POST['from_user_id'],
              ':from_user_id'     =>get_session('user_id'),
              ':chat_message'     =>$_POST['chat_message'],
              ':status'           =>'1',
              ':color'            =>$_POST['color'],
              ':wish'             =>$_POST['wish']
             );
$date1 = date("Y-m-d H:i:s");
$q =$db-> prepare("UPDATE users
		           SET last_msg= :last_msg
		           WHERE id= :id
		              ");

	$q->execute([
		'last_msg'=>$date1,
		'id'=>$_POST['from_user_id']
	]);
	$q->closeCursor();
$q =$db-> prepare("UPDATE users
		           SET last_msg= :last_msg
		           WHERE id= :id 
		              ");

	$q->execute([
		'last_msg'=>$date1,
		'id'=>get_session('user_id')
	]);
$q->closeCursor();
$q =$db-> prepare("UPDATE home_msg
		           SET etat= :etat
		           WHERE id= :id 
		              ");

	$q->execute([
		'etat'=>1,
		'id'=>$_POST['wish_id']
	]);



$query = "
INSERT INTO chat_message
(to_user_id,from_user_id,chat_message,color,wish,status)
VALUES (:to_user_id,:from_user_id,:chat_message,:color,:wish, :status)
         ";
$statement=$db->prepare($query);
$statement->execute($data);

?>