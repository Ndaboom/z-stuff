<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);

if(fetch_is_type_status($_POST['user_id'],$db) == "yes"){
    $status = '<em>Typing...</em>';
}else if(fetch_is_type_status($row->user,$db) == "no"){
    $status = '';
}else{
    $status = '';
}

echo $status;