<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if (get_session('user_id')){
	
    if($_POST['action'] == "follow"){
        $q =$db-> prepare(
                    'INSERT INTO places_followers(place_id,user_id,status)
                    VALUES(:place_id,:user_id,:status)');

        $q->execute([
        'place_id'=>$_POST['place_id'],
        'user_id'=>get_session('user_id'),
        'status'=>1

        ]);
        $q->closecursor();

        $q=$db->prepare("INSERT INTO place_notifications(poster_id,content,place_name,place_id,seen,posted_at)
                VALUES(:poster_id,:content,:place_name,:place_id,:seen,NOW())
                ");
        $q->execute([
        'poster_id'=>get_session('user_id'),
        'content'=>"you have 1 follower",
        'place_name'=>$_POST['place_name'],
        'place_id'=>$_POST['place_id'],
        'seen'=>0
        ]);

        $q = $db->prepare('INSERT INTO notifications(place_id,subject_id ,user_id,type,created_at)
                    VALUES(:place_id,:subject_id ,:user_id,:type, NOW())');
            $q->execute([
            'place_id' =>$_POST['place_id'],
            'user_id' =>get_session('user_id'),
            'subject_id'=>get_session('cr_i'),
            'type' => "A commence a suivre votre place "             
            ]);
    }elseif($_POST['action'] == "unfollow"){
        $id=get_session('user_id');
        $q =$db-> prepare(
                        'DELETE  FROM places_followers
                        WHERE place_id = :place_id AND user_id = :user_id');

        $q->execute([
            'place_id'=>$_POST['place_id'],
            'user_id'=>$id
        ]);
    }
	
}
