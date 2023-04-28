<?php

session_start();

require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

$user=find_user_by_id($_SESSION['user_id']);
$receiver = find_user_by_id($_GET['u']);

require('views/v2/vcall.view.php');

