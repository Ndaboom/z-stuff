<?php 
session_start();
include 'config/database.php';
include 'includes/functions.php';
if(get_session('user_id'))
{
	$q = $db->prepare('UPDATE users
	 	            SET theme= :theme  
	 	            WHERE id = :id');
     	 $q->execute([
          'id'=> get_session('user_id'),
          'theme'=> $_GET['theme']
     	 ]);

    redirect('profile.php?id'.get_session('user_id'));
}