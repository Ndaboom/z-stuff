<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if($action == "follow"){
 
   $q =$db-> prepare(
		               'INSERT INTO event_followers(event_id,user_id,status)
		               VALUES(:event_id,:user_id,:status)');

	$q->execute([
		'event_id'=> $event_id,
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
		'event_name'=>$event_name,
		'event_id'=>$event_id,
		'seen'=>0
	]);

	 $q = $db->prepare('INSERT INTO notifications(event_id,subject_id ,user_id,type,created_at)
                         VALUES(:event_id,:subject_id ,:user_id,:type, NOW())');
                $q->execute([
                'event_id' =>$event_id,
                'user_id' =>get_session('user_id'),
                'subject_id'=>$cr_i,
                'type' => "A commence a suivre votre activite"             
]);
	           
}elseif($action == "unfollow"){

    $q=$db->prepare('DELETE FROM event_followers
                     WHERE user_id= :user_id AND event_id= :event_id');
	$q->execute([
	             'user_id'=> get_session('user_id'),
                 'event_id'=> $event_id
	           ]);

}	           
