<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

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
			<a href="messages.php?n='.$row->name.'&i='.$row->id.'">
                  <div class="contact-avatar">
                      <img src="/'.e($row->profilepic) .'" alt="">
                      <span class="user_status status_online"></span>
                  </div>
                  <div class="contact-username">'.e($row->name) .' '. e($row->nom2) .'</div>
            </a>
            <div uk-drop="pos: left-center ;animation: uk-animation-slide-left-small">
                  <div class="contact-list-box">
                      <div class="contact-avatar">
                          <img src="/'.e($row->profilepic) .'" alt="">
                          <span class="user_status status_online"></span>
                      </div>
                      <div class="contact-username">'.e($row->name) .' '. e($row->nom2) .'</div>
                      <p> 
                        <ion-icon name="people" class="text-lg mr-1"></ion-icon> friends with 
                        <strong> you </strong> and <strong> '.(friends_count_v2($row->id)-1).' Others</strong>
                      </p>
                      <div class="contact-list-box-btns">
                          <button type="button" href="messages.php?n='.$row->name.'&i='.$row->id.'" data-user_id="'.$row->id.'" data-username="'.$row->name.'"  class="button primary flex-1 block mr-2 send_message">
                          <i class="far fa-smile-wink"></i> Send message</button>
                          <button type="button"  href="timeline.php?n='.$row->name.'&id='.$row->id.'" data-user_id="'.$row->id.'" data-username="'.$row->name.'" class="button secondary button-icon mr-2 user_profile">
                          <i class="far fa-user"></i> </button>
                          <button type="button" href="posts.php?id='.$row->id.'" data-user_id="'.$row->id.'" data-username="'.$row->name.'" class="button secondary button-icon user_post"> 
                          <i class="fas fa-photo-video"></i> </i> 
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
		    <a href="messages.php?n='.$row->name.'&i='.$row->id.'">
                  <div class="contact-avatar">
                      <img src="'.e($row->profilepic) .'" alt="">
                      <span class="user_status"></span>
                  </div>
                  <div class="contact-username">'.e($row->name) .' '. e($row->nom2) .'</div>
            </a>
            <div uk-drop="pos: left-center; animation: uk-animation-slide-left-small">
                  <div class="contact-list-box">
                      <div class="contact-avatar">
                          <img src="/'.e($row->profilepic) .'" alt="">
                          <span class="user_status"></span>
                      </div>
                      <div class="contact-username">'.e($row->name) .' '. e($row->nom2) .'</div>
                      <p> 
                          <ion-icon name="people" class="text-lg mr-1"></ion-icon> friends with 
                          <strong> you </strong> and <strong> '.(friends_count_v2($row->id)-1).' Others</strong>
                      </p>
                      <div class="contact-list-box-btns">
                          <button type="button" href="messages.php?n='.$row->name.'&i='.$row->id.'" data-user_id="'.$row->id.'" data-username="'.$row->name.'" class="button primary flex-1 block mr-2 send_message">
                              <i class="far fa-smile-wink"></i> Send message</button>
                          <button type="button" href="timeline.php?n='.$row->name.'&id='.$row->id.'" data-user_id="'.$row->id.'" data-username="'.$row->name.'" class="button secondary button-icon mr-2 user_profile">
                          <i class="far fa-user"></i> </button>
                          <button type="button" href="posts.php?id='.$row->id.'" data-user_id="'.$row->id.'" data-username="'.$row->name.'" class="button secondary button-icon user_post"> 
                          <i class="fas fa-photo-video"></i> </i> 
                          </button>
                      </div>
                  </div>
              </div>';
		}


	}

}
}

$output .='';

echo $output;
