<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
    
    $user=find_user_by_id($_SESSION['user_id']);
    $user2=selectUserProfilePic($_SESSION['user_id']);
    $place=selectCurrentPlace();

   $q= $db->prepare("SELECT id,creator_id,place_name,object_name,object_price,object_interaction,object_view1,add_at FROM marketplace WHERE place_id= :place_id");
        $q->execute([
                     'place_id'=>$place->id
                    ]);
        $products=$q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor();

    $req = $db->query("SELECT id FROM marketplace");

    $nbre_total_products = $req->rowCount();

    $nbre_products_par_page = 2;

    $nbre_pages_max_gauche_et_droite = 4;

    $last_page = ceil($nbre_total_products / $nbre_products_par_page);

    if(isset($_GET['page']) && is_numeric($_GET['page'])){
        $page_num = $_GET['page'];
    } else {
        $page_num = 1;
    }

    if($page_num < 1){
        $page_num = 1;
    } else if($page_num > $last_page) {
        $page_num = $last_page;
    }

    $limit = 'LIMIT '.($page_num - 1) * $nbre_products_par_page. ',' . $nbre_products_par_page;
//En haut c'etait l'affichage des produits du marketplace
$q= $db->prepare("SELECT * FROM marketplace WHERE place_id= :place_id
                     ORDER BY object_name LIMIT 3");
        $q->execute([
                     'place_id'=>$place->id
                    ]);
        $homeproducts=$q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor();

  $pnotifications=place_notifications_displayer();
  $q= $db->prepare('SELECT * 
                      FROM placeposts
                      WHERE place_id= :place_id ORDER BY -created_at
                      ');
        $q->execute([
           'place_id'=>$place->id
        ]);
        $placeposts = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor();
 

    

    if(isset($_POST['insert'])){
       extract($_POST);

if(not_empty(['place_name','description','category'])){

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
            'place_id'=>$_GET['pl_i']
			]);
   $_SESSION['pl_n']=$place_name;
   $_SESSION['creator_id']=$_SESSION['user_id'];
   redirect('homeplace.php?pl_i='.$place->id);
}else{
  echo "please fill in all the fields";
}

}

   

   
require("views/homeplace.view.php");