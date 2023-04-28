<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user= find_user_by_id($_GET['id']);
$user2 = find_user_by_id($_SESSION['user_id']);

     
require("views/v2/messages.view.php"); 	
?>


