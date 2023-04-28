<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');

if(get_session('user_id'))
 {
 	$id=get_session('user_id');
	$q =$db-> prepare(
		               'DELETE  FROM places_followers
		               WHERE place_id = :place_id AND user_id = :user_id');

	$q->execute([
		'place_id'=>get_session('pl_i'),
		'user_id'=>$id
	]);
	redirect('homeplace.php?pl_i='.get_session('pl_i'));
 }