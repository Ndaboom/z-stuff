<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

 $q=$db->prepare("SELECT id FROM chat_message
	                            WHERE to_user_id= :to_user_id AND status= :status AND status_ring= :status_ring
	                            ");
	           $q->execute([
                   'to_user_id'=>get_session('user_id'),
                   'status'=>1,
                   'status_ring'=>0
	           ]);
	            $count=$q->rowCount();
	            
	            $data=$q->fetch(PDO::FETCH_OBJ);
	            
 $q= $db->prepare('UPDATE chat_message
                   SET status_ring= :status_ring
                   WHERE id= :msg_id');
                $q->execute([
                    'status_ring'=>1,
                    'msg_id'=>$data->id
                    ]);
                
                $output = '';
               if($count > 0){
                	$output .=''.$count.'';   
               }else{
                 	$output .='';    
               }


echo $output;

