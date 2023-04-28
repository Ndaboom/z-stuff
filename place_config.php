<?php
session_start();
include('filters/auth_filter.php');
require("includes/functions.php");
require("includes/init.php");
require("config/database.php");
require("bootsrap/locale.php");

if(isset($_POST['update'])){
    
    $errors=[];
if(not_empty(['place_name','description','category'])){   
	 extract($_POST); 
	 $file_name = $_POST['image'];
     if(isset($_POST['image']))
     {
     	$file_name = $_POST['image'];
     }

     if($_FILES['image']['name'] != '')
     {
     	
     	 $image_name = explode(".", $_FILES['image']['name']);
     	 $extension = end($image_name);
     	 $temporary_location = $_FILES['image']['tmp_name'];
     	 $file_name = rand() . '.' . strtolower($extension);
     	 $location = 'images/' .$file_name;
     	 move_uploaded_file($temporary_location, $location);
     	 $image_destination = 'images/'.uniqid(time()).'.'.$extension;
     	 $compress_image = compress($location,$image_destination);
     	 $q = $db->prepare('UPDATE places
	 	            SET coverpic= :cover_image  
	 	            WHERE id = :id');
     	 $q->execute([
          'id'=> $_GET['pl_i'],
          'cover_image'=> $image_destination
     	 ]);
     	 

        $q =$db->prepare('INSERT INTO placeposts(place_id,user_id,urlMedia,type,place_name,created_at)
	                  VALUES (:place_id,:user_id,:urlMedia,:type,:place_name,NOW())');
	    $q->execute([
           'place_id'=>get_session('pl_i'),
           'user_id'=>get_session('user_id'),
           'urlMedia'=>$image_destination,
           'type'=>"a change sa photo de couverture",
           'place_name'=>get_session('pl_n')
	    ]);

	    $q->closecursor();
        
     unlink($location);	 
     }

	 $q = $db->prepare('UPDATE places
	 	            SET place_name= :place_name,description= :description,category= :category  
	 	            WHERE id = :id');
		$q->execute([
            'place_name'=> $place_name,
            'description'=> $description,
            'category'=> $category,
            'id'=> $_GET['pl_i'],
			]);
        $q->closecursor();
        if($_GET['mobile'] == "android")
        {
        redirect('android/place_config.php?pl_i='.$_GET['pl_i']);    
        }
		redirect('mobile/place_config.php?pl_i='.$_GET['pl_i']);
	 }
}