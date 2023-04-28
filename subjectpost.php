<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

if(isset($_POST['publish'])){

	if(!empty($_POST['content'])){
		extract($_POST);
        $q =$db->prepare('INSERT INTO forum_subject(subject,poster_id,forum_id,type,created_at)
	                 VALUES (:subject,:poster_id,:forum_id,:type,NOW())');
	    $q->execute([
           'subject'=>$content,
           'poster_id'=>get_session('user_id'),
           'forum_id'=>get_session('fr_i'),
           'type'=>"subject"
	    ]);
	    $q->closecursor();

	    redirect('homeforum.php?name='.get_session('fr_n'));
	    

	}

}