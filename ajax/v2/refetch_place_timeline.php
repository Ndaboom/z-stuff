<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit2"], $_POST["from"]))
  {
      
    $query = "SELECT * FROM placeposts WHERE place_id = :place_id ORDER BY created_at DESC LIMIT ".$_POST["from"].", ".$_POST["limit2"]."";
    $statement = $db->prepare($query);
    $statement->execute([
   'place_id'=>get_session('pl_i')
    ]);

    $result = $statement->fetchAll(PDO::FETCH_OBJ);
    $total_row = $statement->rowCount();
    $output= '';
    	if($total_row > 0)
    	{

            foreach ($result as $row)
               {

                //Fetch comments
                $query = "
                    SELECT * FROM place_comments
                    WHERE post_id = '".$row->id."'
                    ORDER BY created_at ASC 
                    LIMIT 2
	 	           ";
	 	           	$statement = $db->prepare($query);
                    if($statement->execute())
                    {
                        $comments = $statement->fetchAll(PDO::FETCH_OBJ);
                    }
	 	            
	 	            $lastest_comments = '';

                     if(count($comments) != 0){
	 	            
                        if(count($comments) > 2){
                            $more_comments = '<a href="#" class="hover:text-blue-600 hover:underline">  View more Comments </a>';
                        }else{
                            $more_comments = '';
                        }
                        
                        $latest_comments = '<div class="py-4 space-y-4 dark:border-gray-600" id="display_reactions'.$row->id.'">';
   
                        foreach($comments as $comment){
                            
                        if($comment->user_id == get_session('user_id')){
                         $delete_btn = '<a href="" class="text-red-600 delete_comment" id="dcomment'.$comment->comment_id.'" data-poster_id="'.$comment->user_id.'" data-commentid="'.$comment->comment_id.'"> <i class="uil-heart"></i> Delete </a>';   
                        }else{
                         $delete_btn = "";   
                        }

                        $comment_owner = find_user_by_id($comment->user_id);
                        
                        $lastest_comments .='
                      <div class="flex">
                         <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                             <img src="/'.$comment_owner->profilepic.'" alt="" class="absolute h-full rounded-full w-full">
                         </div>
                         <div>
                             <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                 <p class="leading-6">'.convertHashtags(replace_links($comment->content_text)).' <urna class="i uil-heart"></urna> <i
                                         class="uil-grin-tongue-wink"> </i> </p>
                                 <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                             </div>
                             <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                <!-- <a href="" class="text-blue-600 like_comment" data-poster_id="'.$comment->user_id.'" data-comment="'.$comment->content_text.'" data-post="'.$row->id.'" data-commentid="'.$comment->id.'"> <i class="uil-heart"></i> Like </a> -->
                                 '.$delete_btn.'
                                 <span> '.zungvi_time_ago($comment->created_at).' </span>
                             </div>
                         </div>
                      </div>';
                     
                        }
                        
                      $latest_comments .= '</div>';
                      
                    }else{
                      $lastest_comments = '';
                    }

                //Fetch comments
	 	        
               	if(record_check('placepost_like', 'user_id', $_SESSION['user_id'], 'placepost_id', $row->id)){
                  $like='
                  <a class="flex items-center space-x-2 like" id="unlike'. $row->id .'" data-placepost_id="'.$row->id.'" data-action="unlike" data-place_id="'.get_session('pl_i').'">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#ec5252" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div></div>
                  </a>
                  <a class="flex items-center space-x-2 like" id="like'.$row->id .'" data-action="like" data-poster="'.$row->user_id.'" data-placepost_id="'.$row->id.'" data-place_id="'.get_session('pl_i').'" style="display:none;">
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
                    <a class="flex items-center space-x-2 like" id="like'.$row->id .'" data-action="like" data-poster="'.$row->user_id.'" data-placepost_id="'.$row->id.'" data-place_id="'.get_session('pl_i').'">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke="currentColor" fill="#F3F4F6" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div></div>
                  </a>
               	  <a class="flex items-center space-x-2 like" id="unlike'. $row->id .'" data-place_id="'.get_session('pl_i').'" data-placepost_id="'.$row->id.'" data-action="unlike" style="display:none;">
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
                     
                        if($row->compressed_images){
                            $posts = explode(",",$row->compressed_images);
                            if(count($posts) == 2 && $posts[1] == ""){
                                $content = '<div uk-lightbox="">
                                    <div class="grid grid-cols-2 gap-2 p-2">
                                        <a href="/'.$row->urlMedia.'">  
                                            <img src="/'.$row->urlMedia.'" alt="" class="rounded-md w-full h-full">
                                        </a>
                                        <a href="/'.$posts[0].'">  
                                            <img src="/'.$posts[0].'" alt="" class="rounded-md w-full h-full">
                                        </a>
                                    </div>
                                </div>';
                                }elseif(count($posts) == 2 && $posts[1] != ""){
                                    $content = '<div uk-lightbox="">
                                                    <div class="grid grid-cols-2 gap-2 p-2">
                                                        <a href="/'.$row->urlMedia.'" class="col-span-2">  
                                                            <img src="/'.$row->urlMedia.'" alt="" class="rounded-md w-full lg:h-76 object-cover" style="max-height:300px;">
                                                        </a>
                                                        <a href="/'.$posts[0].'">  
                                                            <img src="/'.$posts[0].'" alt="" class="rounded-md w-full h-full" style="max-height:200px;">
                                                        </a>
                                                        <a href="/'.$posts[1].'" class="relative">  
                                                            <img src="/'.$posts[1].'" alt="" class="rounded-md w-full h-full" style="max-height:200px;">
                                                        </a>
                                                    </div>
                                                </div>';
                                }
                            
                        }else{
                            if($row->type == "video"){
                                $content = '<div uk-lightbox>
                                <a href="/'.$row->urlMedia.'">  
                                    <video controls preload="meta-data" class="max-h-96 w-full object-cover" loop poster="">
                                    <source src="/'.$row->urlMedia.'">
                                    </source>
                                    </video>
                                </a>
                                </div>';
                            }else{
                                $content = '<div uk-lightbox>
                                <a href="/'.$row->urlMedia.'">  
                                    <img src="/'.$row->urlMedia.'" alt="" class="max-h-96 w-full object-cover">
                                </a>
                                </div>';
                            }
                        }
                    }else{
                    $content = '';
                    }
                
                   $query1 = "
                   SELECT * FROM placepost_like
                   WHERE placepost_id= '".$row->id."'
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
                  
                  $current_place = find_place_by_id($row->place_id);
                  $legend = '<div class="p-3">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</div>'; 
                  if($_SESSION['user_id'] == $row->user_id){
                    $buttons = '
                          <li> 
                              <a href="" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600 remove_post" data-post_id="'.$row->id.'" data-place_id="'.$row->place_id.'" data-user_id="'.$post->user_id.'">       
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>  Remove
                              </a> 
                          </li>
                          <li> 
                              <a href="" class="flex items-center px-3 py-2 hover:bg-blue-100 hover:text-blue-500 rounded-md dark:hover:bg-blue-600 copy_link" data-post_id="'.$row->id.'">                     
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg> Link
                              </a> 
                          </li>
                  '; 
                }else{
                  $buttons = '
                  <li> 
                      <a href="" class="flex items-center px-3 py-2 hover:bg-blue-100 hover:text-blue-500 rounded-md dark:hover:bg-blue-600 copy_link" data-post_id="'.$row->id.'">                     
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg> Link
                      </a> 
                  </li>';
                }
                  
                 $output .= '
                 <!-- Post here -->
                 <div class="bg-white shadow border border-gray-100 rounded-lg dark:bg-gray-900 lg:mx-0 uk-animation-slide-bottom-small" id="post_box'.$row->id.'">
                 <div class="flex justify-between items-center lg:p-4 p-2.5">
                         <div class="flex flex-1 items-center space-x-4">
                             <a href="#">
                                 <img src="/'.e($current_place->image).'" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                             </a>
                             <div class="flex-1 font-semibold capitalize">
                                 <a href="#" class="text-black"> '.e($current_place->place_name).' </a>
                                 <div class="text-gray-700 flex items-center space-x-2"> <small class="text-secondary">'.zungvi_time_ago($row->created_at).'</small> <ion-icon name="people"></ion-icon>
                                 </div>
                             </div>
                             <div>
                              <a href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg> </a>
                              <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                              uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                                  <ul class="space-y-1">
                                    '.$buttons.'
                                  </ul> 
                              </div>
                            </div>
                         </div>
                     </div>
                     '.$legend.'
                     '.$content.'
                     <div class="p-4 space-y-3"> 
                         <div class="flex items-center space-x-3 pt-2">
                         '.display_placepost_likers_v2($row->id).'
                         </div>
                         <div class="flex space-x-4 p-2 lg:font-bold">
                             '.$like.'
                             <a href="#" class="flex items-center space-x-2">
                                 <div class="p-2 rounded-full text-black lg:bg-gray-100">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                 </div>
                                 <div></div>
                             </a>
                         </div>
                         '.$lastest_comments.'
                         '.$more_comments.'
                         <div class="bg-gray-100 rounded-full m-2 relative dark:bg-gray-800 border-t">
                                  <input placeholder="Your Comment..." id="comment_box'.$row->id.'" class="comment_box bg-transparent max-h-10 shadow-none px-5" data-post_id="'.$row->id.'">
                                  <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                      <a href="" class="py-3 px-4 post_comment" data-poster="'.$row->user_id.'" id="cbtn'.$row->id.'" style="display:none; font-size:15px;">Post</a>
                                  </div>
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
