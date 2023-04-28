<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("bootsrap/locale.php");

if(!empty($_GET['u_i'])){
    $data=get_post_data($_GET['u_i']);
    $user2=selectUserProfilePic(get_session('user_id'));
    $_SESSION['him']=$_GET['u_i'];

    if(!get_session('user_id')){
      redirect('index.php');
    }
}
require("views/hispost.view.php");