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
		               'DELETE  FROM event_followers
		               WHERE event_id = :event_id AND user_id = :user_id');

	$q->execute([
		'event_id'=>get_session('ev_i'),
		'user_id'=>$id
	]);
	redirect('homeevent.php?ev_i='.get_session('ev_i'));
 }