<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');

if (!empty($_GET['id'])) {

	
    if (user_has_already_liked_the_micropost($_GET['id'])) {
       unlike_micropost($_GET['id']);
    }
	
    
}
redirect('fil.php?id='.get_session('user_id'));
