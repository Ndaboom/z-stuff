<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

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
           $status='<div class="online"></div>';
		}
		else
		{
           $status ='<div class="h7 text-muted">offline</div>';
		}

		if ($status=='<div class="online"></div>') {
			$output .='
		          <div class="d-flex justify-content-between align-items-center friend-state">
		          <div class="d-flex">
                            <div>
                                <img class="rounded-circle" src="'.e($row->profilepic) .'" alt="" style="height: 30px;
			width: 30px;
			border:1.5px solid #f5f6fa;">
                            </div>
                            <div class="ml-2 h7">
                                '.e($row->name) .' '. e($row->nom2) .'
                            </div>
                        </div>
                        '.$status.'
                    </div>';
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
           $status='<div class="online"></div>';
		}
		else
		{
           $status ='<div class="h7 text-muted">offline</div>';
		}

		if ($status=='<div class="h7 text-muted">offline</div>') {
			$output .='
		          <div class="d-flex justify-content-between align-items-center friend-state">
		          <div class="d-flex">
                            <div>
                                <img class="rounded-circle" src="'.e($row->profilepic) .'" alt="" style="height: 30px;
			width: 30px;
			border:1.5px solid #f5f6fa;">
                            </div>
                            <div class="ml-2 h7">
                                '.e($row->name) .' '. e($row->nom2) .'
                            </div>
                        </div>
                        '.$status.'
                    </div>';
		}


	}

}
}

$output .='';

echo $output;
