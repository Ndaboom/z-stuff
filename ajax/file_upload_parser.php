<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$fileName = $_FILES["file1"]["name"];
$file_extension=strrchr($fileName, ".");
$fileTmpLoc = $_FILES["file1"]["tmp_name"];
$fileType = $_FILES["file1"]["type"];
$fileSize = $_FILES["file1"]["size"];
$fileErrorMsg = $_FILES["file1"]["error"];

if (!$fileTmpLoc) {
   echo "Error...please choose a file";
   exit();
}

$fileName = uniqid(time()) + $file_extension;
$file_destination = "videos/$fileName";
if (move_uploaded_file($fileTmpLoc, "../videos/$fileName")) 
{
    
     $q =$db->prepare('INSERT INTO microposts(user_id,legend,type,urlMedia)
    	                  VALUES (:user_id,:legend,:type,:urlMedia)');
    	    $q->execute([
               'user_id'=> $_SESSION['user_id'],
               'legend'=>$_POST['videoDescription'],
               'urlMedia'=>$file_destination,
               'type'=>"video"
    	    ]); 

	    echo "Complete";
}
else
{
	echo "move_uploaded_file function failed";
}