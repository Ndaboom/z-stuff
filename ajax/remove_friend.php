<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';

if(get_session('user_id')){
    extract($_POST);

    $q =$db-> prepare(
        'DELETE  FROM friends_relationships
        WHERE user_id1 = :user_id1 AND user_id2 = :user_id2
        OR (user_id1 = :user_id2 AND user_id2 = :user_id1)');

    $q->execute([
    'user_id1'=>get_session('user_id'),
    'user_id2'=>$user_id
    ]);

}