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
	redirect('place.php?id='.get_session('user_id'));
}

$q = $db->prepare("SELECT *
                   FROM places
                   WHERE creator_id != :user_id
                   LIMIT 3");
$q->execute([
     'user_id'=>get_session('user_id')
 ]);
$places = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

if(isset($_POST['insert'])){
extract($_POST);

if(not_empty(['place_name','description','category'])){
  
$q=$db->prepare('INSERT INTO places(place_name,description,category,creator_id)
                   VALUES(:place_name,:description,:category,:creator_id)');
  $q->execute([
  'place_name'=> $place_name,
  'description'=>$description,
  'category'   =>$category,
  'creator_id' =>$_SESSION['user_id'],
  
  ]);

  $query="
             SELECT * FROM places
        ";
            $statement= $db->prepare($query);
            $statement->execute();

  $nbre_places=$statement->rowCount();
  $q->closecursor();
   $_SESSION['pl_n']=$place_name;
  $q=$db->prepare('SELECT id
                     FROM places
                     WHERE place_name= :place_name
                     ');
    $q->execute([
      'place_name'=>$place_name]);
    $place_id=$q->fetch(PDO::FETCH_OBJ);
    $q->closeCursor();
    $_SESSION['react_id']=$_GET['rid'];
   $_SESSION['pl_n']=$place_name;
   $_SESSION['creator_id']=$_SESSION['user_id'];
   redirect('homeplace.php?pl_i='.$place_id->id);
}else{
  echo "please fill in all the fields";
}

}



require("views/place.view.php");