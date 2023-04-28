<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user2 = find_user_by_id($_SESSION['user_id']);

if(isset($_GET['g_i'])){
    $q = $db->prepare("SELECT * FROM games_tb 
                       WHERE game_category= :game_category
                       ORDER BY created_at DESC");
    $q->execute(['game_category'=>$_GET['g_i']]);
    $all_games = $q->fetchAll(PDO::FETCH_OBJ);
    $q->closecursor();
}else{
    $q = $db->prepare("SELECT * FROM games_tb ORDER BY created_at DESC");
    $q->execute();
    $all_games = $q->fetchAll(PDO::FETCH_OBJ);
    $q->closecursor();
}

$q = $db->prepare("SELECT * FROM games_tb ORDER BY plays DESC LIMIT 6");
$q->execute();
$top_games = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$q = $db->prepare("SELECT * FROM games_categories");
$q->execute();
$categories = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

require("views/v2/games.view.php"); 
?>
