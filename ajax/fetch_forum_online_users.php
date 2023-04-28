<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

 $q=$db->prepare("SELECT id,name,nom2,profilepic FROM users
	                            WHERE id!= :id
	                            ");
	           $q->execute([
                   'id'=>get_session('user_id')
	           ]);

               		
                $friends= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor(); 

$output = '';
if(count($friends) != 0){
   foreach($friends as $row)
{  
	
	if(is_him_in($row->id,get_session('fr_i'))){
		$status='';
		$current_timestamp= strtotime(date('Y-m-d H:i:s') .'+3580 second');
		$current_timestamp= date('Y-m-d H:i:s',$current_timestamp);
		$user_last_activity=fetch_user_last_activity($row->id,$db);

		if($user_last_activity > $current_timestamp)
		{
           $status='online';
		}
		else
		{
           $status ='<div class="h7 text-muted">offline</div>';
		}
		
		if($status =='online')
		{
			
            $output .='
                <div class="d-flex bd-highlight">
                <div class="img_cont">
                  <img src="'.e($row->profilepic).'" class="rounded-circle user_img">
                  <span class="online_icon"></span>
                </div>
                </div>
            ';
		}
		
	}
	
}
}

$output .='';

echo $output;

