<?php 
session_start();

require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
extract($_POST);

if (!empty($_FILES)) {
	    
	    $file_extension1 = strtolower(pathinfo($_FILES["image1"]["name"],PATHINFO_EXTENSION));
		$file_extension2 = strtolower(pathinfo($_FILES["image2"]["name"],PATHINFO_EXTENSION));
		$file_extension3 = strtolower(pathinfo($_FILES["image3"]["name"],PATHINFO_EXTENSION));
		
		$extensions_autorisees= array('jpg','JPG','jpeg','png');
		$last_id = 0;
		
		if($file_extension1 == "" && $file_extension2 == "" && $file_extension3 == "" && !empty($content)){
		
		        $q =$db->prepare('INSERT INTO microposts(legend,user_id,created_at)
	                  VALUES (:content,:user_id, NOW())');
	            $q->execute([
                            'content'=>$content,
                            'user_id'=> $_SESSION['user_id']
	                        ]);
	            
	            $q->closeCursor(); 
	            redirect('timeline.php?id='.get_session('user_id'));
        
        }
		
		for ($x = 1; $x <= 3; $x++) {
            
            $file_extension = ${"file_extension".$x};
            if (in_array($file_extension, $extensions_autorisees)) {
            
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
		        $q =$db->prepare('INSERT INTO microposts(legend,user_id,urlMedia,urlMedia1,created_at)
	                  VALUES (:content,:user_id,:urlMedia,:urlMedia1, NOW())');
	            $q->execute([
                            'content'=>$content,
                            'user_id'=> $_SESSION['user_id'],
                            'urlMedia'=>$image_destination,
                            'urlMedia1'=>$file_dest
	                        ]);
	            
	            $last_id = $db->lastInsertId();
	            
	            }else if($x == 2){
	            $q =$db->prepare('UPDATE microposts 
	                              SET add_image1 = :add_image1, cmprssd_add_image1 = :cmprssd_add_image1
	                              WHERE id= :id');
	            $q->execute([
                            'id'=>$last_id,
                            'add_image1'=> $file_dest,
                            'cmprssd_add_image1'=>$image_destination
	                        ]);
	            }else if($x == 3){
	            $q =$db->prepare('UPDATE microposts 
	                              SET add_image2 = :add_image2, cmprssd_add_image2 = :cmprssd_add_image2
	                              WHERE id= :id');
	            $q->execute([
                            'id'=>$last_id,
                            'add_image2'=> $file_dest,
                            'cmprssd_add_image2'=> $image_destination
	                        ]);
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
              
        $q->closecursor();
        redirect('timeline.php?id='.get_session('user_id'));
        	
}
