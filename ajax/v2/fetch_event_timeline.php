<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
    $query = "SELECT * FROM eventposts
    WHERE event_id = :event_id ORDER BY created_at DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
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
	 	        
               	if(record_check('event_posts_like', 'user_id', $_SESSION['user_id'], 'post_id', $row->id)){
                  $like='
                  <a class="flex items-center space-x-2 like" id="unlike'. $row->id .'" data-postid="'.$row->id.'" data-action="unlike" data-event_id="'.get_session('ev_i').'">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#ec5252" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div></div>
                  </a>
                  <a class="flex items-center space-x-2 like" id="like'.$row->id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->id.'" data-event_id="'.get_session('ev_i').'" style="display:none;">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#F3F4F6" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div></div>
                  </a>
                  ';
               	} else{
               		$like='
                    <a class="flex items-center space-x-2 like" id="like'.$row->id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->id.'" data-event_id="'.get_session('ev_i').'">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke="currentColor" fill="#F3F4F6" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div></div>
                  </a>
               	  <a class="flex items-center space-x-2 like" id="unlike'. $row->id .'" data-event_id="'.get_session('ev_i').'" data-postid="'.$row->id.'" data-action="unlike" style="display:none;">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                           <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#ec5252" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div></div>
                  </a>
               		';
               	}


               	if($row->urlMedia !=null)
               	{
                     $content = '<div uk-lightbox>
                                  <a href="/'.$row->urlMedia1.'">  
                                      <img src="/'.$row->urlMedia.'" alt="" class="max-h-96 w-full object-cover">
                                  </a>
                                 </div>';
               	}
               	else
               	{
                   $content = '';
               	}



                
                  $type ='<span> updated his profile picture</span>';
                
                if(get_session('user_id') == get_session('cr_id')){
                    $modal='<div class="modal fade" id="monModal'.$row->id.'">
                         <div class="modal-dialog" >
                               <div class="modal-content">
                                   <div class="modal-body" style="background-color: #e9ebee;">
                                  <a href="delete_eventpost.php?id='. $row->id .'" ><div class="alert text-danger"><i class="far fa-trash-alt"></i> Delete</div></a>
                                  </div>
                                 </div>
                              </div>
                </div>';
                }

                	$query1 = "
                    SELECT * FROM event_posts_like
                    WHERE post_id = '".$row->id."'
                    ORDER BY created_at DESC
	 	           ";
	 	           	$statement1 = $db->prepare($query1);
	 	           		if($statement1->execute())
	 	                {
	 	                    $likers = $statement1->fetchAll(PDO::FETCH_OBJ);
	 	                    $persons='';
	 	                     foreach($likers as $liker){
	 	                    $luser=find_user_by_id($liker->user_id);
	 	                    $persons .='
	 	                    <div class="d-flex">
	 	                    <div style="width:25%;"><a href="profile.php?id='.$luser->id.'"><img src="/'.$luser->profilepic.'" style="height: 45px; width: 45px; border:1.5px solid #f5f6fa;" class="rounded-circle"/></a></div>
	 	                    <div >'.$luser->name.' '.$luser->nom2.'<br><small>'.zungvi_time_ago($liker->created_at).'</small></div>
	 	                    </div><br>
	 	                    ';
	 	                     }
	 	                }

                $likeModal='
                <div class="modal fade" id="likesModal'.$row->id.'">
                               <div class="modal-dialog" >
                                 <div class="modal-content">
                                 <div class="modal-header" style="">
                                 Liked by
                                 <button type="button" class="close" data-dismiss="modal" style="float:right;">X</button>
                                 </div>
                                   <div class="modal-body">
                                  '.$persons.'
                                   </div>
                                 </div>
                              </div>
                </div>
                 ';
                  
                  $current_event = find_event_by_id($row->event_id);
                  $legend = '<div class="p-3">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</div>'; 
                  
                 $output .= '
                 <!-- Post here -->
                 <div class="bg-white shadow border border-gray-100 rounded-lg dark:bg-gray-900 lg:mx-0 uk-animation-slide-bottom-small" id="post_box'.$row->id.'">
                 <div class="flex justify-between items-center lg:p-4 p-2.5">
                         <div class="flex flex-1 items-center space-x-4">
                             <a href="#">
                                 <img src="/'.e($current_event->profilepic).'" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                             </a>
                             <div class="flex-1 font-semibold capitalize">
                                 <a href="#" class="text-black"> '.e($current_event->event_name).' </a>
                                 <div class="text-gray-700 flex items-center space-x-2"> <small class="text-secondary">'.zungvi_time_ago($row->created_at).'</small> <ion-icon name="people"></ion-icon></div>
                             </div>
                         </div>
                     </div>
                     '.$legend.'
                     '.$content.'
                     <div class="p-4 space-y-3"> 
                         <div class="flex items-center space-x-3 pt-2">
                         '.display_event_likers_v2($row->id, $_SESSION['user_id'], get_session('ev_i')).'
                         </div>
                         <div class="flex space-x-4 lg:font-bold">
                             '.$like.'
                             <a href="#" class="flex items-center space-x-2">
                                 <div class="p-2 rounded-full text-black lg:bg-gray-100">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                 </div>
                                 <div></div>
                             </a>
                         </div>
                     </div>
             
             </div>
                 <!-- Post here -->
                  ';
                $legend = "";
                
               }
    	}
        
        echo $output;
}
