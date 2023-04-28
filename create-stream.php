<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user2 = find_user_by_id($_SESSION['user_id']);


if(isset($_POST['insert-stream'])){
extract($_POST);

if(not_empty(['channel_name','channel_description', 'channel_key'])){
   
    $q=$db->prepare('INSERT INTO channels_tb(channel_name,channel_key,channel_description,channel_owner)
    VALUES(:channel_name,:channel_key,:channel_description,:channel_owner)');
    $q->execute([
    'channel_name'=> $channel_name,
    'channel_key'=>$channel_key,
    'channel_description' =>$channel_description,
    'channel_owner'=>$_SESSION['user_id']
    ]); 
  
    $last_id = $db->lastInsertId();
  
  redirect('stream_config.php?cn='.$last_id);
}else{
  $errors[] ="Please fill in all the fields";
}

}

require("views/v2/create-stream.view.php"); 
?>
