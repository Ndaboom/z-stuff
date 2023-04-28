<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$q=$db->prepare("SELECT * FROM users 
	            WHERE id=!user_id
	           ");
	           $q->execute([
	               'user_id'=>get_session('user_id')
	               ]);	
               $users= $q->fetchAll(PDO::FETCH_OBJ);
	           $q->closecursor();
	            $output = '<div class="col-md-4">';
               foreach($users as $user){
                $output .= '
                           '.$user->name.'
                          ';    
               }
               $output .='</div>';
               echo $output;