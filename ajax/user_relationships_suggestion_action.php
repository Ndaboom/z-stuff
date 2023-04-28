<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

    extract($_POST);

    if(get_session('user_id'))
    {

    	//Envoie de la demande d'amitie
    $q =$db-> prepare(
       'INSERT INTO friends_relationships(user_id1,user_id2,status)
       VALUES(:user_id1,:user_id2,:status)');

	$q->execute([
		'user_id1'=>get_session('user_id'),
		'user_id2'=>$_POST['relatives_id'],
		'status'=>2
	]);

	$q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)
                         VALUES(:subject_id, :name, :user_id)');
                $q->execute([
                'subject_id' => $_POST['relatives_id'],
                'name' => 'friend_request_sent',
                'user_id' => get_session('user_id')
                ]);
    
    $q = $db->prepare('DELETE FROM notifications 
      	                 WHERE id = :notification_id');

                $q->execute([
                'notification_id' => $_POST['notification_id']
                ]);

    }
	
