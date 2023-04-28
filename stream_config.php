<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");

$user2 = find_user_by_id($_SESSION['user_id']);

if(isset($_POST['insert-config'])){
extract($_POST);

//Traitement de l'image
if (!empty($_FILES)) {
    $file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

    $file_name = rand() . '_ZUNGVI.' . $file_extension;

    //$file_extension=strrchr($file_name, ".");
    $file_tmp_name=$_FILES['image']['tmp_name'];
    $file_dest='images/'.$file_name;

if (move_uploaded_file($file_tmp_name,$file_dest)) {
    $source_image = $file_dest;
    $image_destination = 'images/'.uniqid(time()).'.'.$file_extension;
    $compress_image = compress($source_image,$image_destination);

    $q=$db->prepare('UPDATE channels_tb SET channel_image= :channel_image
    WHERE id= :id');
    $q->execute([
    'channel_image'=> $image_destination,
    'id'=>$_GET['cn']
    ]); 
  
    $q->closeCursor();
    
    //redirect to the stream added, shoud pass the key in $_GET
    redirect('channel.php?cn='.$_GET['cn']);

    }
 }
 //Fin traitement
   
}

require("views/v2/stream-config.view.php"); 
?>
