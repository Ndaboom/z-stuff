<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user2 = find_user_by_id($_SESSION['user_id']);


if(isset($_POST['insert'])){
extract($_POST);

if(not_empty(['forum_name','description'])){
$q=$db->prepare('INSERT INTO forums(forum_name,description,subjectsVisibility,creator_id)
                   VALUES(:forum_name,:description,:subjectsVisibility,:creator_id)');
  $q->execute([
  'forum_name'=> $forum_name,
  'description'=>$description,
  'creator_id' =>$_SESSION['user_id'],
  'subjectsVisibility' => $privacy
  
  ]);
  $q->closecursor();
  $_SESSION['fr_n']=$forum_name;
  $q->closeCursor(); 

$q=$db->prepare('SELECT * FROM forums WHERE forum_name=?');
  $q->execute([$forum_name]);
    $data=$q->fetch(PDO::FETCH_OBJ);
    $q->closeCursor();  

    $forum_id=$data->id;    
        
 

  $q =$db-> prepare(
                   'INSERT INTO forum_members(user_id,forum_id,etat)
                    VALUES(:user_id,:forum_id,:etat)');

  $q->execute([
    'user_id'=>get_session('user_id'),
    'forum_id'=>$forum_id,
    'etat'=>1
    
  ]);


   redirect('forum_home.php?n='.$forum_name.'&fr_i='.$forum_id);
}else{
  echo "please fill in all the fields";
}

}

require("views/v2/create-forum.view.php"); 
?>
