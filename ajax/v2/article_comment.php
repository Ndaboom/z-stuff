<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';

extract($_POST);

        $data = array(
                ':article_id'    =>$_POST["article_id"],
                ':user_id'       =>$_SESSION["user_id"],
                ':content'       =>$_POST['content']
	 	);
	 	$query = "
          INSERT INTO article_comments(article_id,user_id,content)
          VALUES(:article_id, :user_id, :content)
	 	";
	 	$statement = $db->prepare($query);
	 	$statement->execute($data);
	 	
echo display_article_comments($_POST['article_id']);
