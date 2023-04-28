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

$localization = $_POST['city'].', '.$_POST['country'];

if(not_empty(['event_name','organization', 'city', 'country'])){
   
$q=$db->prepare('INSERT INTO events(event_name,description,organization,localization,start_date,participation,creator_id)
                   VALUES(:event_name,:description,:organization,:localization,:start_date,:participation,:creator_id)');
  $q->execute([
  'event_name'=> $event_name,
  'description'=>$description,
  'organization' =>$organization,
  'localization' => $localization,
  'start_date' => $start_date,
  'participation' => $participation,
  'creator_id' => $_SESSION['user_id']
  ]);
  $q->closecursor(); 
  
  $last_id = $db->lastInsertId();
  
  redirect('event_home.php?n='.$event_name.'&ev_i='.$last_id);
}else{
  echo "please fill in all the fields";
}

}

require("views/v2/create-event.view.php"); 
?>
