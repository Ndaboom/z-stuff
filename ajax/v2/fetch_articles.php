<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
        $query = "SELECT * FROM articles ORDER BY posted_at DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
        $statement = $db->prepare($query);
    	$statement->execute();
    	$result = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	$output= '';
    	if($total_row > 0)
    	{
    	  
    	  foreach($result as $article){
    	    
    	    $output .= '
    	    <div class="lg:flex lg:space-x-6 py-5">
                                <a href="article.php?a_i='.$article->id.'&n='.$article->title.'">
                                    <div class="lg:w-60 w-full h-40 overflow-hidden rounded-lg relative shadow-sm"> 
                                         <img src="/'.$article->image.'" alt="" class="w-full h-full absolute inset-0 object-cover">
                                         <div class="absolute bg-blue-100 font-semibold px-2.5 py-1 rounded-full text-blue-500 text-xs top-2.5 left-2.5">
                                           '.$article->category.'
                                         </div>
                                    </div>
                                </a>
                                <div class="flex-1 lg:pt-0 pt-4"> 
                                     
                                    <a href="article.php?a_i='.$article->id.'&n='.$article->title.'" class="text-xl font-semibold line-clamp-2">'.$article->title.'</a>
                                    <p class="line-clamp-2 pt-1"> '.substr($article->body,0,250).'... </p>
                                    
                                    <div class="flex items-center pt-3">
                                                <div class="flex items-center">
                                                '.$article->views.' view(s)
                                                </div>
                                    </div>
        
                                </div>
            </div>
    	    ';
    	    
    	  }
    	  
    	  echo $output;
    	
        }
    
  }
