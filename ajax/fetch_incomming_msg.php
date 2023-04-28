<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

 $q=$db->prepare("SELECT id FROM chat_message
	                            WHERE to_user_id= :to_user_id AND status= :status
	                            ");
	           $q->execute([
                   'to_user_id'=>get_session('user_id'),
                   'status'=>1
	           ]);
	            $count=$q->rowCount();
	            if($count >1){
	                $title='Messages';
	            }else{
	                $title='Message';
	            }
               
               if($count > 0){
                	$output .='
		       <a class="nav-link" href="message.php"><i class="fas fa-comments"></i> '.$title.'<span class="badge" style="background-color: #F3BB00;">'.$count.'</span></a>    
		      ';   
               }else{
                 	$output .='
		       <a class="nav-link" href="message.php"><i class="fas fa-comments"></i> '.$title.'</a>    
		      ';    
               }


echo $output;

