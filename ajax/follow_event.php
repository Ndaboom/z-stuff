<?php
    session_start();
    require '../config/database.php';
    require '../includes/functions.php';
    extract($_POST);

	$q =$db->prepare("INSERT INTO event_followers(event_id,user_id,status)
		               VALUES(:event_id,:user_id,:status)");

	$q->execute([
		'event_id'=>$_POST['event_id'],
		'user_id'=>get_session('user_id'),
		'status'=>1
		
	]);
    

	$q=$db->prepare("INSERT INTO event_notifications(poster_id,content,event_name,event_id,seen,posted_at)
                     VALUES(:poster_id,:content,:event_name,:event_id,:seen,NOW())
		            ");
	$q->execute([
		'poster_id'=>get_session('user_id'),
		'content'=>"you have 1 new follower",
		'event_name'=>$_POST['event_name'],
		'event_id'=>$_POST['event_id'],
		'seen'=>0
	]);

	$q = $db->prepare('INSERT INTO notifications(event_id,subject_id ,user_id,type,created_at)
                         VALUES(:event_id,:subject_id ,:user_id,:type, NOW())');
    $q->execute([
    'event_id' =>$_POST['event_id'],
    'user_id' =>get_session('user_id'),
    'subject_id'=>$_POST['user_id'],
    'type' => "A commence a suivre votre activite"             
    ]);

    $q = $db->prepare('DELETE FROM notifications
                       WHERE id= :id');
    $q->execute([
    'id' =>$_POST['notification_id']            
    ]);


     $q->closeCursor();