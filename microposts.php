<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");


if(isset($_POST['publish'])){

	if(!empty($_POST['content'])){
		extract($_POST);
        
    if (!empty($_FILES)){
	    $file_name =$_FILES['image']['name'];
		$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

		$extensions_autorisees= array('.jpg','.JPG','.jpeg','.png');
		
	if (in_array($file_extension, $extensions_autorisees)) {

	    if(move_uploaded_file($file_tmp_name,$file_dest)) {
           $source_image = $file_dest;
		   $image_destination = 'images/'.uniqid(time()).'.'.$file_extension;
		   $compress_image = compress($source_image,$image_destination);

	$q =$db->prepare('INSERT INTO microposts(legend,user_id,urlMedia,urlMedia1,created_at)
	                  VALUES (:content,:user_id,:urlMedia,:urlMedia1, NOW())');
	    $q->execute([
           'content'=>$content,
           'user_id'=> $_SESSION['user_id'],
           'urlMedia'=>$image_destination,
           'urlMedia1'=>$file_dest
	    ]);
	    $q->closecursor();
	    //set_flash('Statut added successfully');
	    }
   }else{
       
        $q =$db->prepare('INSERT INTO microposts(legend,user_id,created_at)
	                 VALUES (:content,:user_id,NOW())');
	    $q->execute([
           'content'=>$content,
           'user_id'=> $_SESSION['user_id']
	    ]);
	    $q->closecursor();
}
}
}elseif(!empty($_FILES))
{
   
   $file_name =$_FILES['image']['name'];
		$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

		$extensions_autorisees= array('.jpg','.JPG','.jpeg','.png');
		
	if (in_array($file_extension, $extensions_autorisees)) {

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
              $source_image = $file_dest;
	          $image_destination = 'images/'.uniqid(time()).'.'.$file_extension;
		      $compress_image = compress($source_image,$image_destination);

	$q =$db->prepare('INSERT INTO microposts(user_id,urlMedia,urlMedia1,created_at)
	                  VALUES (:user_id,:urlMedia,:urlMedia1, NOW())');
	    $q->execute([
           'user_id'=> $_SESSION['user_id'],
           'urlMedia'=>$image_destination,
           'urlMedia1'=>$file_dest
	    ]);
	    $q->closecursor();
	    //set_flash('Statut added successfully');
	}	
}
}
} 
    if($_GET['device']=="mobile"){
    redirect('mobile/fil.php?id='.get_session('user_id'));    
    }elseif($_GET['device']=="android"){
    redirect('android/fil.php?id='.get_session('user_id'));    
    }
    else{
    redirect('fil.php?id='.get_session('user_id'));
    }
