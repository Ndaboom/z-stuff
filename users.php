<?php
session_start();
require("includes/init.php"); 
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

if(isset($_POST["limit2"], $_POST["from"]))
{
  $query = "SELECT * FROM users WHERE id != :user_id LIMIT ".$_POST["from"].", ".$_POST["limit2"]."";
        $statement = $db->prepare($query);
    	$statement->execute([
           'user_id'=>get_session('user_id')
    	]);
    	$result = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	$output= '<small><h5>People you may know</h5></small>';
    	if($total_row > 0)
    	{
    	    
            foreach ($result as $row)
               {
                   if(!already_friends($row->id,get_session('user_id'))){
              if(!request_already_sent(get_session('user_id'), $row->id)){
                  $output .=' <div class="card card-sm" id="friend'.$row->id.'">
            <div class="card-body">
            <div class="row">
                    <div class="col-md-4 text-center">
                      <a href="profile.php?id='.$row->id.'"><img class="rounded-circle" style="height: 120px; width: 120px; border:1.5px solid #f5f6fa;" src="/'.e($row->profilepic).'"
                        alt="'.e($row->name).'"></a>
                    </div>
                    <div class="col-md-8 text-center">
                        <a href="profile.php?id='.$row->id.'"><h4><b>'.e($row->name).' '. e($row->nom2) .'</b></h4></a>
                        <b>'.e($row->profession).'</b><br>
                        <p style = "font-family:georgia,garamond,serif;font-size:16px;font-style:italic;">
                       '. substr(e($row->bio), 0, 60) .'
                       </p>
                     <button type="button" name="follow_button" class="btn btn-outline-info action_button" data-action="follow" data-destinator_id="'.$row->id.'" style="width:250px;"><i class="fas fa-user-plus"></i> friends</button>  
                     
                  </div>
                                      
            </div>   
            </div>
          </div>';
                        }
                   }
               }
    	    
    	}
    	 echo $output;
}