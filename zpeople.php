<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("includes/init.php");
require("bootsrap/locale.php");

require("includes/constants.php");
if(!empty($_GET['id'])){
    $user=find_user_by_id($_GET['id']);
    $user2=selectUserProfilePic($_GET['id']);


    

    if(!$user){
    	redirect('index.php');
    }
}else{
	redirect('zpeople.php?id='.get_session('user_id'));
}

$currentUser=get_session('user_id');
$q = $db->prepare("SELECT * FROM users 
	             WHERE active='1' AND id != :user_id 
	             ORDER BY RAND()
                 LIMIT 100");
     $q->execute([
         'user_id'=>get_session('user_id')
       ]);
$users = $q->fetchAll(PDO::FETCH_OBJ);

$q = $db->prepare("SELECT * 
                   FROM forums
                   WHERE creator_id !=:user_id
                   LIMIT 2");
$q->execute([
    'user_id'=>get_session('user_id')
]);
$forums = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$q = $db->prepare("SELECT *
                   FROM places
                   WHERE creator_id != :user_id
                   LIMIT 3");
$q->execute([
     'user_id'=>get_session('user_id')
 ]);
$places = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();
require("views/zpeople.view.php");  