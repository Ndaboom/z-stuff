<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
require '../includes/event_functions.php';
extract($_POST);

if (get_session('user_id') == get_session('cr_i'))
 {
    $q= $db->prepare('UPDATE events
    SET event_name = :event_name,
        event_description= :event_description
    WHERE id = :event_id');
        $q->execute([
        'event_name'=> $_POST['event_name'],
        'event_description'=>$_POST['event_description'],
        'event_id'   =>$_SESSION['ev_i']
        ]);

 }
 else
 {
     echo "You don't have privelegies to update this page informations";
 }