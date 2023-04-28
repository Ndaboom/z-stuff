<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);

if($action == 'like'){
	if (! user_has_already_liked_the_micropost($micropost_id)) {
       like_micropost($micropost_id);
       if(get_session('user_id') != $poster)
       {
       	 // Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id,post_id)
                         VALUES(:subject_id, :name, :user_id,:post_id)');
                $q->execute([
                'subject_id' => $poster,
                'name' => 'liked_post',
                'user_id' => get_session('user_id'),
                'post_id' => $postid
                ]);
       }
      
    }
}else{
	 if (user_has_already_liked_the_micropost($micropost_id)) {
       unlike_micropost($micropost_id);
    }

}
