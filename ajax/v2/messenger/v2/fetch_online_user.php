<?php
session_start();
require '../../../../config/database.php';
require '../../../../includes/functions.php';

$q=$db->prepare("SELECT id,name,nom2,profilepic FROM users
	                WHERE id!= :id");
	           $q->execute([
                   'id'=>get_session('user_id')
	           ]);

               $friends= $q->fetchAll(PDO::FETCH_OBJ);
	           $q->closecursor();

$q=$db->prepare("SELECT id,name,nom2,profilepic FROM users
                WHERE id!= :id LIMIT 10");
                $q->execute([
                    'id'=>get_session('user_id')
                ]);

                $offline_friends= $q->fetchAll(PDO::FETCH_OBJ);
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
			$output .='
              <div class="swiper-slide">
                <div class="top-contacts-box">
                <div class="profile-img online">
                <img src="/'.e($row->profilepic) .'" alt="">
                </div>
                <div class="profile-name">
                <span>'.e($row->name) .'</span>
                </div>
                </div>
              </div>
		    ';
		}


	}

}
}

if(count($offline_friends) != 0){
   foreach($offline_friends as $row)
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
		    $output .='
              <div class="swiper-slide">
                <div class="top-contacts-box">
                <div class="profile-img avatar-away">
                <img src="/'.e($row->profilepic) .'" alt="">
                </div>
                <div class="profile-name">
                <span>'.e($row->name) .'</span>
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
