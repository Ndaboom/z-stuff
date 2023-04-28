<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');



if (get_session('user_id')){
	
	$q=$db->prepare("INSERT INTO place_notifications(poster_id,content,place_name,place_id,seen,posted_at)
                     VALUES(:poster_id,:content,:place_name,:place_id,:seen,NOW())
		            ");
	$q->execute([
		'poster_id'=>get_session('user_id'),
		'content'=>"Aime votre photo",
		'place_name'=>get_session('pl_n'),
		'place_id'=>get_session('pl_i'),
		'seen'=>0
	]);
	$q->closecursor();
	redirect('homeplace.php?name='.get_session('pl_n'));
	
}