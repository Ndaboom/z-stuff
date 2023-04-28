<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");


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

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
            $source_image = $file_dest;
		   $image_destination = 'images/'.uniqid(time()).'.'.$file_extension;
		   $compress_image = compress($source_image,$image_destination);

	$q =$db->prepare('INSERT INTO eventposts(legend,user_id,event_id,urlMedia,urlMedia1,created_at)
	                  VALUES (:content,:user_id,:event_id,:urlMedia,:urlMedia1, NOW())');
	    $q->execute([
           'content'=>$content,
           'user_id'=> $_SESSION['user_id'],
           'event_id' => $_SESSION['ev_i'],
           'urlMedia'=>$image_destination,
           'urlMedia1'=>$file_dest
	    ]);
	    $q->closecursor();
	    //set_flash('Statut added successfully');
	}
}else{
       
        $q =$db->prepare('INSERT INTO eventposts(legend,user_id,event_id,urlMedia,urlMedia1,created_at)
	                  VALUES (:content,:user_id,:event_id,:urlMedia,:urlMedia1, NOW())');
	    $q->execute([
           'content'=>$content,
           'user_id'=> $_SESSION['user_id'],
           'event_id'=> $_SESSION['ev_i'],
           'urlMedia'=>$image_destination,
           'urlMedia1'=>$file_dest
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

		$q =$db->prepare('INSERT INTO eventposts(user_id,event_id,urlMedia,urlMedia1,created_at)
	                  VALUES (:user_id,:event_id,:urlMedia,:urlMedia1, NOW())');
	    $q->execute([
           'user_id'=> $_SESSION['user_id'],
           'event_id'=> $_SESSION['ev_i'],
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
    redirect('mobile/homeevent.php?ev_i='.get_session('ev_i'));    
    }elseif($_GET['device']=="android"){
    redirect('android/homeevent.php?ev_i='.get_session('ev_i'));    
    }
    else{
    redirect('homeevent.php?ev_i='.get_session('ev_i'));
    }
