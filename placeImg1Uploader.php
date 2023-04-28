<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
if (isset($_POST['coverUploader'])) {
	//set_flash('Statut added successfully');
	if (!empty($_FILES)) {
		$file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

	    $file_name = rand() . '.' . $file_extension;

		//$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
		$q->closecursor();

		$q= $db->prepare('UPDATE places
	 	            SET image = :image  
	 	            WHERE id = :place_id');
         $q->execute([
         	'image'=>$file_dest,
            'place_id'=>get_session('pl_i')
			]);
			}
		
        if($_GET['device']=="mobile"){
        redirect('mobile/placegallery.php?pl_i='.get_session('pl_i').'#customizer');   
        }elseif($_GET['device']=="android"){
	    redirect('android/placegallery.php?pl_i='.get_session('pl_i').'#customizer');     
	    }else{
		redirect('placegallery.php?pl_i='.get_session('pl_i').'#customizer');	
        }
		
	}else{
		echo "Aucun fichier detecte";
	}
	
}