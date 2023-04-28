<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');



if (get_session('user_id')) {
        
	
      $q= $db->prepare('DELETE FROM forum_members
	 	            WHERE forum_id = :forum_id AND user_id = :user_id');
         $q->execute([
         	'etat'=>1,
         	'forum_id'=>get_session('fr_i'),
         	'user_id'=>$_GET['m_id']
			]);

    $q= $db->prepare('DELETE FROM forum_notifications
	 	            WHERE poster_id = :poster_id AND forum_id = :forum_id AND type = :type');
         $q->execute([
            'seen'=>1,
            'poster_id'=>$_GET['m_id'],
            'forum_id'=>get_session('fr_i'),
            'type'=>'demande de rejoindre'
            
			]);
    if($_GET['device'])
    {
        if($_GET['lang'])
        {
            redirect('android/fr/homeforum.php?name='.get_session('fr_n')); 
        }else{
            redirect('android/homeforum.php?name='.get_session('fr_n')); 
        }  
    }
	 redirect('homeforum.php?name='.get_session('fr_n'));
}else{
	redirect('profile.php?id='.get_session('user_id'));
}