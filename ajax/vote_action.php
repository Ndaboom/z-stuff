<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
if(get_session('user_id')){
extract($_POST);

if($action == 'vote'){
	if (!user_has_already_vote(get_session('user_id'),$session_id,$event_id)) {
	    if(is_user_activated_email($_SESSION['user_id'])){
       		user_vote_action(get_session('user_id'),$event_id,$session_id,$candidate_id);
	    }
    }
}else{
	 if (user_has_already_vote(get_session('user_id'),$session_id,$event_id)) {
	     if(is_user_activated_email($_SESSION['user_id'])){
       		unvote_candidate(get_session('user_id'),$event_id,$session_id,$candidate_id);
	     }
    }

}
}