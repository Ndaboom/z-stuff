<?php 

session_start();

require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
extract($_POST);

if (!empty($_FILES)) {
	    
	    $file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));
		
		$extensions_autorisees = array('jpg','JPG','jpeg','png', 'gif');
            
		$file_tmp_name = $_FILES['image']['tmp_name'];
        
            if (in_array($file_extension, $extensions_autorisees)) {
            
            $file_name = rand() . '_ZUNG_IMG.' . $file_extension;
		    $file_dest = 'stories/'.$file_name;
		        
		        if (move_uploaded_file($file_tmp_name,$file_dest)) {
		        
		        
		        $source_image = $file_dest;
		        $image_destination = 'stories/'.uniqid(time()).'_ZUNG_IMG.'.$file_extension;
		        $compress_image = compress($source_image,$image_destination);
		        
		        $q =$db->prepare('INSERT INTO stories(user_id,story_ressources,compressed_img,legend,posted_at)
	                  VALUES (:user_id,:story_ressources,:compressed_img,:legend, NOW())');
	                  
	            $q->execute([
                      'user_id'=> $_SESSION['user_id'],
                      'story_ressources'=>$file_dest,
                      'compressed_img'=>$image_destination,
                      'legend'=>$content
	            ]);
	            
	            $q->closecursor();
	               
		        }else{
		        echo "Images upload failed";
		        exit();
		        }
		    
		}else{
        
        echo "File format not supported";
        exit();
        
        }
            
        
        redirect('feed.php?id='.get_session('user_id'));
        
        $q->closecursor();
       		
}
