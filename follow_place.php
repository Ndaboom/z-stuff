<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');



if (get_session('user_id')){
	
	$id=$_GET['id'];
	$q =$db-> prepare(
		               'INSERT INTO places_followers(place_id,user_id,status)
		               VALUES(:place_id,:user_id,:status)');

	$q->execute([
		'place_id'=>$_SESSION['pl_i'],
		'user_id'=>get_session('user_id'),
		'status'=>1
		
	]);
	$q->closecursor();

	$q=$db->prepare("INSERT INTO place_notifications(poster_id,content,place_name,place_id,seen,posted_at)
                     VALUES(:poster_id,:content,:place_name,:place_id,:seen,NOW())
		            ");
	$q->execute([
		'poster_id'=>get_session('user_id'),
		'content'=>"you have 1 follower",
		'place_name'=>get_session('pl_n'),
		'place_id'=>get_session('pl_i'),
		'seen'=>0
	]);

	 $q = $db->prepare('INSERT INTO notifications(place_id,subject_id ,user_id,type,created_at)
                         VALUES(:place_id,:subject_id ,:user_id,:type, NOW())');
                $q->execute([
                'place_id' =>get_session('pl_i'),
                'user_id' =>get_session('user_id'),
                'subject_id'=>get_session('cr_i'),
                'type' => "A commence a suivre votre place "             
				]);
	redirect('homeplace.php?pl_i='.get_session('pl_i'));
	/*set_flash('Your request has been sent with success');
	redirect('profile.php?id='.$id);*/
}/*else{
	set_flash('Cet utilsateur vous a deja envoye une demande...');
	redirect('profile.php?id='.$_GET['id']);
}
}else{
	redirect('profile.php?id='.get_session('user_id'));
}*/