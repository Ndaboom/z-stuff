<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
require '../includes/event_functions.php';
extract($_POST);

if (get_session('user_id'))
 {

    $q = $db->prepare('INSERT INTO notifications(event_id,subject_id ,user_id,type,created_at)
    VALUES(:event_id,:subject_id ,:user_id,:type, NOW())');
        $q->execute([
        'event_id' =>get_session('ev_i'),
        'user_id' =>get_session('user_id'),
        'subject_id'=>$_POST['user_id'],
        'type' => "Invite you to join this event"             
        ]);

}else{
    redirect('login.php');
}