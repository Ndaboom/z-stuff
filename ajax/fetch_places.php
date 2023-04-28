<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
   $query = "SELECT * FROM places LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
        $statement = $db->prepare($query);
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	$output= '';
    	if($total_row > 0)
    	{
    	    
            foreach ($result as $place)
               {
                $output .= '
                <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="user-block">
              <a href="homeplace.php?pl_i='.$place->id.'">
              <img src= "'.$place->coverpic.'"  alt="image" class="" width="290" >
              </a>
              <a href="homeplace.php?pl_i='.$place->id.'">
              <h3 class="user-block-username">'.$place->place_name.'<br/></h3>
            </a>
            <h4 style="color:#474f7C;">Category: '.e($place->category).'</h4>
            <a href="homeplace.php?pl_i='.$place->id.'" class="btn btn-outline-primary" style="width: 275px;">Visit</a>
            </div>
                    </div>
                    <div class="col-md-6" style="border-left: solid 1px #DDDDDD;">
                      <a href="placegallery.php?pl_i='.$place->id.'">
              <img src= "'.e($place->image).'" alt="image" class="img-thumbnail" width="280" style="width: 280px; height: 180px;" >
              </a>
              <a href="placegallery.php?pl_i='.$place->id.'">
              <img src= "'.e($place->image1).'" alt="image" class="" width="100" style="width: 100px; height: 50px;" >
              </a>
              <a href="placegallery.php?pl_i='.$place->id.'">
              <img src= "'.e($place->image2).'" alt="image" class="" width="100" style="width: 100px; height: 50px;">
              </a>
              <a href="placegallery.php?pl_i='.$place->id.'" class="btn btn-outline-primary" style="height: 40px; width: 50px;">+</a><br> 
                    </div>
                  </div>
                
                </div>
              </div>
                '; 
                
               }
             echo $output;
    	}
  }