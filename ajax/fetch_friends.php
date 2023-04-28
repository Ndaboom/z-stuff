<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
if(isset($_POST["limit"], $_POST["start"]))
  {
   $query = "SELECT * FROM users WHERE id != :user_id LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
        $statement = $db->prepare($query);
    	$statement->execute([
           'user_id'=>get_session('user_id')
    	]);
    	$result = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	$output= '';
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
                       </p>
                     <button type="button" name="follow_button" class="btn btn-outline-primary action_button" id="sent'.$row->id.'" data-action="follow" data-destinator_id="'.$row->id.'" style="width:250px;"><i class="fas fa-user-plus"></i> friends</button>
                     <button type="button" class="btn btn-outline-success" id="success'.$row->id.'" style="width:250px; display:none;"> Sent</button>
                     
                  </div>
                                      
            </div>   
            </div>
          </div>';
               }
               }
               }
              echo $output;
    	}
  
}
