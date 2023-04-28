<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

  $q=$db->prepare("SELECT chat_message, user, (SELECT COUNT(*) FROM chat_message WHERE to_user_id = ".$_SESSION["user_id"]." AND    from_user_id = user AND status = TRUE) AS unreadMessages  FROM(
               SELECT IF(from_user_id <> ".$_SESSION["user_id"].", from_user_id, to_user_id) AS user, chat_message, created_at, status FROM (
                    SELECT * FROM (
                        SELECT from_user_id, to_user_id, chat_message, created_at, status
                        FROM chat_message
                        WHERE to_user_id = ".$_SESSION["user_id"]." OR from_user_id = ".$_SESSION["user_id"]."
                        ORDER BY id DESC LIMIT 6
                    ) AS P GROUP BY from_user_id, to_user_id ORDER BY created_at DESC
                ) AS H GROUP BY user ORDER BY created_at DESC
            ) AS HH
	 ");
	           $q->execute();
	           $count=$q->rowCount();
	           $messages= $q->fetchAll(PDO::FETCH_OBJ);
	           $q->closecursor(); 
	           $output = '';
     
               if($count > 0){
               
               foreach($messages as $message){
                    $user = find_user_by_id($message->user);
                    
                	$output .='
		         <li class="un-read">
                        <a href="messages.php?n='.$user->name.'&i='.$message->user.'&image_path='.$user->profilepic.'">
                             <div class="drop_avatar"> <img src="'.$user->profilepic.'" style="width:50px; height:50px;" alt="'.$user->name.' profile">
                             </div>
                            <div class="drop_text">
                                <strong> '.$user->name.' '.$user->nom2.' </strong>
                                <p>  '.substr($message->chat_message, 0, 20).'...  </p>
                            </div>
                        </a>
                 </li>  
		      ';   
		      }
               }else{
                    $output .='
		         <li class="un-read">
                        No new messages
                 </li>  
		      ';   
               }

echo $output;

