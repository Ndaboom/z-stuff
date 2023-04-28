<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("includes/event_functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user=find_user_by_id($_SESSION['user_id']);
$event = find_event_by_id($_GET['ev_i']);
$candidates=get_candidates($_GET['ev_i']);

    $status=1;
    $query= "
            SELECT * FROM poll_tb
            WHERE event_id= '".$_GET['ev_i']."'
            AND status= '".$status."'
            ORDER BY points DESC
    ";
    $statement= $db->prepare($query);
    $statement->execute();
    $current_session = $statement->fetch(PDO::FETCH_OBJ);
    $all_sessions = $statement->fetchAll(PDO::FETCH_OBJ);
    $points = 0;
    foreach($all_sessions as $session){
        $points = $points + $session->points; 
    }
    
    $query= "
            SELECT * FROM poll_tb
            WHERE event_id= '".$_GET['ev_i']."'
            AND status= '".$status."'
            ORDER BY points DESC
    ";
    $statement= $db->prepare($query);
    $statement->execute();
    $all_candidates = $statement->fetchAll(PDO::FETCH_OBJ);

require("views/event_dashboard.view.php");