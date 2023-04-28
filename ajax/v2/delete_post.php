<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if($user_id == get_session('user_id'))
  {
  
   $q = $db->prepare('DELETE FROM microposts WHERE id = :id');
   $q->execute([
   'id' => $post_id
   ]);
   
   }
   
