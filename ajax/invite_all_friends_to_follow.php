<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
require '../includes/event_functions.php';
extract($_POST);

if (get_session('user_id'))
 {
    $q=$db->prepare("SELECT * FROM friends_relationships
						 WHERE (user_id1 = :user_connected OR user_id2 = :user_connected)
						 AND status ='1'");
    $q->execute([
        'user_connected'=> get_session('user_id')
    ]);

    $friends = $q->fetchAll(PDO::FETCH_OBJ);
	$q->closecursor();

    foreach($friends as $friend){
    
    if($friend->user_id1 == get_session('user_id')){

        if(!an_event_has_already_been_followed(get_session('ev_i'),$friend->user_id2))
        {

    $q = $db->prepare('INSERT INTO notifications(event_id,subject_id ,user_id,type,created_at)
    VALUES(:event_id,:subject_id ,:user_id,:type, NOW())');
        $q->execute([
        'event_id' =>get_session('ev_i'),
        'user_id' =>get_session('user_id'),
        'subject_id'=>$friend->user_id2,
        'type' => "Invite you to join this event"             
        ]);

        }

    }elseif($friend->user_id2 == get_session('user_id')){

        if(!an_event_has_already_been_followed(get_session('ev_i'), $friend->user_id1))
        {

    $q = $db->prepare('INSERT INTO notifications(event_id,subject_id ,user_id,type,created_at)
    VALUES(:event_id,:subject_id ,:user_id,:type, NOW())');
        $q->execute([
        'event_id' =>get_session('ev_i'),
        'user_id' =>get_session('user_id'),
        'subject_id'=>$friend->user_id1,
        'type' => "Invite you to join this event"             
        ]);   

        }
    }

    }

}else{
    redirect('login.php');
}