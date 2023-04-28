<?php 
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

$data = array(
                ':post_id'    =>$_POST["postId"],
                ':user_id'    =>$_SESSION["user_id"],
                ':comment'    =>$_POST["content"]
	 	);
	 	$query = "
          INSERT INTO comments(post_id,user_id,comment)
          VALUES(:post_id, :user_id, :comment)
	 	";
	 	$statement = $db->prepare($query);
	 	$statement->execute($data);

    if(get_session('user_id') != $poster)
       {
         // Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(subject_id, name,type, user_id,post_id)
                         VALUES(:subject_id, :name,:type ,:user_id,:post_id)');
                $q->execute([
                'subject_id' => $poster,
                'name' => 'has_commented',
                'type' =>$_POST["content"],
                'user_id' => get_session('user_id'),
                'post_id' => $_POST["postId"]
                ]);
       }
