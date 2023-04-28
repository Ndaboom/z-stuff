<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
    $user=find_user_by_id($_SESSION['user_id']);
    $user2=selectUserProfilePic($_SESSION['user_id']);
    
  

  
require("views/forumcontent.view.php");