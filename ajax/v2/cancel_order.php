<?php 
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

if($_SESSION['user_id'] && $_POST['product_id'])
{
    $q =$db->prepare(
		               'DELETE FROM place_orders
		               WHERE id = :product_id');

	$q->execute([
		'product_id'=>$_POST['product_id']
	]);
}