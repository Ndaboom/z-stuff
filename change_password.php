<?php
session_start();
 
include('filters/auth_filter.php');
require("includes/functions.php");
require("includes/init.php");
require("config/database.php");
if(!empty($_GET['id']) && $_GET['id'] === get_session('user_id')){
    $user=find_user_by_id($_GET['id']);


    

    if(!$user){
    	redirect('index.php');
    }
}else{
	redirect('change_password.php?id='.get_session('user_id'));
}

if(isset($_POST['change_password'])){
    
    $errors=[];
if(not_empty(['current_password','new_password','password_confirmation'])){   
	 extract($_POST);
	// Verification du mot de passe
	if (mb_strlen($new_password)<6){
	$errors[] ="password too short! (Minimum 6 characters)";
	}else{
	 
	 if ($new_password!=$password_confirmation){
	$errors[] ="the two passwords do not match";
	}
	}
	if (count($errors) == 0) {
		$q=$db->prepare("SELECT password AS hashed_password FROM users
	                WHERE (id= :id)
	                AND active='1'");
		$q->execute([
            'id'=>get_session('user_id')	
			]);
			$user=$q->fetch(PDO::FETCH_OBJ);
			$current_password=sha1($current_password);

			if ($current_password == $user->hashed_password) {
				$q= $db->prepare('UPDATE users SET password = :password WHERE id= :id');
			    
			    $q->execute([
                    'password'=>sha1($new_password),
                    'id'      =>get_session('user_id')
			    ]);
			    set_flash("Password updated successfully");
			    redirect('profile.php?id='.get_session('user_id'));
			}else
			{
				save_input_data();
				$errors[]= "The current password enter is incorrect";
			}
			
}
}
}

	 require('views/change_password.view.php');