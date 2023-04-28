<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');
if(!empty($_GET['id'])){
$q = $db->prepare('SELECT * FROM microposts WHERE id = :id');
$q->execute([
    'id' => $_GET['id']
   ]);

$data = $q->fetch(PDO::FETCH_OBJ);
$user_id = $data->user_id;

if($user_id == get_session('user_id'))
  {
   $q = $db->prepare('DELETE FROM microposts WHERE id = :id');
   $q->execute([
   'id' => $_GET['id']
   ]);
   }
   if(!empty($_GET['path'] && $data->from_user_id == ""))
   {
   unlink($_GET['path']);
   }
  }
redirect('profile.php?id='.get_session('user_id'));
