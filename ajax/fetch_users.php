<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
{
 $q=$db->prepare("SELECT id,name,nom2,profilepic FROM users
	                            WHERE id!= :id ORDER BY last_msg DESC
	                            LIMIT ".$_POST["start"].", ".$_POST["limit"]."
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
		$status='';
		$current_timestamp= strtotime(date('Y-m-d H:i:s') .'-25 second');
		$current_timestamp= date('Y-m-d H:i:s',$current_timestamp);
		$user_last_activity=fetch_user_last_activity($row->id,$db);

        $query= "
            SELECT * FROM chat_message
            WHERE (from_user_id= '".get_session('user_id')."'
            AND to_user_id = '".$row->id."')
            OR (from_user_id= '".get_session('user_id')."'
            AND to_user_id= '".$row->id."') 
            ORDER BY created_at DESC
    ";
    $statement= $db->prepare($query);
    $statement->execute();
    $result=$statement->fetch(PDO::FETCH_OBJ);
		if($user_last_activity > $current_timestamp)
		{
           $status='<span class="online_icon"></span>';
		}
		else
		{
           $status ='<span class="offline"></span>';
		}
		if(count_unseen_message($row->id,get_session('user_id'),$db)){
		   $output .='
		           <div class="user" style="border-bottom: solid 1px #DDDDDD;">
		           <div class="row">
                     <div class="img_cont">
                  <img src="'.e($row->profilepic) .'" class="rounded-circle user_img">
                  '.$status.'
                     </div>
                     <div class="user_info start_chat" data-touserid="'.$row->id.'" data-tousername="'.$row->name.'" data-touserpic="'. $row->profilepic .'">
                  <span>'.substr(e($row->name) .' '. e($row->nom2), 0, 15).'</span><br>
                  '.substr($result->chat_message, 0, 5).'... '.count_unseen_message($row->id,get_session('user_id'),$db).' '.fetch_is_type_status($row->id,$db).'
                     </div>
                     </div>
		           </div>
		         '; 
		}
		    
	
} 

}
if(count($friends) != 0){
   foreach($friends as $row)
{  
	
	if(already_friends(get_session('user_id'), $row->id)){
		$status='';
		$current_timestamp= strtotime(date('Y-m-d H:i:s') .'-25 second');
		$current_timestamp= date('Y-m-d H:i:s',$current_timestamp);
		$user_last_activity=fetch_user_last_activity($row->id,$db);

        $query= "
            SELECT * FROM chat_message
            WHERE (from_user_id= '".get_session('user_id')."'
            AND to_user_id = '".$row->id."')
            OR (from_user_id= '".get_session('user_id')."'
            AND to_user_id= '".$row->id."') 
            ORDER BY created_at DESC
    ";
    $statement= $db->prepare($query);
    $statement->execute();
    $result=$statement->fetch(PDO::FETCH_OBJ);
		if($user_last_activity > $current_timestamp)
		{
           $status='<span class="online_icon"></span>';
		}
		else
		{
           $status ='<span class="offline"></span>';
		}
		if(!count_unseen_message($row->id,get_session('user_id'),$db)){
		   $output .='
		           <div class="user" style="border-bottom: solid 1px #DDDDDD;">
		           <div class="row">
                     <div class="img_cont">
                  <img src="'.e($row->profilepic) .'" class="rounded-circle user_img">
                  '.$status.'
                     </div>
                     <div class="user_info start_chat" data-touserid="'.$row->id.'" data-tousername="'.$row->name.'" data-touserpic="'. $row->profilepic .'">
                  <span>'.substr(e($row->name) .' '. e($row->nom2), 0, 15).'</span><br>
                  '.substr($result->chat_message, 0, 5).'... '.count_unseen_message($row->id,get_session('user_id'),$db).' '.fetch_is_type_status($row->id,$db).'
                     </div>
                     </div>
		           </div>
		         '; 
		}
		    
		
	}
	
} 

}

$output .='';

echo $output;
}