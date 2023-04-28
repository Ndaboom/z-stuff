<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if($action == "go"){
 
    $q=$db->prepare('INSERT INTO event_sessions(user_id, event_id, starting_date)
		             VALUES(:user_id, :event_id, :starting_date)');
	$q->execute([
	             'user_id'=> get_session('user_id'),
                 'event_id'=> $event_id,
                 'starting_date'=> $start_date
	           ]);
	           
}elseif($action == "nomore_going"){

    $q=$db->prepare('DELETE FROM event_sessions
                     WHERE user_id= :user_id AND event_id= :event_id AND starting_date= :starting_date');
	$q->execute([
	             'user_id'=> get_session('user_id'),
                 'event_id'=> $event_id,
                 'starting_date'=> $start_date
	           ]);

}	           
