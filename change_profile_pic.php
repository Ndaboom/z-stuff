<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
if (isset($_POST['publish2'])) {
	//set_flash('Statut added successfully');
	if (!empty($_FILES)) {
		$file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

	    $file_name = rand() . '.' . $file_extension;

		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
			    $source_image = $file_dest;
		        $image_destination = 'images/'.uniqid(time()).'.'.$file_extension;
		        $compress_image = compress($source_image,$image_destination);
				$q =$db->prepare('INSERT INTO profilePics(user_id,url,compressed_img,created_at)
	                  VALUES (:user_id,:url,:compressed_img,NOW())');
	    $q->execute([
           'user_id'=>get_session('user_id'),
           'url'=>$file_dest,
           'compressed_img'=>$image_destination
	    ]);
	    $q->closecursor();
			}
		

		$q =$db->prepare('INSERT INTO microposts(user_id,urlMedia,type,created_at)
	                  VALUES (:user_id,:urlMedia,:type,NOW())');
	    $q->execute([
           'user_id'=> $_SESSION['user_id'],
           'urlMedia'=>$image_destination,
           'type'=>"profile_updated"
	    ]);
	    $q->closecursor();

		$q= $db->prepare('UPDATE users
	 	            SET profilepic = :profilepic  
	 	            WHERE id = :id');
         $q->execute([
         	'profilepic'=>$image_destination,
            'id'=>get_session('user_id')
			]);
       if($_GET['device']=="mobile"){
        redirect('mobile/profile.php?id='.get_session('user_id'));    
        }elseif($_GET['device']=="android")
        {
        redirect('android/profile.php?id='.get_session('user_id'));    
        }else{
		redirect('profile.php?id='.get_session('user_id'));	
        }
		
	}else{
		if($_GET['device']=="mobile"){
        redirect('mobile/profile.php?id='.get_session('user_id'));    
        }elseif($_GET['device']=="android")
        {
        redirect('android/profile.php?id='.get_session('user_id'));    
        }else{
		redirect('profile.php?id='.get_session('user_id'));	
        }
	}
	
}
