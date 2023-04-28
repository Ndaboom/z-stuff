<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);

if($_SESSION['user_id']){
 
	$q = $db->prepare("UPDATE notifications SET seen = '1' WHERE subject_id = ?");
    $q->execute([$_SESSION['user_id']]);
    $q->closecursor();
}