<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("includes/event_functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user=find_user_by_id($_SESSION['user_id']);
$tv = find_channel_by_id($_GET['cn']);
$user2 = find_user_by_id($_SESSION['user_id']);

$title = $tv->channel_name;

$q = $db->prepare("SELECT * FROM channels_tb WHERE id!= :id");
$q->execute(['id'=>$_GET['cn']]);
$tvs = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$q=$db->prepare('UPDATE channels_tb
		         SET views = views+1 
		         WHERE id= :c_id');
	   $q->execute([
           'c_id'=>$_GET['cn']
	   ]); 
	   
 $q->closecursor();


require("views/v2/channel.view.php");
