<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);
if(!already_satisfied($reaction_id)){
 $q=$db->prepare('INSERT INTO reaction_like(user_id, reaction_id,forum_id,type)
		             VALUES(:user_id, :reaction_id, :forum_id,:type)');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'reaction_id'=> $reaction_id,
                 'forum_id'=>get_session('fr_i'),
                 'type'=>"satisfied"
	           ]);
}

echo display_validations($reaction_id);