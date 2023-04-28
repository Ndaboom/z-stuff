<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$fileName = $_FILES["image"]["name"];
$file_extension=strrchr($fileName, ".");
$fileTmpLoc = $_FILES["image"]["tmp_name"];
$fileType = $_FILES["image"]["type"];
$fileSize = $_FILES["image"]["size"];
$fileErrorMsg = $_FILES["image"]["error"];

if (!$fileTmpLoc) {
   echo "No pictures detected...";
}

$fileName = uniqid(time()) + $file_extension;
$file_destination = "games/pictures/$fileName";
if (move_uploaded_file($fileTmpLoc, "../games/pictures/$fileName")) 
{
    
     $q =$db->prepare('INSERT INTO games_comments(user_id,username,legend,type,urlMedia,game_id)
    	                  VALUES (:user_id,:username,:legend,:type,:urlMedia,:game_id)');
    	    $q->execute([
               'user_id'=> $_SESSION['user_id'],
               'username'=>$_POST['comment_owner'],
               'legend'=>$_POST['comment_content'],
               'urlMedia'=>$file_destination,
               'type'=>"image",
               'game_id'=>$_SESSION['game_id']
    	    ]); 

	    echo "Complete";
}
else
{
	echo "something went wrong";
}