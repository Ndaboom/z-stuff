<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';

extract($_POST);
if($action == 'like'){
    echo "Action is ".$action;
	if (!user_has_already_liked_the_channel($channel_id)) {
        channel_likes($action);
        echo "Liked".$action;
    }else{
        echo "Didn't already liked";
        channel_likes("neutral");
    }
    echo "There must be an error";
    exit();
}elseif($action == 'unlike'){
	 if (user_has_already_liked_the_channel($channel_id)) {
        channel_likes($action);
     }else{
        channel_likes("neutral");
     }
}