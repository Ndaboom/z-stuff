<?php
session_start();
require("includes/init.php");
require("config/database.php");
require('includes/functions.php');
include('filters/guest_filter.php');

$q=$db->prepare("SELECT * FROM users
	                WHERE email= :email");
		$q->execute([
            'email'=>$_GET['email']	
			]);
			$userHasBeenFound=$q->rowCount();
			if($userHasBeenFound){
				$user=$q->fetch(PDO::FETCH_OBJ);
	         }
require("views/user.view.php");