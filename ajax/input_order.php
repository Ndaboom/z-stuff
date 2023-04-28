<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';

$place_id = $_SESSION['pl_i'] ? $_SESSION['pl_i'] : "";
$user_id = $_SESSION['user_id'];

extract($_POST);
$data = array(
	        'designation'              =>$_POST["designation"],
	 		':user_id'                 => $_SESSION["user_id"],
	 		':object_id'               =>$_POST["pr_i"],
	 		':place_id'                =>$place_id,
			':creator_id'			   =>$user_id,
	 		':object_interaction'      => $_POST["action"],
	 		':object_price'            => $_POST["object_price"],
	 		':image'                   =>$_POST["image"]
	 	);

	 	$query= "INSERT INTO place_orders(designation,user_id,object_id,place_id,creator_id,object_interaction,object_price,image)
	                  VALUES (:designation,:user_id,:object_id,:place_id,:creator_id,:object_interaction,:object_price,:image)
	                  ";
	    $statement = $db->prepare($query);
	    $statement->execute($data);