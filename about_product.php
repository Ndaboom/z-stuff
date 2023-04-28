<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
    
    $user=find_user_by_id($_SESSION['user_id']);
    $user2=selectUserProfilePic($_SESSION['user_id']);
    $places=selectCurrentPlace();
    $product=find_product_by_id($_GET['pr_i']);
    
require("views/about_product.view.php");