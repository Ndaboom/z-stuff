<?php
session_start();
include('filters/auth_filter.php');
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user2 = find_user_by_id($_SESSION['user_id']);

$q = $db->prepare("SELECT * 
	               FROM forums
	               WHERE creator_id !=:user_id");
$q->execute([
    'user_id'=>get_session('user_id')
]);
$forums = $q->fetchAll(PDO::FETCH_OBJ);
$q->closecursor();

$myforums = forum_where_user_is();
$iamadmin = forum_where_defined_user_is_admin($_SESSION['user_id']);


require("views/v2/forums.view.php"); 
?>
