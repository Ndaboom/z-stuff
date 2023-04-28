<?php 
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
    $user=find_user_by_id($_SESSION['user_id']);
    $user2=selectUserProfilePic($_SESSION['user_id']);
    $forums=selectCurrentForumData();
    $reactions=getAllUserForumReaction();

    $q=$db->prepare('SELECT U.name,F.poster_id,F.subject,F.id
                     FROM forum_subject F,users U
                     WHERE U.id=F.poster_id
                     AND F.id= :id');
    $q->execute([
      'id'=>$_GET['rid']]);
    $poster_data=$q->fetch(PDO::FETCH_OBJ);
    $q->closeCursor();
    $_SESSION['react_id']=$_GET['rid'];

   
require("views/morereaction.view.php");