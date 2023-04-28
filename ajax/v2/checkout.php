<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if (get_session('user_id')) {

    $query ="SELECT *
    FROM place_orders
    WHERE user_id= :user_id
    ORDER BY ordered_at DESC";
    $statement = $db->prepare($query);
    $statement->execute([
        'user_id'=>get_session('user_id')
    ]);
    
    $objects = $statement->fetchAll(PDO::FETCH_OBJ);
     
     foreach($objects as $row){

        // Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(post_id,subject_id,name,user_id)
      VALUES(:post_id,:subject_id,:name,:user_id)');
        $q->execute([
        'post_id' =>$row->object_id,
        'subject_id' =>$row->creator_id,
        'name' => "newOrders",
        'user_id'=>get_session('user_id')  
        ]);

        // //Setting isSend status to 1

         $q =$db-> prepare("UPDATE place_orders
         SET is_send = '1'
         WHERE user_id = :user_id AND is_send = :is_send");

        $q->execute([
          'user_id'=>get_session('user_id'),
          'is_send'=>'0'
        ]);

     }

}