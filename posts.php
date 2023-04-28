<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user_id = $_SESSION['user_id'];
$article_id = $_GET['a_i'];

if(!empty($user_id)){

    $user = find_user_by_id($user_id);
    $user2 = find_user_by_id($user_id);
    $current_user = find_user_by_id($_GET['id']);
    
    $q = $db->prepare('SELECT * FROM microposts
                       WHERE user_id = :user_id');
    $q->execute(['user_id'=>$_GET['id']]);
    $posts = $q->rowCount();
  
}else{

redirect('index.php');

}

require("views/v2/posts.view.php");
