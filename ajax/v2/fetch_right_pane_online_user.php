<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

 $q=$db->prepare("SELECT id,name,nom2,profilepic FROM users
	                WHERE id!= :id
                  LIMIT 10");
	           $q->execute([
                   'id'=>get_session('user_id')
	           ]);

               $friends= $q->fetchAll(PDO::FETCH_OBJ);
	           $q->closecursor();

$output = '';


if(count($friends) != 0){
   foreach($friends as $row)
{

	if(already_friends(get_session('user_id'), $row->id)){
		$status='';
		$current_timestamp= strtotime(date('Y-m-d H:i:s') .'-25 second');
		$current_timestamp= date('Y-m-d H:i:s',$current_timestamp);
		$user_last_activity=fetch_user_last_activity($row->id,$db);

		if($user_last_activity > $current_timestamp)
		{
           $status='online';
		}
		else
		{
           $status ='offline';
		}

		if ($status=='online') {
            $output .= '
            <a href="messages.php?n='.$row->name.'&i='.$row->id.'&image_path='.$row->profilepic.'">
                <div class="contact-avatar">
                    <img src="/'.e($row->profilepic) .'" alt="'.e($row->name) .' profile picture">
                    <span class="user_status status_online"></span>
                </div>
                <div class="contact-username"> '.e($row->name) .' '. e($row->nom2) .'</div>
            </a>
            ';
		}

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

		if($user_last_activity > $current_timestamp)
		{
           $status='online';
		}
		else
		{
           $status ='offline';
		}

		if ($status=='offline') {
			$output .= '
            <a href="messages.php?n='.$row->name.'&i='.$row->id.'&image_path='.$row->profilepic.'">
                <div class="contact-avatar">
                    <img src="/'.e($row->profilepic) .'" alt="'.e($row->name) .' profile picture">
                    <span class="user_status"></span>
                </div>
                <div class="contact-username"> '.e($row->name) .' '. e($row->nom2) .'</div>
            </a>
            ';
		}


	}

}
}

$output .='';

echo $output;
