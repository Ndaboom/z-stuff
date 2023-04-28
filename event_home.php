<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("includes/event_functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user=find_user_by_id($_SESSION['user_id']);
$event = find_event_by_id($_GET['ev_i']);
$candidates=get_candidates($_GET['ev_i']);
$user2 = find_user_by_id($_SESSION['user_id']);

$q = $db->prepare("SELECT id,name,city,country,profilepic 
                   FROM users 
                   WHERE active= :active AND id!= :id 
                   ORDER BY RAND()
                   LIMIT 300");
$q->execute([
           'active'=>1,
           'id'=>get_session('user_id')
      ]);
$users = $q->fetchAll(PDO::FETCH_OBJ);

$title = $event->event_name;

if(isset($_POST['update_info'])){
    extract($_POST);

    if(!empty($_FILES)){

        $file_extension = strtolower(pathinfo($_FILES["profile_pic"]["name"],PATHINFO_EXTENSION));
		$file_extension1 = strtolower(pathinfo($_FILES["cover_pic"]["name"],PATHINFO_EXTENSION));
		
		if($file_extension != ""){
		$file_name = rand() . 'ZGV.' . $file_extension;
		$file_tmp_name =$_FILES['profile_pic']['tmp_name'];
		$file_dest='images/'.$file_name;
		if (move_uploaded_file($file_tmp_name,$file_dest)) {
			    $source_image = $file_dest;
		        $image_destination = 'images/'.uniqid(time()).'ZGV.'.$file_extension;
		        $compress_image = compress($source_image,$image_destination);
		        
		        $q = $db->prepare('UPDATE events
	 	            SET profilepic= :profilepic 
	 	            WHERE id = :id');
		$q->execute([
            'profilepic'=> $image_destination,
            'id'=> $_SESSION['ev_i']
			]);
		        
		}
		
		}
		
		if($file_extension1 != ""){
		
		$file_name1 = rand() . 'ZGV.' . $file_extension1;
		$file_tmp_name1 =$_FILES['cover_pic']['tmp_name'];
		$file_dest1 ='images/'.$file_name1;

		if (move_uploaded_file($file_tmp_name1,$file_dest1)) {
			    $source_image = $file_dest1;
		        $image_destination = 'images/'.uniqid(time()).'ZGV.'.$file_extension1;
		        $compress_image = compress($source_image,$image_destination);
		        
		        $q = $db->prepare('UPDATE events
	 	            SET coverpic= :coverpic 
	 	            WHERE id = :id');
		$q->execute([
            'coverpic'=> $image_destination,
            'id'=> $_SESSION['ev_i']
			]);
		        
		}
		}	
    }
    
     $q = $db->prepare('UPDATE events
	 	            SET event_name= :event_name,description= :description,organization= :organization,localization= :localization,
	 	            start_date= :start_date,participation= :participation,
	 	            website= :website  
	 	            WHERE id = :id');
	$q->execute([
		'event_name'=> $eventname,
		'description'=> $description,
		'organization'=> $organization,
		'localization'=> $localization,
		'start_date'=> $start_date,
		'participation'=> $participation,
		'website'=> $website,
		'id'=> $_SESSION['ev_i']
		]);
	$q->closecursor();
  redirect('event_home.php?ev_i='.get_session('ev_i').'&n='.$event->event_name.'&p=settings');  
}

require("views/v2/event_home.view.php");
