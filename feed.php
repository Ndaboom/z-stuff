<?php

session_start();

include('filters/auth_filter.php');

require("includes/functions.php");

require("includes/adds_functions.php");
require("bootsrap/locale.php");
require("includes/init.php");

require("config/database.php");



if(!empty($_GET['id'])){



    $user=find_user_by_id($_GET['id']);

    $user2 = find_user_by_id($_SESSION['user_id']);

    $MeinsideF=forum_where_user_is();



    $q= $db->prepare('SELECT *

                  FROM home_msg

                  WHERE to_user_id= :to_user_id AND etat= :etat');

    $q->execute([

                 'to_user_id'=>get_session('user_id'),

                 'etat'=>0

                ]);

    $wishes=$q->fetchAll(PDO::FETCH_OBJ);

    

    $q= $db->prepare('SELECT id, user_id, compressed_img, posted_at, count(user_id) AS moments_nbr

                  FROM stories group by user_id');

    $q->execute();

    $stories_posters =$q->fetchAll(PDO::FETCH_OBJ);



    

    if($user->sex == "F" && $user->profilepic == "images/default.png")

    {

    $q = $db->prepare('UPDATE users 

                       SET profilepic= :profilepic

                       WHERE id= :user_id');

    $q->execute([

        'profilepic'=>"images/default_girl.png",

        'user_id'=>get_session('user_id')

        ]);

    }

    



    if(!$user){

    	redirect('index.php');

    }else{

      $my_forums=forum_where_user_is_admin();

      $MeinsideF=forum_where_user_is();

      $Places= places_followed_by_the_current_user(get_session('user_id'));

      

    	$q= $db->prepare('SELECT U.id user_id,U.name, U.nom2, U.email, U.profilepic,

                          M.id m_id, M.legend,M.user_id ,M.created_at, M.urlMedia, M.like_count

                          FROM users U, microposts M, friends_relationships F

                          WHERE M.user_id = U.id



                          AND



                          CASE

                          WHEN F.user_id1 = :user_id

                          THEN F.user_id2 = M.user_id



                          WHEN F.user_id2 = :user_id

                          THEN F.user_id1 = M.user_id

                          END



                          AND F.status > 0

                          ORDER BY M.id DESC');

    	$q->execute([

           'user_id'=>get_session('user_id')

    	]);

    	$microposts = $q->fetchAll(PDO::FETCH_OBJ);

    }

}else{

	redirect('feed.php?id='.get_session('user_id'));

}

$q = $db->prepare("SELECT id,name,city,country,profilepic FROM users 

                   WHERE active= :active AND id!= :id 

                   ORDER BY RAND()

                   LIMIT 10");

$q->execute([

           'active'=>1,

           'id'=>get_session('user_id')

      ]);

$users = $q->fetchAll(PDO::FETCH_OBJ);

 //Ads

if(!view_notif_covid(get_session('user_id'))){

  $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)

                   VALUES(:subject_id, :name, :user_id)');

                   $q->execute([

                   'subject_id' => get_session('user_id'),

                   'name' => 'covid_notif',

                   'user_id' => 1

                   ]);

}



  $city = $user->city;

  $country = $user->country;

  $profession = $user->profession;





  $q = $db->prepare("SELECT * FROM users 

                     WHERE city = :city

                     OR country = :country

                     OR profession = :profession

                     AND id != :id

                     LIMIT 7

                   ");

  $q->execute([

    'city' => $city,

    'country' => $country,

    'profession' => $profession,

    'id' =>get_session('user_id')

  ]);



  $data= $q->fetchAll(PDO::FETCH_OBJ);

  

  if(count($data) != 0){

  foreach($data as $row)

  {



   if(!!already_suggested($row->id,$_SESSION['user_id']) && !already_suggested($_SESSION['user_id'],$row->id) 

      && !already_friends($_SESSION['user_id'], $row->id) && !already_friends($row->id,$_SESSION['user_id'])

     )

      {

       

       if(get_session('user_id') != $row->id)

       {

       //Insertion de la suggestion

      $q =$db->prepare('INSERT INTO user_relationships_suggestion(user_id1,user_id2,created_at)

                        VALUES (:user_id1,:user_id2,curdate())');

      $q->execute([

           'user_id1'=> $_SESSION['user_id'],

           'user_id2'=>$row->id

      ]);



      $q->closecursor();



      // Insertion de la notification

      

      $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)

                         VALUES(:subject_id, :name, :user_id)');

                $q->execute([

                'subject_id' => $row->id,

                'name' => 'relatives_suggestion',

                'user_id' => get_session('user_id'),

                ]);

      }

      

      }

  }

}



require("views/v2/feed.view.php");



