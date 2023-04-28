<?php
session_start();
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

if(get_session('user_id'))
{
$q =$db->prepare('INSERT INTO microposts(legend,user_id,place_id,type,created_at)
	                  VALUES (:content,:user_id,:place_id,:type,NOW())');
	    $q->execute([
           'content'=>"",
           'user_id'=> $_SESSION['user_id'],
           'place_id'=>$_SESSION['pl_i'],
           'type'=>"shared_a_place" //If forwaded the value will be one
	    ]);

	    $q->closecursor();

   // set_flash('Page shared successfully');
    redirect('homeplace.php?pl_i='.get_session('pl_i'));
}
else
{
    redirect('login.php');
}
