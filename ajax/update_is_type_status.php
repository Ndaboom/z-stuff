<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$query= "
UPDATE login_details
SET is_type = '".$_POST["is_type"]."'
WHERE user_id = '".$_SESSION["user_id"] ."'
";
$statement= $db->prepare($query);
$statement->execute();