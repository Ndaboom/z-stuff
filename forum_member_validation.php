<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');



if (get_session('user_id')) {
        
	// Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(forum_id, subject_id,name,created_at)
                         VALUES(:forum_id, :subject_id,:name, NOW())');
                $q->execute([
                'forum_id' =>get_session('fr_i'),
                'subject_id' =>$_GET['m_id'],
                'name' => "forum request accepted"             
]);
      $q= $db->prepare('UPDATE forum_members
	 	            SET etat = :etat
	 	            WHERE forum_id = :forum_id AND user_id = :user_id');
         $q->execute([
         	'etat'=>1,
         	'forum_id'=>get_session('fr_i'),
         	'user_id'=>$_GET['m_id']
         	
            
			]);

    $q= $db->prepare('UPDATE forum_notifications
	 	            SET seen = :seen
	 	            WHERE poster_id = :poster_id AND forum_id = :forum_id AND type = :type');
         $q->execute([
            'seen'=>1,
            'poster_id'=>$_GET['m_id'],
            'forum_id'=>get_session('fr_i'),
            'type'=>'demande de rejoindre'
            
			]);
         
	redirect('homeforum.php?name='.get_session('fr_n'));
}else{
	redirect('profile.php?id='.get_session('user_id'));
}