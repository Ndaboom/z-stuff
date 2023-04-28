<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");

if (isset($_POST['publish'])) {
	//set_flash('Statut added successfully');
	   extract($_POST);
	   $dir='files/';
	   $file_path = $dir.basename($_FILES['ufile']['name']);
	   if(move_uploaded_file($_FILES['ufile']['tmp_name'],$file_path))
	   {
            $q =$db->prepare('INSERT INTO forum_subject(subject,poster_id,forum_id,type,urlmedia1,created_at)
                     VALUES (:subject,:poster_id,:forum_id,:type,:urlmedia1,NOW())');
            $q->execute([
            'subject'=>$content,
            'poster_id'=>get_session('user_id'),
            'forum_id'=>get_session('fr_i'),
            'type'=>"file_post",
            'urlmedia1'=>$file_path
            ]);
            $q->closecursor();
            
            //Recuperation de tout les membres du forum en session
            $q =$db->prepare('SELECT user_id FROM forum_members
                      WHERE forum_id= :forum_id AND user_id != :user_id
                    ');
            $q->execute([
                   'forum_id'=>get_session('fr_i'),
                   'user_id'=>get_session('user_id')
               ]);
                $users= $q->fetchAll(PDO::FETCH_OBJ);
                $q->closecursor(); 
            //Signalement a tout le membre du nouveau post
            foreach($users as $row)
            {
            $q=$db->prepare('INSERT INTO new_forum_post(user_id,forum_id,seen)
                     VALUES(:user_id,:forum_id,:seen)');
            $q->execute([
            'user_id'=>$row->user_id,
            'forum_id'=>get_session('fr_i'),
            'seen'=>0
                 ]);
            }
	   }
	   
       if($_GET['device']=="mobile"){
        redirect('mobile/homeforum.php?name='.get_session('fr_n'));    
        }elseif($_GET['device']=="android")
        {
        redirect('android/homeforum.php?name='.get_session('fr_n'));    
        }else{
		redirect('homeforum.php?name='.get_session('fr_n'));	
        }
}
        if($_GET['device']=="mobile"){
        redirect('mobile/homeforum.php?name='.get_session('fr_n'));    
        }elseif($_GET['device']=="android")
        {
        redirect('android/homeforum.php?name='.get_session('fr_n'));    
        }else{
		redirect('homeforum.php?name='.get_session('fr_n'));	
        }
