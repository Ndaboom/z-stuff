<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

if(!empty($_GET['id']) && $_GET['id'] == $_SESSION['user_id']){
    $user= find_user_by_id($_GET['id']);
    $user2 = find_user_by_id($_SESSION['user_id']);

    $_SESSION['him'] = $_GET['id'];
    
    if($user->sex == "F" && $user->profilepic == "images/default.png")
    {
    $q = $db->prepare('UPDATE users 
                       SET profilepic= :profilepic
                       WHERE id= :user_id');
    $q->execute([
        'profilepic'=>"images/default_girl.png",
        'user_id'=>get_session('user_id')
        ]);
    }

    

    if(!$user){
    	redirect('index.php');
    }
}else{
    if(!already_in_login_details(get_session('user_id'))){
               $q=$db->prepare('INSERT INTO login_details(user_id,last_activity)
	                 VALUES(:user_id,NOW())
	                  ');
	                  $q->execute([
	                  'user_id'=>get_session('user_id')
	
	                ]);
             }
	redirect('timeline.php?id='.get_session('user_id'));
}


// Si le formulaire update_info a été soumis
if(isset($_POST['update_info'])){
    
    $errors=[];
if(not_empty(['firstname','lastname'])){   
	 extract($_POST); 


	 $q = $db->prepare('UPDATE users
	 	            SET name= :name,nom2= :nom2, email= :email, city= :city,country= :country,sex= :sex,
	 	            available_for_hiring= :available_for_hiring,bio= :bio,dbirth= :dbirth, profession= :profession, relationshipStatus= :relationshipStatus,religion= :religion  
	 	            WHERE id = :id');
		$q->execute([
            'name'=> $firstname,
            'nom2'=>$lastname,
            'email' => $email,
            'city'=> $city,
            'country'=> $country,
            'sex'=> $sex,
            'available_for_hiring'=> !empty($available_for_hiring) ? '1' :'0',
            'dbirth'=>$dbirth,
            'profession'=>$profession,
            'relationshipStatus'=>$relationship,
            'religion'=>$religion,
            'bio'=> $bio,
            'id'=> $_SESSION['user_id'],
			]);
		set_flash('profile updated with success');
		redirect('profile_settings.php?id='.get_session('user_id'));
			
	 }else{
	 	save_input_data();
        $errors[]="please fill in all required fields";
	 }
	}else{
	   clear_input_data();
    }
    
    // Si le formulaire update_social_links a été soumis
if(isset($_POST['update_social_links'])){
     
	 extract($_POST); 

	 $q = $db->prepare('UPDATE users
	 	            SET instagram= :instagram, twitter= :twitter, github= :github  
	 	            WHERE id = :id');
		$q->execute([
            'instagram'=> $instagram,
            'twitter'=> $twitter,
            'github' => $github,
            'id'=> $_SESSION['user_id']
			]);
		set_flash('profile updated with success');
		redirect('profile_settings.php?id='.get_session('user_id'));

}else{
	   clear_input_data();
}

if(isset($_POST['update_password'])){
    
    $errors=[];
  if(not_empty(['new_password','password_confirmation'])){   
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
			$errors[] ="Password updated successfully!";
		}else if($user->hashed_password == ""){
			$q= $db->prepare('UPDATE users SET password = :password WHERE id= :id');
			
			$q->execute([
				'password'=>sha1($new_password),
				'id'      =>get_session('user_id')
			]);
			$errors[] ="Password updated successfully!";
		}else
		{
			save_input_data();
			$errors[]= "The current password enter is incorrect";
		}
			
    }
  }
}

if(isset($_POST['update_privacy'])){
     
     extract($_POST); 

	 $q = $db->prepare('UPDATE users
	 	            SET posts_privacy= :posts_privacy, friends_privacy= :friends_privacy, comments_privacy= :comments_privacy  
	 	            WHERE id = :id');
		$q->execute([
            'posts_privacy'=> !empty($posts_privacy) ? '1' :'0',
			'friends_privacy'=> !empty($friends_privacy) ? '1' :'0',
            'comments_privacy'=> !empty($comments_privacy) ? '1' :'0',
            'id'=> $_SESSION['user_id']
			]);
		set_flash('privacy updated');
		redirect('profile_settings.php?id='.get_session('user_id').'&p=privacy');
     
}

if(isset($_POST['delete_account'])){
	extract($_POST);

	$q=$db->prepare("SELECT email FROM users
                  WHERE id= :id AND password= :password AND active='1'");

    $q->execute([
            'id'=> $_SESSION['user_id'],
            'password'=>sha1($_POST['user_password'])
    ]);

	$userHasBeenFound=$q->rowCount();

	if($userHasBeenFound){
	$user=$q->fetch(PDO::FETCH_OBJ);
	$user_id = $user->id;

	$q =$db-> prepare(
		'DELETE FROM users
		WHERE id = :id');

	$q->execute([
	'id'=>$user_id
	]);

	$q =$db-> prepare(
		'DELETE FROM friends_relationships
		WHERE user_id1= :user_id1 OR user_id2= :user_id2');

	$q->execute([
	'user_id1'=>$user_id,
	'user_id2'=>$user_id
	]);

	$q =$db-> prepare(
		'DELETE FROM notifications
		WHERE subject_id= :subject_id');

	$q->execute([
	'subject_id'=>$user_id
	]);

	$q =$db-> prepare(
		'DELETE FROM microposts
		WHERE user_id= :user_id');

	$q->execute([
	'user_id'=>$user_id
	]);

	redirect('logout.php');

	}

	set_flash('Incorrect password');
	redirect('profile_settings.php?id='.get_session('user_id').'&p=delete_account');

}   
     
require("views/v2/profile_settings.view.php"); 	
?>






