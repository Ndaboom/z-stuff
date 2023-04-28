<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

 if(get_session('user_id'))
    {
     extract($_POST);

     $q = $db->prepare('UPDATE users
	 	            SET city= :city,
	 	            country= :country  
	 	            WHERE id = :id');
 	 $q->execute([
      'id'=> $_SESSION['user_id'],
      'city'=> $_POST['city'],
      'country'=> $_POST['country']
 	 ]);

    }