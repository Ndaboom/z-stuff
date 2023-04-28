<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);

if (get_session('user_id')) {
		
	$id=$_GET['id'];
	$q =$db-> prepare(
		               'INSERT INTO forum_members(user_id,forum_id,etat)
		               VALUES(:user_id,:forum_id,:etat)');

	$q->execute([
		'user_id'=>get_session('user_id'),
		'forum_id'=>$forum_id,
		'etat'=>0
	]);
	// Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO forum_notifications(poster_id, type, forum_id,seen,posted_at)
                         VALUES(:poster_id, :type, :forum_id, :seen,NOW())');
                $q->execute([
                'poster_id' =>get_session('user_id'),
                'type' => 'demande de rejoindre',
                'forum_id' => $forum_id,
                'seen'=>0
]);
     $q = $db->prepare('SELECT creator_id 
     	                FROM forums 
     	                WHERE id= :forum_id');
     $q->execute([
     'forum_id' =>$forum_id
     ]);
     $data=$q->fetch(PDO::FETCH_OBJ);
     $q->closeCursor();

     $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id,forum_id)
                         VALUES(:subject_id, :name, :user_id,:forum_id)');
                $q->execute([
                'subject_id' => $data->creator_id,
                'name' => 'join_forum_request',
                'user_id'=> get_session('user_id'),
                'forum_id'=> $forum_id
                ]);
     echo($data->creator_id);

}