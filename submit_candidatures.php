<?php
session_start();
require 'config/database.php';
require 'includes/functions.php';
 $last_round=0;
 $q=$db->prepare("SELECT * FROM poll_tb
	                            WHERE session_name= :session_name
	                            AND event_id= :event_id
	                            AND status= :status
	                            ");
	           $q->execute([
                   'status'=>2,
                   'session_name'=>get_session('session_name'),
                   'event_id'=>get_session('ev_i')
	           ]);

               		
                $rounds= $q->fetchAll(PDO::FETCH_OBJ);
                
   if(count($rounds) != 0){
   foreach($rounds as $row)
        {  
	        $last_round=$row->round;
        }
    $last_round = $last_round+1;
   }else{
       $last_round=0;
   }
   

 $q=$db->prepare("SELECT * FROM poll_tb
	                            WHERE status= :status
	                            AND session_name= :session_name
	                            AND event_id= :event_id
	                            ");
	           $q->execute([
                   'status'=>0,
                   'session_name'=>get_session('session_name'),
                   'event_id'=>get_session('ev_i')
	           ]);

               		
                $candidates= $q->fetchAll(PDO::FETCH_OBJ);
	         
if(count($candidates) != 0){
   foreach($candidates as $result)
        {  
	    
	    $q =$db-> prepare("UPDATE poll_tb
		               SET status = :status,round= :round  
		               WHERE id= :id 
		               AND event_id= :event_id
		               AND session_id= :session_id");

	    $q->execute([
		'id'=>$result->id,
		'status'=>1,
		'round'=>$last_round,
		'event_id'=>get_session('ev_i'),
		'session_id'=>get_session('session_id')
	    ]);
	
	
        }
        
        if($_GET['device']="mobile"){
          redirect('mobile/poll_system.php?ev_i='.get_session('ev_i'));
        }else{
    redirect('poll_system.php?ev_i='.get_session('ev_i'));
       }
   }else{
    redirect('mobile/add_candidate.php?session_name='.get_session('session_name'));   
   }
   


