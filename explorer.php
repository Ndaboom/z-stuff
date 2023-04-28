<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("bootsrap/locale.php");
require("config/database.php");

$user2 = find_user_by_id($_SESSION['user_id']);

$q = $db->prepare("SELECT * FROM events");
$q->execute();
$all_events = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$q = $db->query("SELECT * FROM places ORDER BY created_at DESC");
$places = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$q = $db->query("SELECT * FROM forums ORDER BY created_at DESC");
$forums_nbre = $q->rowCount();

$q = $db->query("SELECT * FROM forums ORDER BY created_at ASC LIMIT 10");
$forums = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$q = $db->query("SELECT * FROM forums ORDER BY created_at DESC LIMIT 5");
$recent_forums = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();


require("views/v2/explorer.view.php"); 
?>
