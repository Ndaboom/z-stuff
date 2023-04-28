<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');



if (get_session('user_id')) {
        
	// Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(place_id, subject_id,name,user_id)
                         VALUES(:place_id,:subject_id,:name,:user_id)');
                $q->execute([
                'place_id' =>get_session('pl_i'),
                'subject_id' =>get_session('cr_i'),
                'name' => "newOrders",
                'user_id'=>get_session('user_id')  
                ]);
      $q= $db->prepare('UPDATE place_orders
	 	            SET is_send = :is_send
	 	            WHERE place_id = :place_id AND user_id = :user_id');
         $q->execute([
         	'is_send'=>1,
         	'place_id'=>get_session('pl_i'),
         	'user_id'=>get_session('user_id')
			]);

   $q=$db->prepare("INSERT INTO place_notifications(poster_id,content,place_name,place_id,seen,posted_at)
                     VALUES(:poster_id,:content,:place_name,:place_id,:seen,NOW())
		            ");
	$q->execute([
		'poster_id'=>get_session('user_id'),
		'content'=>"newOrders",
		'place_name'=>get_session('pl_n'),
		'place_id'=>get_session('pl_i'),
		'seen'=>0
	]);
	$_SESSION['is_send']="Orders sent successfully";
         
	redirect('homeplace.php?pl_i='.get_session('pl_i'));
}else{
	redirect('index.php');
}