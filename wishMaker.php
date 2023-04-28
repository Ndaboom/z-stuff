<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');

 $q=$db->prepare("SELECT id,name,nom2,profilepic FROM users
	                            WHERE id= :id 
	                           ");
	           $q->execute([
                   'id'=>$_GET['id']
	           ]);

               		
                $user= $q->fetch(PDO::FETCH_OBJ);
	            $q->closecursor(); 
$_SESSION['him']=$_GET['id'];
	            
require("views/wishMaker.view.php"); 