<?php

session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

if(!empty($_GET['id'])){

    $user= find_user_by_id($_GET['id']);
    $friends = limited_friends_of($_GET['id'], 6);
    $user2 = find_user_by_id($_SESSION['user_id']);
    $MeinsideF = forum_where_user_is();

    $q = $db->prepare('SELECT * FROM profile_comments

                       WHERE profile_id = :profile_id');

    $q->execute(['profile_id'=>get_session('user_id')]);

    $comments = $q->fetchAll(PDO::FETCH_OBJ);
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

	redirect('profile.php?id='.get_session('user_id'));

}



 if(get_session('user_id') != $_GET['id']){

    $date1 = date("Y-m-d H:i:s");

   // Sauvegarde de la notification

   if(!views_notifications(get_session('user_id'))){

     $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)

                      VALUES(:subject_id, :name, :user_id)');

                      $q->execute([

                      'subject_id' => $_GET['id'],

                      'name' => 'viewed_your_profile',

                      'user_id' => get_session('user_id')

                      ]);

   }else{

      $q =$db-> prepare("UPDATE notifications SET seen ='0' AND created_at= :created_at  
                       WHERE subject_id = :subject_id AND name= :name AND user_id= :user_id");



    $q->execute([

        'subject_id' => $_GET['id'],

        'name' => 'viewed_your_profile',

        'user_id' => get_session('user_id'),

        'created_at'=>$date1

    ]);

   }

}









// Si le formulaire a été soumis

if(isset($_POST['update'])){
    $errors=[];

if(not_empty(['name','nom2'])){   

	 extract($_POST); 
	 $q = $db->prepare('UPDATE users

	 	            SET name= :name,nom2= :nom2,city= :city,country= :country,sex= :sex,

	 	            twitter= :twitter,github= :github,instagram= :instagram,

	 	            available_for_hiring= :available_for_hiring,bio= :bio,dbirth= :dbirth, profession= :profession, relationshipStatus= :relationshipStatus,religion= :religion  

	 	            WHERE id = :id');

		$q->execute([

            'name'=> $name,

            'nom2'=>$nom2,

            'city'=> $city,

            'country'=> $country,

            'sex'=> $sex,

            'twitter'=> $twitter,

            'github'=> $github,

            'instagram'=>$instagram,

            'available_for_hiring'=> !empty($available_for_hiring) ? '1' :'0',

            'dbirth'=>$dbirth,

            'profession'=>$profession,

            'relationshipStatus'=>$relationshipStatus,

            'religion'=>$religion,

            'bio'=> $bio,

            'id'=> $_SESSION['user_id'],

			]);

		set_flash('profile updated with success');

		redirect('profile.php?id='.get_session('user_id'));

			



	 }else{

	 	save_input_data();

        $errors[]="please fill in all required fields";

	 }

	}else{

	   clear_input_data();

	 }



    

     

require("views/v2/timeline.view.php"); 	

?>













