<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");


if(isset($_POST['add_product'])){

	if(!empty($_POST['product_designation'])){
		extract($_POST);
        
    if (!empty($_FILES)){
	    $file_name =$_FILES['image']['name'];
		$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/'.$file_name;

		$extensions_autorisees= array('.jpg','.JPG','.jpeg','.png');
		
	if (in_array($file_extension, $extensions_autorisees)) {

	    if(move_uploaded_file($file_tmp_name,$file_dest)) {
           $source_image = $file_dest;
		   $image_destination = 'images/'.uniqid(time()).'.'.$file_extension;
		   $compress_image = compress($source_image,$image_destination);

	$q =$db->prepare('INSERT INTO microposts(legend,user_id,urlMedia,urlMedia1,type,title,additionnal_info,created_at)
	                  VALUES (:content,:user_id,:urlMedia,:urlMedia1,:type,:title,:additionnal_info,NOW())');
	    $q->execute([
           'content'=>$product_description,
           'user_id'=> $_SESSION['user_id'],
           'urlMedia'=>$image_destination,
           'urlMedia1'=>$file_dest,
           'type'=> "product",
           'title'=>$product_designation,
           'additionnal_info'=>$product_price
	    ]);
	    $q->closecursor();
	    //set_flash('Statut added successfully');
	    }
   }
}
}
} 

    redirect('feed.php?id='.get_session('user_id'));

