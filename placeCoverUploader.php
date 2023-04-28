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
		$file_name =$_FILES['image']['name'];
		$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

		$extensions_autorisees= array('.jpg','.JPG','.jpeg','.png');

		if (in_array($file_extension, $extensions_autorisees)) {

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
		$q->closecursor();
				$q =$db->prepare('INSERT INTO placeposts(place_id,user_id,urlMedia,type,place_name,created_at)
	                  VALUES (:place_id,:user_id,:urlMedia,:type,:place_name,NOW())');
	    $q->execute([
           'place_id'=>get_session('pl_i'),
           'user_id'=>get_session('user_id'),
           'urlMedia'=>$file_dest,
           'type'=>"a change sa photo de couverture",
           'place_name'=>get_session('pl_n')
	    ]);

	    $q->closecursor();

		$q= $db->prepare('UPDATE places
	 	            SET coverpic = :coverpic  
	 	            WHERE id = :place_id');
         $q->execute([
         	'coverpic'=>$file_dest,
            'place_id'=>get_session('pl_i')
			]);
			}
		

		redirect('homeplace.php?pl_i='.get_session('pl_i'));	
		}else{
			echo "Le format de l'image n'est pas pris en charge";
		}

		
	}else{
		echo "Aucun fichier detecte";
	}
	
}