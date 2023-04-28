<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user2 = find_user_by_id($_SESSION['user_id']);


if(isset($_POST['insert-place'])){
extract($_POST);

if(not_empty(['place_name','description', 'category'])){
   
    $q=$db->prepare('INSERT INTO places(place_name,description,category,creator_id)
    VALUES(:place_name,:description,:category,:creator_id)');
    $q->execute([
    'place_name'=> $place_name,
    'description'=>$description,
    'category'   =>$category,
    'creator_id' =>$_SESSION['user_id']
    ]); 
  
  $last_id = $db->lastInsertId();
  
  redirect('place_home.php?n='.$place_name.'&pl_i='.$last_id);
}else{
  echo "please fill in all the fields";
}

}

require("views/v2/create-place.view.php"); 
?>
