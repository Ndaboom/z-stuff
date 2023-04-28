<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if (get_session('user_id')){
	
	$q =$db-> prepare(
		               'INSERT INTO event_followers(event_id,user_id,status)
		               VALUES(:event_id,:user_id,:status)');

	$q->execute([
		'event_id'=>$event_id,
		'user_id'=>get_session('user_id'),
		'status'=>1
		
	]);
	$q->closecursor();

	$q=$db->prepare("INSERT INTO event_notifications(poster_id,content,event_name,event_id,seen,posted_at)
                     VALUES(:poster_id,:content,:event_name,:event_id,:seen,NOW())
		            ");
	$q->execute([
		'poster_id'=>get_session('user_id'),
		'content'=>"you have 1 new follower",
		'event_name'=>get_session('ev_n'),
		'event_id'=>$event_id,
		'seen'=>0
	]);

	 $q = $db->prepare('INSERT INTO notifications(event_id,subject_id ,user_id,type,created_at)
                         VALUES(:event_id,:subject_id ,:user_id,:type, NOW())');
                $q->execute([
                'event_id' =>$event_id,
                'user_id' =>get_session('user_id'),
                'subject_id'=>get_session('cr_i'),
                'type' => "A commence a suivre votre activite"             
                ]);
	
}
