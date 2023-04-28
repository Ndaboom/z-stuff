<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);
if (get_session('user_id')) {
        
	// Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(forum_id, subject_id,name,created_at)
                         VALUES(:forum_id, :subject_id,:name, NOW())');
                $q->execute([
                'forum_id' =>$forum_id,
                'subject_id' =>$user_id,
                'name' => "forum request accepted"             
                ]);
      $q= $db->prepare('UPDATE forum_members
	 	            SET etat = :etat
	 	            WHERE forum_id = :forum_id AND user_id = :user_id');
         $q->execute([
         	'etat'=>1,
         	'forum_id'=>$forum_id,
         	'user_id'=>$user_id
         	
            
			]);

    $q= $db->prepare('UPDATE forum_notifications
	 	            SET seen = :seen
	 	            WHERE poster_id = :poster_id AND forum_id = :forum_id AND type = :type');
         $q->execute([
            'seen'=>1,
            'poster_id'=>$user_id,
            'forum_id'=>$forum_id,
            'type'=>'demande de rejoindre'
            
			]);
}