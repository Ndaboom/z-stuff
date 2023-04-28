<?php 
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');

if(get_session('user_id')== get_session('cr_i')){
	$q =$db-> prepare(
		               'UPDATE places 
		                SET marketplace_State= :marketplace_state
		               WHERE id= :place_id');

	$q->execute([
		'marketplace_state'=>0,
		'place_id'=>get_session('pl_i')
	]);
	redirect('homeplace.php?pl_i='.get_session('pl_i'));
}	
	