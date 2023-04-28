<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';

extract($_POST);

if($_SESSION['user_id'] == $_POST['o_i']){
    $data = array(
        ':article_id'=>$_POST["a_i"]
    );
    $query = "
        DELETE FROM articles
        WHERE id= :article_id
    ";
    $statement = $db->prepare($query);
    $statement->execute($data);
}else{
    echo "You cannot remove that article because you're not the owner";
}


