<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
$date1 = date("Y-m-d H:i:s");
$data = array(
              ':to_user_id'       =>$_POST['customer_id'],
              ':from_user_id'     =>get_session('user_id'),
              ':chat_message'     =>$_POST['chat_message'],
              ':status'           =>'1'
             );
$date1 = date("Y-m-d H:i:s");
$q =$db-> prepare("UPDATE users
		           SET last_msg= :last_msg
		           WHERE id= :id
		              ");

	$q->execute([
		'last_msg'=>$date1,
		'id'=>$_POST['customer_id']
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
$q =$db-> prepare("UPDATE place_orders
		           SET seen= :seen
		           WHERE id= :id 
		              ");

	$q->execute([
		'seen'=>1,
		'id'=>$_POST['order_id']
	]);

$query = "
INSERT INTO chat_message
(to_user_id,from_user_id,chat_message,status)
VALUES (:to_user_id,:from_user_id,:chat_message, :status)
         ";
$statement=$db->prepare($query);

if($statement->execute($data))
{
	echo "Success";
}
