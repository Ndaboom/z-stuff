<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

 $q=$db->prepare("SELECT id FROM chat_message
	                            WHERE to_user_id= :to_user_id AND status= :status
	                            ");
	           $q->execute([
                   'to_user_id'=>get_session('user_id'),
                   'status'=>1
	           ]);
	            $count=$q->rowCount();
     
               if($count > 0){
                	$output .='
		        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
               </svg>
               <span> '.$count.' </span>    
		      ';   
               }else{
                 	$output .='
		        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
               </svg> 
		      ';   
               }


echo $output;

