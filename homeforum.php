<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
    
    $user=find_user_by_id($_SESSION['user_id']);
    $user2=selectUserProfilePic($_SESSION['user_id']);
    $forum=selectCurrentForumData();
    
  if(isset($_POST['insert'])){
  extract($_POST);

if(not_empty(['forum_name','description'])){

	$q= $db->prepare('UPDATE forums
	 	            SET forum_name = :forum_name,
	 	                description= :description
	 	            WHERE id = :forum_id');
         $q->execute([
         	'forum_name'=> $forum_name,
            'description'=>$description,
            'forum_id'=>get_session('fr_i')
			]);
   $_SESSION['creator_id']=$_SESSION['user_id'];
   redirect('homeforum.php?name='.get_session('fr_n'));
}else{
  echo "please fill in all the fields";
}

}

   

if(is_already_in($forum->id)){  
    require("views/homeforum.view.php");
}else{
    redirect('forum_details.php?name='.$forum->forum_name);
}