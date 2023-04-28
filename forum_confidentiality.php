<?php 
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');
require("bootsrap/locale.php");

	if(isset($_POST['save_confidentialies'])){
  extract($_POST);

if(not_empty(['sharing','membersVisibility','subjectsVisibility'])){

	$q= $db->prepare('UPDATE forums
	 	            SET sharing = :sharing,
	 	                subjectsVisibility= :subjectsVisibility,
	 	                membersVisibility= :membersVisibility
	 	            WHERE id = :forum_id');
         $q->execute([
         	'sharing'=> $sharing,
            'subjectsVisibility'=>$subjectsVisibility,
            'membersVisibility'=>$membersVisibility,
            'forum_id'=>get_session('fr_i')
			]);
   $_SESSION['creator_id']=$_SESSION['user_id'];
   redirect('homeforum.php?name='.get_session('fr_n'));
}else{
  echo "please fill in all the fields";
}

}

	
