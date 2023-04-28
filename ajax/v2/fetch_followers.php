<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
    	$total_row = followers_count();
    	
        echo $total_row;
 }