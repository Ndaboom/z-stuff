<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

if(!empty($_POST['poster']))
{

  if($_POST['sub_type'] != "quotes")
  {
$q =$db->prepare('INSERT INTO microposts(legend,user_id,urlMedia,type,from_user_id,content_id,sub_type,created_at)
                     VALUES (:content,:user_id,:urlMedia,:type,:from_user_id,:content_id,:sub_type,NOW())');
   $q->execute([
      'content'=>$_POST['legend'],
      'user_id'=> $_SESSION['user_id'],
      'urlMedia'=>$_POST['media'],
      'type'=> "shared_post",
      'from_user_id'=>$_POST['poster'],
      'content_id'=>$_POST['postid'],
      'sub_type'=>$_POST['sub_type']
   ]);
 }else{

   $q =$db->prepare('INSERT INTO microposts(legend,user_id,urlMedia,quote_author,type,from_user_id,content_id,sub_type,created_at)
                        VALUES (:content,:user_id,:urlMedia,:quote_author,:type,:from_user_id,:content_id,:sub_type,NOW())');
      $q->execute([
         'content'=>$_POST['legend'],
         'user_id'=> $_SESSION['user_id'],
         'urlMedia'=>$_POST['media'],
         'quote_author'=>$_POST['quote_author'],
         'type'=> "shared_post",
         'from_user_id'=>$_POST['poster'],
         'content_id'=>$_POST['postid'],
         'sub_type'=>$_POST['sub_type']
      ]);

 }

   $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id,post_id)
                         VALUES(:subject_id, :name, :user_id, :post_id)');
                $q->execute([
                'subject_id' => $_POST['poster'],
                'name' => 'shared_your_post',
                'user_id' => get_session('user_id'),
                'post_id' => $_POST['postid']
                ]);
}
