<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

      $status=1;
      $query= "
            SELECT * FROM poll_tb
            WHERE event_id= '".get_session('ev_i')."'
            AND status= '".$status."'
    ";
    $statement= $db->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll(PDO::FETCH_OBJ);
    $output= '';
    	if(count($result) != 0)
    	{
    	    
            foreach ($result as $row)
               {
                $candidates=candidates_count($row->session_id,$row->event_id);
                $vote = false;
                if(user_has_already_voted_a_specified_candidate(get_session('user_id'),$row->id) && $_SESSION['user_id'] && $vote)
                {

                $button = '
                <a href="" class="flex items-center justify-center h-9 px-4 rounded-md border font-semibold bg-blue-700 unvote" id="button'.$row->id.'" data-action="unvote" data-session_id="'.$row->session_id.'" data-event_id="'.$row->event_id.'" data-candidate_id="'.$row->id.'" data-points="'.abs($row->points).'" style="color:white;" > Voté</a>
                <a href="" class="flex items-center justify-center h-9 px-4 rounded-md border font-semibold vote" id="current'.$row->id.'" data-action="vote" data-session_id="'.$row->session_id.'" data-event_id="'.$row->event_id .'" data-candidate_id="'. $row->id .'" data-points="'.abs($row->points).'" style="display:none;">  Voter </a>';

                }
                elseif(!user_has_already_voted_a_specified_candidate(get_session('user_id'),$row->id) && $_SESSION['user_id'] && $vote)
                {
                 
                $button = '
                <a href="" class="flex items-center justify-center h-9 px-4 rounded-md border font-semibold vote" id="current'.$row->id.'" data-action="vote" data-session_id="'. $row->session_id  .'" data-event_id="'.$row->event_id .'" data-candidate_id="'. $row->id .'" data-points="'.abs($row->points).'"> Voter</a>
                <a href="" class="flex items-center justify-center h-9 px-4 rounded-md border font-semibold bg-blue-700 unvote" id="button'.$row->id.'" data-action="unvote" data-session_id="'. $row->session_id  .'" data-event_id="'.$row->event_id .'" data-candidate_id="'. $row->id .'" data-points="'.abs($row->points).'" style="display:none;color:white;"> Voté </a>';

                }else{
                 $button = '';
                }
                
                $maximum_point = 100;
                
               if($row->points>=300){  
               $percentage=($row->points*100)/$maximum_point;
               $footer='
                   <div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: '.$row->points.'%"> '.abs($row->points).'%</div>
                   </div>
                   ';
                }elseif($row->points>=150){
                $percentage=($row->points*100)/$maximum_point;
                $footer='<div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: '.$row->points.'%"> '.abs($row->points).'%</div>
                        </div>';
                }elseif($row->points>=50){
                $percentage=($row->points*100)/$maximum_point;
                $footer='<div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: '.$row->points.'%"> '.abs($row->points).'%</div>
                        </div>';
                }else{
                $percentage=($row->points*100)/$maximum_point;
                    $footer='<div class="w-full bg-gray-200 rounded-full dark:bg-gray-700">
                                    <div class="bg-blue-600 text-xs font-medium text-blue-100 text-center p-0.5 leading-none rounded-full" style="width: '.$row->points.'%"> '.abs($row->points).'%</div>
                            </div>';   
                }
             
               $output .= '
                <li>
                 <a href="#" class="uk-link-reset">
                     <div class="card">
                         <img src="/'.$row->urlmedia .'" class="h-44 object-cover rounded-t-md shadow-sm w-full">
                         <div class="p-4">
                             <h4 class="text-base font-semibold mb-1"> '.$row->user_name.' </h4>
                             '.$footer.'<br>
                             '.$button.'
                         </div>
                     </div>
                 </a>
                 </li>


                ';
               }
              echo $output;
    	}