<?php
    session_start();
    require '../config/database.php';
    require '../includes/functions.php';
    extract($_POST);

    $q = $db->prepare('DELETE FROM notifications
    WHERE id= :id');
    $q->execute([
    'id' =>$_POST['notification_id']            
    ]);


    $q->closeCursor();