<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);

$q=$db->prepare('INSERT INTO place_comments(user_id, place_id,post_id,content_text,created_at)
		             VALUES(:user_id, :place_id,:post_id ,:content_text,NOW())');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'place_id'=>get_session('pl_i'),
                 'post_id'=> $postId,
                 'content_text'=>$message
	           ]);
	$q->closecursor();

 if (get_session('user_id') != get_session('cr_i')) {
  	$q=$db->prepare("INSERT INTO place_notifications(poster_id,content,place_name,place_id,object_id,seen,posted_at)
                     VALUES(:poster_id,:content,:place_name,:place_id,:object_id,:seen,NOW())
		            ");
	$q->execute([
		'poster_id'=>get_session('user_id'),
		'content'=>"has_commented",
		'place_name'=>get_session('pl_n'),
		'place_id'=>get_session('pl_i'),
		'object_id'=>$postId,
		'seen'=>0
	]);

	 $q = $db->prepare('INSERT INTO notifications(place_id,subject_id ,user_id,post_id,type,created_at)
                         VALUES(:place_id,:subject_id ,:user_id,:post_id,:type, NOW())');
                $q->execute([
                'place_id' =>get_session('pl_i'),
                'user_id' =>get_session('user_id'),
                'subject_id'=>get_session('cr_i'),
                'post_id'=>$postId,
                'type' => "has_commented"             
]);
  }/*else{
  	 //Recuperation de toutes les personnes ayant commenter a un placepost
	$q =$db->prepare('SELECT poster_id FROM place_notifications
                      WHERE place_id= :place_id AND poster_id != :user_id
                    ');
	$q->execute([
                   'place_id'=>get_session('pl_i'),
                   'user_id'=>get_session('user_id')
	           ]);
                $users= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor();
    foreach ($users as $user) {
    	$q = $db->prepare('INSERT INTO notifications(place_id,subject_id ,user_id,post_id,type,created_at)
                         VALUES(:place_id,:subject_id ,:user_id,:post_id,:type, NOW())');
                $q->execute([
                'place_id' =>get_session('pl_i'),
                'user_id' =>get_session('user_id'),
                'subject_id'=>$user->poster_id,
                'post_id'=>$postId,
                'type' => "place_admin_has_commented"             
]);
    }*/



echo pdisplay_comment(get_session('pl_i'),$postId,$user_id,$creator_id);