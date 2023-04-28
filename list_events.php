<?php
session_start();
require('includes/functions.php');
require('config/database.php'); 
require("bootsrap/locale.php");

$q=$db->prepare('SELECT * FROM events');
$q->execute();
$forums = $q->fetch(PDO::FETCH_OBJ);
$q->closeCursor(); 

if(isset($_POST['insert'])){
extract($_POST);

if(not_empty(['event_name','description'])){
$q=$db->prepare('INSERT INTO events(event_name,description,coverpic,creator_id,created_at)
                   VALUES(:event_name,:description,:coverpic,:creator_id,NOW())');
  $q->execute([
  'event_name'=> $event_name,
  'description'=>$description,
  'coverpic'=>"images/cover.jpeg",
  'creator_id' =>$_SESSION['user_id']
  ]);
  $q->closecursor();
  $_SESSION['ev_n']=$event_name;
  $q->closeCursor(); 

$q=$db->prepare('SELECT * FROM events WHERE event_name=?');
  $q->execute([$event_name]);
    $data=$q->fetch(PDO::FETCH_OBJ);
    $q->closeCursor();  

    $event_id=$data->id;    
        
 

  $q =$db-> prepare(
                   'INSERT INTO event_followers(event_id,user_id)
                    VALUES(:event_id,:user_id)');

  $q->execute([
    'event_id'=>$event_id,
    'user_id'=>get_session('user_id')
  ]);
   redirect('homeevent.php?name='.$event_name);
}else{
    redirect('homeevent.php?name='.$event_name);
}

}
require('views/list_events.view.php');