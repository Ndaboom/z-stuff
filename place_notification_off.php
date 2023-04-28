<?php 
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');

if(get_session('user_id')){

	$q= $db->prepare('UPDATE place_notifications
	 	            SET seen = :seen
	 	            WHERE place_id = :place_id');
         $q->execute([
            'seen'=>1,
            'place_id'=>get_session('pl_i')
			]);
   redirect('homeplace.php?pl_i='.get_session('pl_i').'#all_post');
}