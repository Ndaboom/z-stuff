<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
     $q=$db->prepare("SELECT * FROM events
	                  LIMIT ".$_POST["start"].", ".$_POST["limit"]."
	                 ");
	           $q->execute();

               		
                $events= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor(); 

$output = '';
if(count($events) != 0){
   foreach($events as $row)
{       
 $output .= '<a href="homeevent.php?ev_i='.$row->id.'&n='.$row->event_name.'"><div class="card bg-dark text-white" style="margin-right:2px; margin-left:2px;width:100%;">
                                 <img src="/'.$row->coverpic.'" class="card-img" alt="..." style="widht:100%;">
                                 <div class="card-img-overlay text-center">
                                  <h5 class="card-title" style="font-family:Arial Black;font-size:20px;font-style:bold;">'. $row->event_name .'</h5>
                                     <!--<a class="btn btn-outline-primary btn-xs  active follow" data-event_id="'.$row->id.'"><i  class="fas fa-users"> Suivre </i></a>-->
                                  </div>
                                </div></a> <br>'; 
}
}
echo $output;
  
  }