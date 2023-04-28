 <?php

if (isset($_SESSION['user_id']) AND isset($_SESSION['nom2'])){
	header('Location: feed.php');
	exit();
}

?> 