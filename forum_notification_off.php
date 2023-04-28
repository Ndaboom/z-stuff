<?php 
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');

if(get_session('user_id')){

	$q= $db->prepare('UPDATE forum_notifications
	 	            SET seen = :seen
	 	            WHERE forum_id = :forum_id');
         $q->execute([
            'seen'=>1,
            'forum_id'=>get_session('fr_i')
			]);
   $_SESSION['creator_id']=$_SESSION['user_id'];
   redirect('homeforum.php?name='.get_session('fr_n'));
}

