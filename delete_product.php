<?php 
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');
	$id=$_GET['id'];
	$q =$db-> prepare(
		               'DELETE  FROM marketplace
		               WHERE id= :product_id');

	$q->execute([
		'product_id'=>$_GET['id']
	]);
	redirect('homeplace.php?pl_i='.get_session('pl_i'));