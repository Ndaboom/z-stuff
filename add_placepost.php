<?php 
session_start();

require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
extract($_POST);
if(!empty($_FILES)) {
        
	    $file_extension1 = strtolower(pathinfo($_FILES["image1"]["name"],PATHINFO_EXTENSION));
		$file_extension2 = strtolower(pathinfo($_FILES["image2"]["name"],PATHINFO_EXTENSION));
		$file_extension3 = strtolower(pathinfo($_FILES["image3"]["name"],PATHINFO_EXTENSION));
		
		$extensions_autorisees= array('jpg','JPG','jpeg','png');
		$last_id = 0;
        $add_images = "";
        $compressed_images = "";
		
		if($file_extension1 == "" && $file_extension2 == "" && $file_extension3 == "" && !empty($content)){
		
		        $q =$db->prepare('INSERT INTO placeposts(legend,place_id,user_id,created_at)
	                  VALUES (:content,:place_id,:user_id, NOW())');
	            $q->execute([
                            'content'=>$content,
                            'place_id'=>$_SESSION['pl_i'],
                            'user_id'=> $_SESSION['user_id']
	                        ]);
	            
	            $q->closeCursor(); 
	            redirect('place_home.php?pl_i='.get_session('pl_i').'&n='.get_session('pl_n'));
        
        }
		
		for ($x = 1; $x <= 3; $x++) {
            $file_extension = ${"file_extension".$x};
            if(in_array($file_extension, $extensions_autorisees)) {
            
            $file_name = rand() . '.' . $file_extension;
		    $file_tmp_name =$_FILES['image']['tmp_name'];
		    $file_dest='images/'.$file_name;
		    
		    if($file_extension){
		        
		        $file_name = rand() . '_ZUNG_IMG.' . $file_extension;
		        $file_tmp_name =$_FILES['image'.$x]['tmp_name'];
		        $file_dest='images/'.$file_name;
		        
		        if (move_uploaded_file($file_tmp_name,$file_dest)) {
		        $source_image = $file_dest;
		        $image_destination = 'images/'.uniqid(time()).'_ZUNG_IMG.'.$file_extension;
		        $compress_image = compress($source_image,$image_destination);

		        if($x == 1){

		        	$q =$db->prepare('INSERT INTO placeposts(legend,place_id,user_id,type,urlMedia,place_name,created_at)
	                  VALUES (:content,:place_id,:user_id,:type,:urlMedia,:place_name,NOW())');
                    $q->execute([
                    'content'=>$content,
                    'place_id'=>$_SESSION['pl_i'],
                    'user_id'=> $_SESSION['cr_i'],
                    'type'=>'a ajoute une nouvelle photo',
                    'urlMedia'=>$file_dest,
                    'place_name'=>get_session('pl_n')
                    ]);
                    $q->closecursor();
        
	            $last_id = $db->lastInsertId();
	             
	            }else if($x == 2){
                $add_images .= $file_dest.',';
                $compressed_images .= $image_destination.',';
	            }else if($x == 3){
                $add_images .= $file_dest;
                $compressed_images .= $image_destination;
	            }
	               
		        }else{
		        echo "Images upload failed";
		        exit();
		        }
		        
		    }
		    
		}else{
        
        echo "File format not supported";
        
        }
            
        }
        //Save additionnal images
        $q =$db->prepare('UPDATE placeposts 
        SET add_images = :add_images, compressed_images = :compressed_images
        WHERE id= :id');
        $q->execute([
        'id'=>$last_id,
        'add_images'=> $add_images,
        'compressed_images'=> $compressed_images
        ]);

        //Recuperation de tout les followers de la place en cours
        $q =$db->prepare('SELECT user_id FROM places_followers
                        WHERE place_id= :place_id AND user_id != :user_id
                        AND status= :status
                        ');
        $q->execute([
                    'place_id'=>get_session('pl_i'),
                    'user_id'=>get_session('user_id'),
                    'status'=>1
                ]);
        $users= $q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor(); 
        //Signalement a tout les followers du nouveau post
        foreach($users as $row)
        {
        $q=$db->prepare('INSERT INTO new_place_post(user_id,place_id,seen)
                        VALUES(:user_id,:place_id,:seen)');
        $q->execute([
        'user_id'=>$row->user_id,
        'place_id'=>get_session('pl_i'),
        'seen'=>0
         ]);
        
        }
              
        $q->closecursor();
        redirect('place_home.php?pl_i='.get_session('pl_i').'&n='.get_session('pl_n'));
        	
}
