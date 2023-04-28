<?php
session_start();
require '../../../../config/database.php';
require '../../../../includes/functions.php';
extract($_POST);

//Check if there is another call in progress
if(!video_call_in_progress($_SESSION['user_id'], $_POST['to_user_id'])){
    $status = "requesting";

    $q=$db->prepare('INSERT INTO video_calls(from_user_id, to_user_id, status)
        VALUES(:from_user_id,:to_user_id,:status)');
    $q->execute([
        'from_user_id'=> get_session('user_id'),
        'to_user_id'=> $to_user_id,
        'status'=> $status
    ]);

    $q->closecursor();
    echo "requesting";
}else{
    echo "there's another call in progress";
}