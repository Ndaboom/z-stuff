<?php
session_start();
require("includes/init.php");

if(!empty($_GET['p_i'])){
    $data=get_post_data($_GET['p_i']);
    $_SESSION['p_i']=$_GET['p_i'];
    $user2=selectUserProfilePic(get_session('user_id'));
    
}
require("views/postviewer.view.php");
