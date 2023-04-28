<?php

if (!isset($_SESSION['user_id']) and !isset($_SESSION['nom2'])) {

	$_SESSION['forwarding_url'] = $_SERVER['REQUEST_URI'];

	header('Location: login.php');

	exit();
}
