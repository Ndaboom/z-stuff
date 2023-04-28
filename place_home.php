<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
    
    
$user2 = find_user_by_id($_SESSION['user_id']);
$place = find_place_by_id($_GET['pl_i']);

if(isset($_POST['update_info'])){
extract($_POST);
var_dump($_FILES);
//Traitement des images 
if (!empty($_FILES)) {
	    
    $file_extension = strtolower(pathinfo($_FILES["profile_pic"]["name"],PATHINFO_EXTENSION));
    $file_extension1 = strtolower(pathinfo($_FILES["cover_pic"]["name"],PATHINFO_EXTENSION));
    
    if($file_extension != ""){
    $file_name = rand() . '.' . $file_extension;
    $file_tmp_name =$_FILES['profile_pic']['tmp_name'];
    $file_dest='images/'.$file_name;
    if (move_uploaded_file($file_tmp_name,$file_dest)) {
            $source_image = $file_dest;
            $image_destination = 'images/'.uniqid(time()).'ZUNGVI_IMG.'.$file_extension;
            $compress_image = compress($source_image,$image_destination);

    $q= $db->prepare('UPDATE places
    SET image = :image  
    WHERE id = :id');
    $q->execute([
    'image'=>$image_destination,
    'id'=>get_session('pl_i')
    ]);

    }
    }

    if($file_extension1 != ""){
    
        $file1_name = rand() . '.' . $file_extension1;
        $file_tmp_name1 =$_FILES['cover_pic']['tmp_name'];
        $file_dest1 ='images/'.$file1_name;
        
        if (move_uploaded_file($file_tmp_name1,$file_dest1)) {
                $source_image = $file_dest1;
                $image_destination = 'images/'.uniqid(time()).'ZUNGVI_IMG.'.$file_extension1;
                $compress_image = compress($source_image,$image_destination);

                $q= $db->prepare('UPDATE places
                SET coverpic = :coverpic  
                WHERE id = :id');
                $q->execute([
                'coverpic'=>$image_destination,
                'id'=>get_session('pl_i')
                ]);
        }   

    }
}

//Traitement des images 

if(not_empty(['place_name','description'])){

 $q= $db->prepare('UPDATE places
                  SET place_name = :place_name,
                      description= :description,
                      category= :category,
                      city= :city,
                      country= :country,
                      place_contacts= :place_contacts,
                      email= :email,
                      website= :website
                      WHERE id = :place_id');
            $q->execute([
            'place_name'=> $place_name,
            'description'=>$description,
            'category'   =>$category,
            'place_contacts'=>$number,
            'city'=>$city,
            'country'=>$country,
            'email'=>$email,
            'website'=>$website,
            'place_id'=>get_session('pl_i')
            ]);

    redirect('place_home.php?pl_i='.$place->id.'&n='.$place->place_name);

    }else{
    echo "please fill in all the fields";
    }

}
   
require("views/v2/place_home.view.php");