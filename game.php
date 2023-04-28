<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("includes/event_functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user=find_user_by_id($_SESSION['user_id']);
$game = find_game_by_id($_GET['g_i']);
$user2 = find_user_by_id($_SESSION['user_id']);
$comments = fetch_game_comments($_GET['g_i']);


$title = $game->game_name;
$_SESSION['game_id'] = $_GET['g_i'];

$q = $db->prepare("SELECT * FROM games_tb
				   WHERE game_category= :game_category AND id != :id 
				   ORDER BY id DESC");
$q->execute([
	'game_category'=>$game->game_category,
	'id'=>$game->id
]);
$games = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$q=$db->prepare('UPDATE games_tb
				SET plays = plays+1 
				WHERE id= :g_id');
	$q->execute([
		'g_id'=>$_GET['g_i']
	]); 
	
$q->closecursor();

require("views/v2/game.view.php");
