<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if (get_session('user_id')) {
	if(!forum_state_verification_v1(get_session('user_id'),'1',$fr_i))
	{
	    
	    $q =$db-> prepare(
		               'INSERT INTO forum_members(user_id,forum_id,etat)
		               VALUES(:user_id,:forum_id,:etat)');

	    $q->execute([
		'user_id'=>get_session('user_id'),
		'forum_id'=>$fr_i,
		'etat'=>0
	    ]);
	    // Sauvegarde de la notification
        $q = $db->prepare('INSERT INTO forum_notifications(poster_id, type, forum_id,seen,posted_at)
                         VALUES(:poster_id, :type, :forum_id, :seen,NOW())');
                $q->execute([
                'poster_id' =>get_session('user_id'),
                'type' => 'demande de rejoindre',
                'forum_id' => $fr_i,
                'seen'=>0
                ]);
	    
	}
}
