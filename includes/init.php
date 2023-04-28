<?php 
require("config/database.php");
require("includes/functions.php");
if (!empty($_COOKIE['nom2']) && !empty($_COOKIE['user_id'])){
            $_SESSION['nom2']=$_COOKIE['nom2'];
            $_SESSION['user_id']=$_COOKIE['user_id'];
            //$_SESSION['place_name']=$_COOKIE['place_name'];
             if(!already_in_login_details(get_session('user_id'))){
               $q=$db->prepare('INSERT INTO login_details(user_id,last_activity)
	                 VALUES(:user_id,NOW())
	                  ');
	                  $q->execute([
	                  'user_id'=>get_session('user_id')
	
	                ]);
	            $_SESSION["login_details_id"]=$db->lastInsertId();
             }else{
             	$query= "
                        UPDATE login_details
                        SET last_activity = now()
                        WHERE user_id = '".get_session('user_id')."'
                        ";

                $statement= $db->prepare($query);
                $statement->execute();

                $q=$db->prepare('UPDATE login_details
                     SET interactions= interactions+1 
                     WHERE user_id= :user_id');
                $q->execute([
                'user_id'=>get_session('user_id')
                 ]);
             }
	
}

//Récupération du nombre total de notifications non lues
$q = $db->prepare("SELECT id FROM notifications
WHERE subject_id = ? AND seen = '0'");
$q->execute([get_session('user_id')]);
$notifications_count = $q->rowCount();