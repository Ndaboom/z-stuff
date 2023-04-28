<?php
session_start();
 
include('filters/auth_filter.php');
require("includes/functions.php");
require("includes/init.php");
require("config/database.php");
require("bootsrap/locale.php");

if(!empty($_GET['id']) && $_GET['id'] === get_session('user_id')){
    $user=find_user_by_id($_GET['id']);
    

    if(!$user){
    	redirect('index.php');
    }
}else{
	redirect('profile.php?id='.get_session('user_id'));
}

if(isset($_POST['update'])){
    
    $errors=[];
if(not_empty(['name','city','country','sex'])){   
	 extract($_POST); 
	 $file_name = $_POST['profile_image'];
     if(isset($_POST['profile_image']))
     {
     	$file_name = $_POST['profile_image'];
     }

     if($_FILES['profile_image']['name'] != '')
     {
     	
     	 $image_name = explode(".", $_FILES['profile_image']['name']);
     	 $extension = end($image_name);
     	 $temporary_location = $_FILES['profile_image']['tmp_name'];
     	 $file_name = rand() . '.' . strtolower($extension);
     	 $location = 'images/' .$file_name;
     	 move_uploaded_file($temporary_location, $location);
     	 $q = $db->prepare('UPDATE users
	 	            SET profilepic= :profile_image  
	 	            WHERE id = :id');
     	 $q->execute([
          'id'=> $_SESSION['user_id'],
          'profile_image'=> $location
     	 ]);

        $q = $db->prepare('INSERT INTO profilePics(user_id,url,created_at)
                      VALUES (:user_id,:url,NOW())');
        $q->execute([
           'user_id'=>get_session('user_id'),
           'url'=>$location
        ]);

        $q =$db->prepare('INSERT INTO microposts(user_id,urlMedia,type,created_at)
                      VALUES (:user_id,:urlMedia,:type,NOW())');
        $q->execute([
           'user_id'=> $_SESSION['user_id'],
           'urlMedia'=>$location,
           'type'=>"profile_updated"
        ]);
        
     	 
     }

	 $q = $db->prepare('UPDATE users
	 	            SET name= :name,city= :city,country= :country,sex= :sex,
	 	            twitter= :twitter,github= :github,
	 	            available_for_hiring= :available_for_hiring,bio= :bio ,dbirth= :dbirth, profession= :profession, relationshipStatus= :relationshipStatus,religion= :religion  
	 	            WHERE id = :id');
		$q->execute([
            'name'=> $name,
            'city'=> $city,
            'country'=> $country,
            'sex'=> $sex,
            'twitter'=> $twitter,
            'github'=> $github,	
            'available_for_hiring'=> !empty($available_for_hiring) ? '1' :'0',
            'dbirth'=>$dbirth,
            'profession'=>$profession,
            'relationshipStatus'=>$relationshipStatus,
            'religion'=>$religion,
            'bio'=> $bio,
            'id'=> $_SESSION['user_id'],
			]);
        $q->closecursor();
		set_flash('profile updated with success');
		redirect('profile.php?id='.get_session('user_id'));
			

	 }else{
	 	save_input_data();
        $errors[]="please fill in all required fields";
	 }
	}else{
	   clear_input_data();
	 }

	 require('views/edit_user.view.php');