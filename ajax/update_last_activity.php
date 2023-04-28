<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$query= "
     UPDATE login_details
     SET last_activity = now()
     WHERE user_id = '".get_session('user_id')."'
";

$statement= $db->prepare($query);
$statement->execute();