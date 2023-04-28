<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);
$data = array(
	        ':from_user_id'              =>$_SESSION["user_id"],
	 		':to_user_id'                => $_SESSION["him"],
	 		':content'                   =>$_POST["wish"],
	 		':color'                     =>$_POST["color"],
	 		':etat'                      => 0
	 	);

	 	$query= "INSERT INTO home_msg(from_user_id,to_user_id,content,color,etat)
	                  VALUES (:from_user_id,:to_user_id,:content,:color,:etat)
	                  ";
	    $statement = $db->prepare($query);
	    $statement->execute($data);