<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {         
        $empty = "";
        
        $query = "
        SELECT urlMedia,legend,type FROM microposts
        WHERE user_id=".$_POST['user_id']." AND urlMedia!= ' '
        ORDER BY created_at DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
        $statement = $db->prepare($query);
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	$output= '';
    	if($total_row > 0)
    	{
    	  
    	  foreach($result as $post){
    	    
    	    if($post->type == "video"){
    	    $media = '<video controls class="w-full h-full absolute object-cover inset-0" preload="meta-data" loop poster="">
                <source src="/'.$post->urlMedia.'"></source>
             </video> '; 
            }elseif($post->type != "audio" && $post->type != "video"){ 
            $media = '<a href="/'.$post->urlMedia.'"><img src="/'.$post->urlMedia.'" class="w-full h-full absolute object-cover inset-0"></a>';
            }
    	    
    	    $output .= '
    	        <div>
                        <div class="bg-blue-400 max-w-full lg:h-56 h-48 rounded-lg relative overflow-hidden shadow uk-transition-toggle" uk-lightbox="">
                            '.$media.'
                            <div class="-bottom-12 absolute bg-gradient-to-b from-transparent h-1/2 to-gray-800 uk-transition-slide-bottom-small w-full"></div>
                            <div class="absolute bottom-0 w-full p-3 text-white uk-transition-slide-bottom-small flex items-center">
                                <div class="flex-1"> 
                                    <div class="text-lg">'.substr($post->legend, 0, 80).' </div>
                                    <div class="flex space-x-3 lg:flex-initial text-sm">
                                       <a href="#">  Like</a>
                                       <a href="#">  Comment </a>
                                       <a href="#">  Share </a> 
                                    </div>
                                </div> 
                                <i class="btn-down text-2xl uil-cloud-download px-1"></i>
                            </div>
                        </div>
                    </div>
    	    ';
    	    
    	  }
    	  
    	  echo $output;
    	
        }
    
  }
