<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");


if(!empty($_GET['id'])){
    $user=find_user_by_id($_GET['id']);
    $user2=selectUserProfilePic($_GET['id']);
    

    if(!$user){
    	redirect('index.php');
    }
}else{
	redirect('list_forums.php?id='.get_session('user_id'));
}

if(isset($_POST['insert'])){
extract($_POST);

if(not_empty(['forum_name','description'])){
$q=$db->prepare('INSERT INTO forums(forum_name,description,creator_id)
                   VALUES(:forum_name,:description,:creator_id)');
  $q->execute([
  'forum_name'=> $forum_name,
  'description'=>$description,
  'creator_id' =>$_SESSION['user_id'],
  
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


   redirect('homeforum.php?name='.$forum_name);
}else{
  echo "please fill in all the fields";
}

}

$q = $db->prepare("SELECT id,forum_name,description,created_at,forum_pic,subjectsVisibility 
	               FROM forums
	               WHERE creator_id !=:user_id");
$q->execute([
    'user_id'=>get_session('user_id')
]);
$forums = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$myforums = forum_where_user_is();
require("views/list_forums.view.php");
