<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
    
    $user=find_user_by_id($_SESSION['user_id']);
    $user2=selectUserProfilePic($_SESSION['user_id']);
    $cover=selectCurrentPlaceCover($_GET['pl_i']);


   $req = $db->prepare("SELECT urlimage,add_at FROM placepictures WHERE place_id= :place_id");
   $req->execute([
               'place_id'=>$_GET['pl_i']
             ]);
   $req->fetchAll(PDO::FETCH_OBJ);

  $nbre_total_images = $req->rowCount();

  if ($nbre_total_images>=1) {
    $nbre_images_par_page = 8;

  $nbre_pages_max_gauche_et_droite = 4;

  $last_page = ceil($nbre_total_images / $nbre_images_par_page);

  if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page_num = $_GET['page'];
  } else {
    $page_num = 1;
  }

  if($page_num < 1){
    $page_num = 1;
  } else if($page_num > $last_page) {
    $page_num = $last_page;
  }

  $limit = 'LIMIT '.($page_num - 1) * $nbre_images_par_page. ',' . $nbre_images_par_page;

  $q=$db->prepare("SELECT urlimage,description,add_at FROM placepictures WHERE place_id= :place_id ORDER BY add_at $limit");
    $q->execute([
               'place_id'=>$_GET['pl_i']
             ]);
    $placegallery=$q->fetchAll(PDO::FETCH_OBJ);
    $q->closeCursor();


  $pagination = '<nav class="text-center">
                 <ul class="pagination">';

  if($last_page != 1){
    if($page_num > 1){
      $previous = $page_num - 1;
      $pagination .= '<li><a href="placegallery.php?page='.$previous.'">Précédent</a></li>';

      for($i = $page_num - $nbre_pages_max_gauche_et_droite; $i < $page_num; $i++){
        if($i > 0){
          $pagination .= '<li><a href="placegallery.php?page='.$i.'">'.$i.'</a></li>';
        }
      }
    }

    $pagination .= '<li class="active"><a href="">'.$page_num.'</a></li>&nbsp;';

    for($i = $page_num+1; $i <= $last_page; $i++){
      $pagination .= '<li><a href="placegallery.php?page='.$i.'">'.$i.'</a></li>';
      
      if($i >= $page_num + $nbre_pages_max_gauche_et_droite){
        break;
      }
    }

    if($page_num != $last_page){
      $next = $page_num + 1;
      $pagination .= '<li><a href="placegallery.php?page='.$next.'">Suivant</a></li>';
    }
  }
  $pagination .='</ul></nav>';




  }

//Pagination pour les photos de couverture 
$req1 = $db->prepare("SELECT urlimage,add_at FROM place_covers WHERE place_id= :place_id");
   $req->execute([
               'place_id'=>$_GET['pl_i']
             ]);
   $req1->fetchAll(PDO::FETCH_OBJ);

  $nbre_total_imgCovers = $req1->rowCount();

  if ($nbre_total_imgCovers>=1) {
    $nbre_imgc_par_page = 8;

  $nbre_pages_max_gauche_et_droite = 4;

  $last_page1 = ceil($nbre_total_imgCovers / $nbre_imgc_par_page);

  if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page_num = $_GET['page'];
  } else {
    $page_num = 1;
  }

  if($page_num < 1){
    $page_num = 1;
  } else if($page_num > $last_page1) {
    $page_num = $last_page1;
  }

  $limit1 = 'LIMIT '.($page_num - 1) * $nbre_imgc_par_page. ',' . $nbre_imgc_par_page;

  $q=$db->prepare("SELECT urlimage,add_at FROM place_covers 
                     WHERE place_id= :place_id ORDER BY add_at $limit1");
    $q->execute([
      'place_id'=> $_GET['pl_i']
    ]);
    $pictureposted=$q->fetchAll(PDO::FETCH_OBJ);
    $q->closecursor();


  $pagination1 = '<nav class="text-center">
                 <ul class="pagination">';

  if($last_page1 != 1){
    if($page_num > 1){
      $previous = $page_num - 1;
      $pagination1 .= '<li><a href="placegallery.php?page='.$previous.'">Précédent</a></li>';

      for($i = $page_num - $nbre_pages_max_gauche_et_droite; $i < $page_num; $i++){
        if($i > 0){
          $pagination1 .= '<li><a href="placegallery.php?page='.$i.'">'.$i.'</a></li>';
        }
      }
    }

    $pagination1 .= '<li class="active"><a href="">'.$page_num.'</a></li>&nbsp;';

    for($i = $page_num+1; $i <= $last_page1; $i++){
      $pagination1 .= '<li><a href="placegallery.php?page='.$i.'">'.$i.'</a></li>';
      
      if($i >= $page_num + $nbre_pages_max_gauche_et_droite){
        break;
      }
    }

    if($page_num != $last_page1){
      $next = $page_num + 1;
      $pagination1 .= '<li><a href="placegallery.php?page='.$next.'">Suivant</a></li>';
    }
  }
  $pagination1 .='</ul></nav>';




  }
$q = $db->prepare("SELECT * 
                 FROM places
                 WHERE id= :id
                 ");
 $q->execute([
      'id'=> $_GET['pl_i']
    ]);
$places = $q->fetch(PDO::FETCH_OBJ);
$q->closecursor();
$_SESSION['pl_i']=$places->id;
$_SESSION['cr_i']=$places->creator_id;
$_SESSION['pl_n']=$places->place_name;



//Fin pagination de photo couverture
  

  
require("views/placegallery.view.php");