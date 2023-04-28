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
		$file_path=get_session('product_img2');
		unlink($file_path);

			if (move_uploaded_file($file_tmp_name,$file_dest)) {
		$q->closecursor();

		$q= $db->prepare('UPDATE marketplace
	 	            SET object_view2 = :object_view2  
	 	            WHERE id = :product_id');
         $q->execute([
         	'object_view2'=>$file_dest,
            'product_id'=>get_session('pr_i')
			]);
			}
		

		redirect('about_product.php?pr_i='.get_session('pr_i'));	

		
	}else{
		echo "Aucun fichier detecte";
	}
	
}