<?php
session_start();
include('filters/auth_filter.php');
require("includes/functions.php");
require("includes/init.php");
require("config/database.php");

if(isset($_POST['update'])){
  
if(not_empty(['candidate_name'])){   
	 extract($_POST); 

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
         
        $q =$db->prepare('INSERT INTO poll_tb(user_name,event_id,urlmedia,points,session_name,session_id,status,created_at)
	                  VALUES (:user_name,:event_id,:urlMedia,:points,:session_name,:session_id,:status,NOW())');
	    $q->execute([
           'user_name'=>$candidate_name,
           'event_id'=>get_session('ev_i'),
           'urlMedia'=>$image_destination,
           'points'=>0,
           'session_name'=>get_session('session_name'),
           'session_id'=>6,
           'status'=>0
	    ]);

	    $q->closecursor();
     }
		redirect('mobile/add_candidate.php?session_name='.$_SESSION['session_name']);
			

	 }
}