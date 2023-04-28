<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if($action == "follow"){
    
   if(!a_place_has_already_been_followed($place_id,get_session('user_id'))){
   $q =$db-> prepare(
		               'INSERT INTO places_followers(place_id,user_id,status)
		               VALUES(:place_id,:user_id,:status)');

	$q->execute([
		'place_id'=>$place_id,
		'user_id'=>get_session('user_id'),
		'status'=>1
		
	]);

	$q=$db->prepare("INSERT INTO place_notifications(poster_id,content,place_name,place_id,seen,posted_at)
                     VALUES(:poster_id,:content,:place_name,:place_id,:seen,NOW())
		            ");
	$q->execute([
		'poster_id'=>get_session('user_id'),
		'content'=>"you have 1 follower",
		'place_name'=>$place_name,
		'place_id'=>$place_id,
		'seen'=>0
	]);

	 $q = $db->prepare('INSERT INTO notifications(place_id,subject_id ,user_id,type,created_at)
                         VALUES(:place_id,:subject_id ,:user_id,:type, NOW())');
                $q->execute([
                'place_id' =>$place_id,
                'user_id' =>get_session('user_id'),
                'subject_id'=>$cr_i,
                'type' => "A commence a suivre votre place "             
    ]);
    
    }
    
    $q->closeCursor();  
	           
}elseif($action == "unfollow"){

    $q=$db->prepare('DELETE FROM places_followers
                     WHERE user_id= :user_id AND place_id= :place_id');
	$q->execute([
	             'user_id'=> get_session('user_id'),
                 'place_id'=> $place_id
	           ]);
	$q->closeCursor();  

}	

echo place_followers($place_id);  
      
