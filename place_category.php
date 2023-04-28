<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user2 = find_user_by_id($_SESSION['user_id']);
$top6Places = selectTop6Places();
if($_GET['page'] == "following"){
$page_title = "Places you're following";
$result = places_followed_by_the_current_user(get_session('user_id'));
}else{
$page_title = "All ".$_GET['keyword']." places";
$q = $db->prepare("SELECT * FROM places WHERE category like :category");
$q->execute(['category'=>'%'.$_GET['keyword'].'%']);
$result = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();
}


require("views/v2/place_category.view.php");
?>
