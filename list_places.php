<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");


if(!empty($_GET['id'])){
    $user=find_user_by_id($_GET['id']);
    $user2=selectUserProfilePic($_GET['id']);
    

    if(!$user){
    	redirect('index.php');
    }
}else{
	redirect('list_places.php?id='.get_session('user_id'));
}


$q = $db->query("SELECT id,place_name,description,category,coverpic,image,image1,image2 FROM places ORDER BY created_at DESC");
$places = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();





require("views/list_places.view.php");