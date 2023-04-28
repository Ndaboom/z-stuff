<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
if (isset($_POST['imageUploader'])) {
	extract($_POST);
	//set_flash('Statut added successfully');
	if (!empty($_FILES)) {
		$file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

	    $file_name = rand() . '.' . $file_extension;

		//$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
		$q->closecursor();
				$q =$db->prepare('INSERT INTO placepictures(place_id,place_name,urlimage,description,user_id,add_at)
	                  VALUES (:place_id,:place_name,:urlimage,:description,:user_id,NOW())');
	    $q->execute([
	       'place_id'=>get_session('pl_i'),
	       'place_name'=>get_session('pl_n'),
           'urlimage'=>$file_dest,
           'description'=>$description,
           'user_id'=>get_session('user_id')
	    ]);
        $q->closecursor();
	    /*$q= $db->prepare('UPDATE places
	 	            SET image = :image,image1 = :image1,image2 = :image2  
	 	            WHERE id = :place_id');
         $q->execute([
         	'coverpic'=>$file_dest,
            'place_id'=>get_session('pl_i')
			]);*/
			}
		
        if($_GET['device']=="mobile"){
        redirect('mobile/placegallery.php?pl_i='.get_session('pl_i'));    
        }elseif($_GET['device']=="android"){
	    redirect('android/placegallery.php?pl_i='.get_session('pl_i'));     
	    }else{
		redirect('placegallery.php?pl_i='.get_session('pl_i'));
        }
		
	}else{
		echo "Aucun fichier detecte";
	}
	
}