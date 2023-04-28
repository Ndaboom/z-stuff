<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user = find_user_by_id($_SESSION['user_id']);
$user2 = find_user_by_id($_SESSION['user_id']);

if($_GET['p'] == "" && $_GET['category'] == ""){
    $articles = fetch_all_articles(5,0);
}else if($_GET['category']){
    $articles = fetch_articles_by_category($_GET['category']);
}else{
    $articles = fetch_all_articles(5,0);
}

require("views/v2/articles.view.php");
