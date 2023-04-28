<?php
session_start();
require '../../../config/database.php';
require '../../../includes/functions.php';

  if(isset($_POST["limit"], $_POST["start"]))
{
 $q=$db->prepare("SELECT chat_message, user, created_at, (SELECT COUNT(*) FROM chat_message WHERE to_user_id = ".$_SESSION["user_id"]." AND from_user_id = user AND status = TRUE) AS unreadMessages  FROM(
               SELECT IF(from_user_id <> ".$_SESSION["user_id"].", from_user_id, to_user_id) AS user, chat_message, created_at, status FROM (
                    SELECT * FROM (
                        SELECT from_user_id, to_user_id, chat_message, created_at, status
                        FROM chat_message
                        WHERE to_user_id = ".$_SESSION["user_id"]." OR from_user_id = ".$_SESSION["user_id"]."
                        ORDER BY id DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."
                    ) AS P GROUP BY from_user_id, to_user_id ORDER BY created_at DESC
                ) AS H GROUP BY user ORDER BY created_at DESC
            ) AS HH
	            ");
	           $q->execute();
               $messages= $q->fetchAll(PDO::FETCH_OBJ);


               $output = '';
                
if(count($messages) != 0){
   foreach($messages as $row)
{  

           $status='';
		$current_timestamp= strtotime(date('Y-m-d H:i:s') .'-25 second');
		$current_timestamp= date('Y-m-d H:i:s',$current_timestamp);
		$user_last_activity=fetch_user_last_activity($row->user,$db);
		
		if($user_last_activity > $current_timestamp)
		{
           $status='<span class="online_icon"></span>';
		}
		else
		{
           $status ='<span class="offline"></span>';
		}
		
		$him = find_user_by_id($row->user);
		if($row->unreadMessages != 0){
		    $count = $row->unreadMessages;
		}else{
		    $count = '';
		}
		
		$output .='
		           <li>
                    <a href="" class="open-chat" data-to_user_id="'.$row->user.'" data-from_user_id="'.$_SESSION['user_id'].'" data-username="'.substr(e($him->name) .' '.e($him->nom2), 0, 15).'">
                        <div class="message-avatar">
                        <i class="status-icon status-online"></i><img src="/'.e($him->profilepic).'" alt=""></div>
                                        <div class="message-by">
                                            <div class="message-by-headline">
                                                <h5>'.substr(e($row->name) .' '. e($row->nom2), 0, 15).'</h5>
                                                <span style="color:#2A41E8;">'.zungvi_time_ago($row->created_at).'</span>
                                            </div>
                                            <p style="color:#2A41E8;">'.substr($row->chat_message, 0, 25).'...</p>
                                        </div>
                                    </a>
                  </li>
		         '; 
	
} 

}

$output .='';

echo $output;
}
