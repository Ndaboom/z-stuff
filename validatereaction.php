<?php 
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
    
    $user=find_user_by_id($_SESSION['user_id']);
    $user2=selectUserProfilePic($_SESSION['user_id']);
    $forums=selectCurrentForumData();
    $reactions=getAllUserForumReaction();
    
    if(get_session('user_id')){
    $q=$db->prepare('INSERT INTO reaction_like(user_id, reaction_id,forum_id,type)
		             VALUES(:user_id, :reaction_id,:forum_id ,:type)');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'reaction_id'=> $_GET['re_id'],
                 'forum_id'=>get_session('fr_i'),
                 'type'=>"valide"
	           ]);
    
	$q=$db->prepare('UPDATE forum_reactions 
		             SET like_count= like_count+1 
		             WHERE id= :reaction_id');
	   $q->execute([
           'reaction_id'=>$_GET['re_id']
	   ]);
       $q->closecursor();

//Ajout d'une notification
   /* $q=$db->prepare('INSERT INTO notifications(user_id, reaction_id,type)
		             VALUES(:user_id, :reaction_id, :type)');
	$q->execute([
                 'user_id'=>get_session('user_id'),
                 'reaction_id'=> $_GET['re_i'],
                 'type'=>"valide"
	           ]);*/
    }else{
       redirect('inscription.php');
    	    }
