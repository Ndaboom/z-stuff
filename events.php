<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user2 = find_user_by_id($_SESSION['user_id']);

$q = $db->prepare("SELECT * FROM events");
$q->execute();
$all_events = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$q = $db->query("SELECT * FROM places ORDER BY created_at DESC");
$places = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();


require("views/v2/events.view.php"); 
?>
