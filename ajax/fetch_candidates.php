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
                 $button='<a class="btn btn-outline-primary btn-xs active unvote" id="button'.$row->id.'" data-action="unvote" data-session_id="'.$row->session_id.'" data-event_id="'.$row->event_id.'" data-candidate_id="'.$row->id.'" data-points="'.abs($row->points).'"><i class="fas fa-check-circle" style="color:white;">Voté</i></a>
                         <a class="btn btn-outline-primary btn-xs" id="current'.$row->id.'" data-action="vote" data-session_id="'.$row->session_id.'" data-event_id="'.$row->event_id .'" data-candidate_id="'. $row->id .'" data-points="'.abs($row->points).'" style="display:none;">Voter</a>';
                }
                elseif(!user_has_already_voted_a_specified_candidate(get_session('user_id'),$row->id) && $_SESSION['user_id'] && $vote)
                {
                 $button='<a class="btn btn-outline-primary btn-xs vote" id="current'.$row->id.'" data-action="vote" data-session_id="'. $row->session_id  .'" data-event_id="'.$row->event_id .'" data-candidate_id="'. $row->id .'" data-points="'.abs($row->points).'">Voter</a>
                 <a class="btn btn-outline-primary btn-xs active" id="button'.$row->id.'" data-action="unvote" data-session_id="'. $row->session_id  .'" data-event_id="'.$row->event_id .'" data-candidate_id="'. $row->id .'" data-points="'.abs($row->points).'" style="display:none;"><i class="fas fa-check-circle" style="color:white;">Voté</i></a>';
                }else{
                 $button = '';
                }
                
               if($row->points>=300){  
               $percentage=($row->points*100)/300;
               $footer='<div class="progress">
                   <div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" aria-valuenow="'.$row->points.'" aria-valuemin="0" aria-valuemax="1000" style="width: '.$percentage.'%"><span style="color: #444;" id="span'.$row->id.'">'.abs($row->points).'</span></div>
                   </div>';
                }elseif($row->points>=150){
                $percentage=($row->points*100)/300;
                $footer='<div class="progress">
                   <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'.$row->points.'" aria-valuemin="0" aria-valuemax="1000" style="width: '.$percentage.'%"><span style="color: #444;" id="span'.$row->id.'">'.abs($row->points).'</span></div>
                   </div>';
                }elseif($row->points>=50){
                $percentage=($row->points*100)/300;
                $footer='<div class="progress">
                   <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'.$row->points.'" aria-valuemin="0" aria-valuemax="1000" style="width: '.$percentage.'%"><span style="color: #444;" id="span'.$row->id.'">'.abs($row->points).'</span></div>
                   </div>';
                }else{
                $percentage=($row->points*100)/300;
                $footer='<div class="progress">
                   <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="'.$row->points.'" aria-valuemin="0" aria-valuemax="1000" style="width: '.$percentage.'%"><span style="color: #444;" id="span'.$row->id.'">'.abs($row->points).'</span></div>
                   </div>';   
                }
             
               $output .= '
                <div class="card bg-dark text-white" style="width:150px;">
                        <img src="/'.$row->urlmedia .'" class="card-img" alt="...">
                <div class="card-img-overlay text-center">
                    <br><br>
                        '.$button.'<br>
                </div>
                <div class="card-footer" style="background: #32383E;">
                '.$footer.'
                </div>
                 </div>&nbsp;
                ';
               }
              echo $output;
    	}
