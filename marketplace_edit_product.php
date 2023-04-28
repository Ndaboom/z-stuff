<?php
session_start();

require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
include('filters/auth_filter.php');

if (isset($_POST['edit_product'])) {

   if(!empty($_POST['object_quantity'])){
		extract($_POST);
        $q = $db->prepare('UPDATE marketplace
	 	            SET object_name= :object_name,object_price= :object_price,object_quantity= :object_quantity,object_interaction= :object_interaction,object_about= :object_about
	 	            WHERE place_id = :place_id AND id= :id');
		$q->execute([
            'object_name'=>$object_name,
            'object_price'=>$object_price,
            'object_quantity'=>$object_quantity,
            'object_interaction'=>$object_interaction,
            'object_about'=>$object_about,
            'place_id'=>get_session('pl_i'),
            'id'=>get_session('pr_i')
			]);
        redirect('about_product.php?pr_i='.get_session('pr_i'));
		}else
		{
		extract($_POST);
        $q = $db->prepare('UPDATE marketplace
	 	            SET object_name= :object_name,object_price= :object_price,object_interaction= :object_interaction,object_quantity= :object_quantity
	 	            WHERE place_id = :place_id AND id= :id');
		$q->execute([
            'object_name'=>$object_name,
            'object_price'=>$object_price,
            'object_interaction'=>$object_interaction,
            'object_quantity'=>$object_quantity,
            'place_id'=>get_session('pl_i'),
            'id'=>get_session('pr_i')
			]);	
		redirect('about_product.php?pr_i='.get_session('pr_i'));
		}
	}