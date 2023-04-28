<?php

session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
$user2 = find_user_by_id($_SESSION['user_id']);

require("views/v2/post.view.php"); 	

?>