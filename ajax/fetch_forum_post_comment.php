<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

 $q=$db->prepare("SELECT id FROM place_comments
	              WHERE place_id= :place_id AND post_id= :post_id
	                            ");
	           $q->execute([
                   'place_id'=>get_session('pl_i'),
                   'post_id'=>$post_id
	           ]);
	            $count=$q->rowCount();

               $output = '';
	$output .='
             <button type="button" class="btn btn-fbook btn-block btn-sm" data-toggle="modal" data-target="#commentModal'. $placepost->id.'"><i class="far fa-comment" aria-hidden="true" ></i> Comment</button>    
		      ';

echo $output;

