<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user_id = $_SESSION['user_id'];
$article_id = $_GET['a_i'];
$user = find_user_by_id($user_id);
$user2 = find_user_by_id($user_id);


$article = find_article_by_id($article_id);

if(!empty($user_id)){
if(!is_article_seen($article_id, $user_id)){

$q=$db->prepare('INSERT INTO articles_seen(user_id,article_id)
                   VALUES(:user_id,:article_id)');
  $q->execute([
  'user_id'=> $user_id,
  'article_id'=>$article_id
  ]);
  
$q=$db->prepare('UPDATE articles
		         SET views = views+1 
		         WHERE id= :a_id');
	   $q->execute([
           'a_id'=>$article_id
	   ]); 
	   
 $q->closecursor();

}
}else{

$q=$db->prepare('UPDATE articles
		         SET views = views+1 
		         WHERE id= :a_id');
	   $q->execute([
           'a_id'=>$article_id
	   ]);    
 $q->closecursor();

}

require("views/v2/article.view.php");
