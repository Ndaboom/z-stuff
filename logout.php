<?php
session_start(); 

session_destroy();

$_SESSION=[];

setcookie('nom2','',time()-3600);

setcookie('user_id','',time()-3600);

header('Location: login.php');

?>



