<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
    
    $user = find_user_by_id($_SESSION['user_id']);
    $user2 = find_user_by_id($_SESSION['user_id']);
    $forum = get_forum_name($_GET['fr_i']);
    
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
   redirect('forum_home.php?name='.get_session('fr_n').'&fr_i='.get_session('fr_i'));
}else{
  echo "please fill in all the fields";
}

}

   

if(is_already_in($_GET['fr_i'])){  
    require("views/v2/forum_home.view.php");
}else{
    redirect('/forums.php?name='.$_GET['n']);
}
