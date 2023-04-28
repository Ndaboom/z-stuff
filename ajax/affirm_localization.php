<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

 if(get_session('user_id'))
    {
     
     $q = $db->prepare('UPDATE users
	 	            SET city= :city,
	 	            country= :country  
	 	            WHERE id = :id');
 	 $q->execute([
      'id'=> $_SESSION['user_id'],
      'city'=> "Goma",
      'country'=> "DRC"
 	 ]);

    }