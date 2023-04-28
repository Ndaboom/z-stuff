<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

if($_POST["action"] == "insert_data")
{
	$data = array(
		':forum_id'      => get_session('fr_i'),
		':from_user_id'  =>get_session('user_id'),
		':chat_message'  => $_POST['chat_message'],
		':status'        =>'1'
	);

	$query = "
    INSERT INTO chat_room
    (forum_id,from_user_id,chat_message, status)
    VALUES (:forum_id,:from_user_id,:chat_message, :status) 
	";

	$statement = $db->prepare($query);

	if($statement->execute($data))
	{
		echo fetch_group_chat_history($db,$forum_id);
	}
	
	//Recuperation de tout les membres du forum en session
	$q =$db->prepare('SELECT user_id FROM forum_members
                      WHERE forum_id= :forum_id AND user_id != :user_id
                    ');
	$q->execute([
                   'forum_id'=>get_session('fr_i'),
                   'user_id'=>get_session('user_id')
	           ]);
                $users= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor(); 
	//Signalement a tout le membre du nouveau post
	foreach($users as $row)
	{
      $q=$db->prepare('INSERT INTO unseen_forum(user_id,forum_id,seen)
	                 VALUES(:user_id,:forum_id,:seen)');
	  $q->execute([
	'user_id'=>$row->user_id,
	'forum_id'=>get_session('fr_i'),
	'seen'=>0
	             ]);
    }


}

if($_POST["action"] == "fetch_data")
{
	echo fetch_group_chat_history($db);
}
