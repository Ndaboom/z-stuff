<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("includes/event_functions.php");
require("config/database.php");
require("bootsrap/locale.php");

if(isset($_POST["post_limit"], $_POST["post_start"]))
{
  
  $query = "SELECT * FROM eventposts
            WHERE event_id = :event_id ORDER BY created_at DESC LIMIT ".$_POST["post_start"].", ".$_POST["post_limit"]."";
        $statement = $db->prepare($query);
    	$statement->execute([
           'event_id'=>get_session('ev_i')
    	]);
    	
    	$result = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	$output= '';
    	if($total_row > 0)
    	{

            foreach ($result as $row)
               {
                   $event = find_event_by_id($row->event_id);
                   	if($row->urlMedia !=null)
               	{
                     $media='<img class="" src="/'.$row->urlMedia.'" alt="Failed to load...please refresh the page" style="width:100%;min-height:200px; max-height:600px;">';
                     $legend = '<div class="dummy"><p class="text_box" tyle="padding-left:15px;">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</p></div>';
               	}
               	else
               	{
                   $media='';
               	}

                  $output .= '
                     <div class="card my-3" id="'.$row->id.'">
                                      <div class="card-header border-0 py-2">
                                          <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                               '. e($event->event_name).'
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all;"><span class="text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#infoModal'.$row->id.'">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="modal" data-target="#infoModal'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                            <a class="dropdown-item" href="delete_micropost.php?id='. $row->id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0 pb-2">
                            '.$legend.'
                            '.$media.'
                            </div>
                        </div>

                ';
               }
    	}
        else
        {
          $output = '';
        }
        echo $output;
}else{
    echo "Something went wrong...";
}
