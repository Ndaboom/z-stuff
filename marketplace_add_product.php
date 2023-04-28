<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');

if (isset($_POST['add_product'])) {

   if(!empty($_POST['object_name'])){
		extract($_POST);
	//set_flash('Statut added successfully');
	if (!empty($_FILES)) {
		$file_name =$_FILES['image']['name'];
		$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

		$extensions_autorisees= array('.jpg','.JPG','.jpeg','.png');

		if (in_array($file_extension, $extensions_autorisees)) {

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
				$q =$db->prepare('INSERT INTO marketplace(creator_id,place_name,place_id,object_name,object_price,object_interaction,object_view1,add_at)
	                  VALUES (:creator_id,:place_name,:place_id,:object_name,:object_price,:object_interaction,:object_view1,NOW())');
	    $q->execute([
           'creator_id'=>$_SESSION['user_id'],
           'place_name'=>$_SESSION['pl_n'],
           'place_id'=>$_SESSION['pl_i'],
           'object_name'=> $object_name,
           'object_price'=>$object_price,
           'object_interaction'=>$object_interaction,
           'object_view1'=>$file_dest
	    ]);
	    $q->closecursor();
	    if($_GET['device']=="mobile"){
	    redirect('mobile/homeplace.php?pl_i='.get_session('pl_i'));
	    }elseif($_GET['device']=="marketplace4mobile"){
	    redirect('mobile/marketplace.php?pl_i='.get_session('pl_i'));
	    }elseif($_GET['device']=="marketplace4android")
	    {
	    redirect('android/marketplace.php?pl_i='.get_session('pl_i'));   
	    }else{
	    redirect('homeplace.php?pl_i='.get_session('pl_i'));
	    }
	 
	    }
			
		}else{
			echo "Le format de l'image n'est pas pris en charge";
		}

		
	}else{
		echo "Aucun fichier detecte";
	}
	}
}
    