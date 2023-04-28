<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');

if(get_session('user_id')== get_session('cr_i')){
	$q =$db-> prepare(
		               'UPDATE places 
		                SET place_privacy= :place_privacy
		               WHERE id= :place_id');

	$q->execute([
		'place_privacy'=>0,
		'place_id'=>get_session('pl_i')
	]);
	if($_GET['device']=="mobile"){
	 redirect('mobile/placegallery.php?pl_i='.get_session('pl_i'));   
	}elseif($_GET['device']=="android"){
	 redirect('android/placegallery.php?pl_i='.get_session('pl_i'));     
	}else{
	    redirect('placegallery.php?pl_i='.get_session('pl_i'));
	}
}else{
    echo "Only the admin can proceed to that action";
}	

