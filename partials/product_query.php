<?php
 $q= $db->prepare('SELECT * 
                      FROM placeposts
                      WHERE place_id= :place_id ORDER BY -created_at
                      ');
        $q->execute([
           'place_id'=>get_session('pl_i')
        ]);
        $placeposts = $q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor();


 $q= $db->prepare("SELECT * FROM marketplace WHERE place_id= :place_id");
        $q->execute([
                     'place_id'=>get_session('pl_i')
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

     $q= $db->prepare("SELECT * FROM marketplace WHERE place_id= :place_id
                     ORDER BY object_name $limit");
        $q->execute([
                     'place_id'=>get_session('pl_i')
                    ]);
        $homeproducts=$q->fetchAll(PDO::FETCH_OBJ);
        $q->closecursor();


  $cover=selectCurrentPlaceCover(get_session('pl_i'));
  $pnotifications=place_notifications_displayer();
  
  