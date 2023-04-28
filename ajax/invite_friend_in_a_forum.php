<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

    extract($_POST);

    $q = $db->prepare('INSERT INTO notifications(forum_id, subject_id, user_id, type, created_at)
    VALUES(:forum_id, :subject_id, :user_id, :type, NOW())');
    $q->execute([
    'forum_id' =>get_session('fr_i'),
    'subject_id'=>$_POST['user_id'],
    'user_id' =>get_session('user_id'),
    'type' => "join_forum_request"             
    ]);
