<?php
session_start();
require '../../../config/database.php';
require '../../../includes/functions.php';

extract($_POST);

$q = $db->prepare('SELECT * FROM users
	               WHERE (name LIKE :query OR nom2 LIKE :query OR email LIKE :query)
	               LIMIT 7
	               ');
$q->execute([
             'query'=> '%'.$query.'%'
]);

$users = $q->fetchAll(PDO::FETCH_OBJ);
$output='';
if (count($users)>0) {
	foreach ($users as $row) {

        $status='';
		$current_timestamp= strtotime(date('Y-m-d H:i:s') .'-25 second');
		$current_timestamp= date('Y-m-d H:i:s',$current_timestamp);
		$user_last_activity=fetch_user_last_activity($row->id,$db);
			if($user_last_activity > $current_timestamp)
		{
           $status='<span class="online_icon"></span>';
		}
		else
		{
           $status ='<span class="offline"></span>';
		}
		
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
    
    if(already_friends(get_session('user_id'), $row->id)){
        $output .= '
        <li class="un-read">
                <a href="messages.php?n='.e($row->name).'&i='.$row->id.'">
                    <div class="drop_avatar"> <img src="/'.e($row->profilepic) .'" style="width:50px; height:50px;" alt="'.$user->name.' profile">
                    </div>
                    <div class="drop_text">
                        <strong> '.$row->name.' '.$row->nom2.' </strong>
                        <p>'.substr($result->chat_message, 0, 20).'...</p>
                    </div>
                </a>
        </li>  
        ';
    }
    
    }
}

echo $output;
