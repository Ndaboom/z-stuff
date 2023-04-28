<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("bootsrap/locale.php");

if(!empty(get_session('user_id'))){

    $user = find_user_by_id(get_session('user_id'));
    $user2 = selectUserProfilePic(get_session('user_id'));

    if(!$user){
      redirect('index.php');
    }
}


   $req = $db->prepare("SELECT *
                        FROM notifications
                        WHERE subject_id= :subject_id");
   $req->execute([
               'subject_id'=>get_session('user_id')
             ]);
   $req->fetchAll(PDO::FETCH_OBJ);

  $nbre_total_notifications = $req->rowCount();

  if ($nbre_total_notifications>=1) {
    $nbre_notifications_par_page = 8;

  $nbre_pages_max_gauche_et_droite = 4;

  $last_page = ceil($nbre_total_notifications / $nbre_notifications_par_page);

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

  $limit = 'LIMIT '.($page_num - 1) * $nbre_notifications_par_page. ',' . $nbre_notifications_par_page;

  $q=$db->prepare("SELECT *
                  FROM notifications
                  WHERE subject_id= :subject_id
                  ORDER BY created_at DESC $limit");
    $q->execute([
               'subject_id'=>get_session('user_id')
             ]);
    $notifications=$q->fetchAll(PDO::FETCH_OBJ);
    $q->closeCursor();


  $pagination = '<nav class="text-center">
                 <ul class="pagination">';

  if($last_page != 1){
    if($page_num > 1){
      $previous = $page_num - 1;
      $pagination .= '<li><a href="notifications.php?page='.$previous.'">Précédent</a></li>';

      for($i = $page_num - $nbre_pages_max_gauche_et_droite; $i < $page_num; $i++){
        if($i > 0){
          $pagination .= '<li><a href="notifications.php?page='.$i.'">'.$i.'</a></li>';
        }
      }
    }

    $pagination .= '<li class="active"><a href="">'.$page_num.'</a></li>&nbsp;';

    for($i = $page_num+1; $i <= $last_page; $i++){
      $pagination .= '<li><a href="notifications.php?page='.$i.'">'.$i.'</a></li>';

      if($i >= $page_num + $nbre_pages_max_gauche_et_droite){
        break;
      }
    }

    if($page_num != $last_page){
      $next = $page_num + 1;
      $pagination .= '<li><a href="notifications.php?page='.$next.'">Suivant</a></li>';
    }
  }
  $pagination .='</ul></nav>';




  }
$q = $db->prepare("UPDATE notifications SET seen = '1' WHERE subject_id = ?");
$q->execute([get_session('user_id')]);

require("views/notifications.view.php");
