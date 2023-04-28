<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
  
    $q= $db->prepare('SELECT *
                  FROM stories
                  WHERE user_id='.$_POST['user_id'].'');
    $q->execute();
    $stories = $q->fetchAll(PDO::FETCH_OBJ);
    $output = '';
    
    if(count($stories) != 0){
        foreach($stories as $story){
         
           $poster = find_user_by_id($story->user_id);
           
           $output .= '
                <li class="relative">

                    <span uk-switcher-item="previous" class="slider-icon is-left"> </span>
                    <span uk-switcher-item="next" class="slider-icon is-right"> </span>

                    <div uk-lightbox>
                        <a href="/'.$poster->profilepic.'" data-alt="Image">
                            <img src="/'. $story->compressed_img .'" class="story-slider-image"  data-alt="Image">
                        </a>
                    </div>

                </li>
                ';
        }
    }
    
    echo $output;
          
  
