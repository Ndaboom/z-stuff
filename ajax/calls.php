<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$status = "requesting";

$query= "
     SELECT * FROM video_calls
     SET last_activity = now()
     WHERE to_user_id = '".get_session('user_id')."' AND status = '".$status."' 
";

$statement= $db->prepare($query);
$statement->execute();
$user = $statement->fetchAll(PDO::FETCH_OBJ);

if(count($statement->rowCount()) != 0){
    echo "Incoming from ".$user->from_user_id;
}else{
    echo "No incoming call";
}