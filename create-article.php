<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user2 = find_user_by_id($_SESSION['user_id']);

$q=$db->prepare('SELECT * FROM article_categories');
$q->execute();
$article_categories = $q->fetchAll(PDO::FETCH_OBJ);

if(isset($_GET['a_i'])){
    $article_id = $_GET['a_i'];
    $article = find_article_by_id($article_id);

    if(isset($_POST['update'])){
        extract($_POST);
        if($article->user_id == $_SESSION['user_id']){

        //Traitement de l'image
        if(!empty($_FILES)){
            $file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));
            $file_name = rand() . '_ZUNGVI.' . $file_extension;

            //$file_extension=strrchr($file_name, ".");
            $file_tmp_name=$_FILES['image']['tmp_name'];
            $file_dest='images/articles/'.$file_name;

            if (move_uploaded_file($file_tmp_name,$file_dest)) {
                $source_image = $file_dest;
                $image_destination = 'images/articles/'.uniqid(time()).'.'.$file_extension;
                $compress_image = compress($source_image,$image_destination);
            }
            if($image_destination != "")
            {
            
            $q=$db->prepare('UPDATE articles
                        SET title= :title, image= :image, body= :body, category= :category 
                        WHERE id= :a_id');
            $q->execute([
                'a_id'=>$_GET['a_i'],
                'title'=> $title,
                'image'=>$image_destination,
                'body' =>$body,
                'category' => $category
            ]); 
            
            }else{

            $q=$db->prepare('UPDATE articles
            SET title= :title, body= :body, category= :category 
            WHERE id= :a_id');
            $q->execute([
            'a_id'=>$_GET['a_i'],
            'title'=> $title,
            'body' =>$body,
            'category' => $category
            ]); 
            
            }

            $q->closecursor();
        }

        }
        redirect('article.php?n='.$title.'&a_i='.$_GET['a_i']);
        //Fin traitement
    }
}

if(isset($_POST['insert'])){
    extract($_POST);

    //Traitement de l'image
    if(!empty($_FILES)){
		$file_extension = strtolower(pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION));

	    $file_name = rand() . '_ZUNGVI.' . $file_extension;

		//$file_extension=strrchr($file_name, ".");
		$file_tmp_name=$_FILES['image']['tmp_name'];
		$file_dest='images/articles/'.$file_name;

	if (move_uploaded_file($file_tmp_name,$file_dest)) {
	    $source_image = $file_dest;
        $image_destination = 'images/articles/'.uniqid(time()).'.'.$file_extension;
        $compress_image = compress($source_image,$image_destination);

	    }
	 }
	 //Fin traitement
	 
if(not_empty(['title', 'body'])){
   
$q=$db->prepare('INSERT INTO articles(title,image,body,category,user_id)
                   VALUES(:title,:image,:body,:category,:user_id)');
  $q->execute([
  'title'=> $title,
  'image'=>$image_destination,
  'body' =>$body,
  'category' => $category,
  'user_id' => $_SESSION['user_id']
  ]);
  $q->closecursor(); 
  
  $last_id = $db->lastInsertId();

  redirect('article.php?n='.$title.'&a_i='.$last_id);
}

}

require("views/v2/create-article.view.php"); 
?>
