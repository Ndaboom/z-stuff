<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);

if($action == 'like'){
	if (!user_has_already_liked_the_placepost($placepost_id)) {
       like_placepost($placepost_id);
    }
}else{
	 if (user_has_already_liked_the_placepost($placepost_id)) {
       unlike_placepost($placepost_id);
    }

}
echo pdisplay_likers($placepost_id);