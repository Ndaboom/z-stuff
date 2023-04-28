<?php
session_start();
//Forum feeds
require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
        
        $query = "SELECT * FROM forum_subject
                  WHERE forum_id= :forum_id
                  ORDER BY created_at DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
        $statement = $db->prepare($query);
    	$statement->execute([
           'forum_id'=>get_session('fr_i')
    	]);
    	$result = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	
    	if($total_row > 0)
    	{
            foreach ($result as $row)
               {       
               	if(user_has_already_liked_the_forumpost($row->id)){
                  $like='
                  <a class="flex items-center space-x-2 like" id="unlike'. $row->id .'" data-postid="'.$row->id.'" data-forumpostId="'.$row->id.'" data-action="unlike">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#2A41E8" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div> Unlike</div>
                  </a>
                  <a class="flex items-center space-x-2 like" id="like'.$row->id .'" data-action="like" data-postid="'.$row->id.'" data-poster="'.$row->poster_id.'" data-forumpostId="'.$row->id.'" style="display:none;">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div> Like</div>
                  </a>
                  <a href="#" class="flex items-center space-x-2">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                              <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                          </svg>
                      </div>
                      <div> Comment</div>
                  </a>
                  ';
               	}else{
               		$like='
                    <a class="flex items-center space-x-2 like" id="unlike'. $row->id .'" data-postid="'.$row->id.'" data-forumpostId="'.$row->id.'" data-action="unlike" style="display:none;">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#2A41E8" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div> Unlike</div>
                  </a>
                  <a class="flex items-center space-x-2 like" id="like'.$row->id .'" data-postid="'.$row->id.'" data-action="like" data-poster="'.$row->poster_id.'" data-forumpostId="'.$row->id.'">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="currentColor" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div> Like</div>
                  </a>
                  <a href="#" class="flex items-center space-x-2">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" width="22" height="22" class="dark:text-gray-100">
                              <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                          </svg>
                      </div>
                      <div> Comment</div>
                  </a>
               		';
               	}
               	
               	
                if($row->type == "file_post"){
                   $content ='<img class="card-img-top rounded-0 img-thumbnail" src="/images/File.png" style="width:15%;margin-left:42%;" alt="">
                    <a class="btn btn-outline-primary" href="/'.$row->urlmedia1.'" style="width:100%;" download>Download</a>
                    '; 
                    $legend = '<div class="p-3">
                            '.convertHashtags(nl2br(replace_links($row->subject))).'
                          </div>';    
                    $type ='<span> shared a document</span>';
                }
                
               	if($row->type == "subject")
               	{
               	     if($row->urlmedia1 != ""){
               	         $content = '<div uk-lightbox>
                                      <a href="/'.$row->urlmedia1.'">  
                                          <img src="/'.$row->urlmedia1.'" alt="" class="max-h-96 w-full object-cover">
                                      </a>
                                     </div>';
               	     }else{
               	      $content = '';   
               	     }
                     $legend = '<div class="p-3">
                                '.convertHashtags(nl2br(replace_links($row->subject))).'
                                </div>';
                     $type ='<span> added a new topic</span>';
                     
                     // ======= Fetching subject reactions ==========
                     $reactions_data = getUserForumReaction($row->id);
                     $reactions = '';
                       	
                       	if(count($reactions_data) != 0){
                       	foreach($reactions_data as $reaction){
        	 	            
        	 	            $owner = find_user_by_id($reaction->user_id);
        	 	            
        	 	            //Check if user has already validate a reaction
        	 	            if(already_validate($reaction->id)){
        	 	                $validate_btn = '<a href="" class="validate" id="validate'.$reaction->id.'" style="display:none;"> <i class="far fa-thumbs-up"></i> Validate </a>
        	 	                <a href="" class="text-red-600 validated" id="validated'.$reaction->id.'"> <i class="far fa-thumbs-up"></i>You validate </a>';
        	 	            }else{
        	 	                $validate_btn = '<a href="" class="validate" id="validate'.$reaction->id.'"> <i class="far fa-thumbs-up"></i> Validate </a>
        	 	                                 <a href="" class="text-red-600 validated" id="validated'.$reaction->id.'" style="display:none;"> <i class="far fa-thumbs-up"></i>You validate </a>'; 
        	 	            }
        	 	            
        	 	            //Check if user has already denied a reaction
        	 	            if(already_denied($reaction->id)){
        	 	                $denied_btn = '<a href="" class="denied" id="denied'.$reaction->id.'" style="display:none;"> <i class="far fa-thumbs-down"></i> Denied </a>
        	 	                <a href="" class="text-blue-600 denied" id="denieded'.$reaction->id.'"> <i class="far fa-thumbs-down"></i> Denied </a>';
        	 	            }else{
        	 	                $denied_btn = '<a href="" class="denied" id="denied'.$reaction->id.'"> <i class="far fa-thumbs-down"></i> Denied </a>
        	 	                <a href="" class="text-blue-600 denied" id="denieded'.$reaction->id.'" style="display:none;"> <i class="far fa-thumbs-up"></i>Denied </a>';
        	 	            }
        	 	            
        	 	            //Check if a user is already satisfied with a reaction
        	 	            if(already_satisfied($reaction->id)){
        	 	                $satisfied_btn = '<a href="" class="satisfied" id="satisfieded'.$reaction->id.'" style="display:none;"><i class="far fa-smile"></i> Satisfied</a>
        	 	                <a href="" class="text-green-600 satisfied" id="satisfied'.$reaction->id.'"> <i class="far fa-smile"></i> Satisfied </a>';
        	 	            }else{
        	 	                $satisfied_btn = '<a href="" class="satisfied" id="satisfied'.$reaction->id.'"><i class="far fa-smile"></i> Satisfied</a>
        	 	                <a href="" class="text-green-600 satisfied" id="satisfieded'.$reaction->id.'" style="display:none;"> <i class="far fa-smile"></i> Satisfied </a>';
        	 	            }
        	 	            
        	 	            $reactions .='
                           <div class="flex">
                              <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                                  <img src="/'.$owner->profilepic.'" alt="" class="absolute h-full rounded-full w-full">
                              </div>
                              <div>
                                  <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                                      <p class="leading-6">'.convertHashtags(replace_links($reaction->content_text)).' <urna class="i uil-heart"></urna> <i
                                              class="uil-grin-tongue-wink"> </i> </p>
                                      <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                                  </div>
                                  <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                                      '.$validate_btn.'
                                      '.$denied_btn.'
                                      '.$satisfied_btn.'
                                      <span> '.zungvi_time_ago($reaction->created_at).' </span>
                                  </div>
                                  <div class="text-sm flex items-center space-x-3 mt-2 ml-5" id="likers_'.$reaction->id.'">
                                  '.display_validations($reaction->id).'
                                  </div>
                              </div>
                          </div>
                          
                          ';
                          
        	 	        }
        	 	            
                       	}else{
                       	  $reactions = ''; 
                       	}
                     // ======= End Fetching reactions process ===============
                      $like = '';
               	}
               	else
               	{
                    $legend = '<div class="p-3">
                                '.convertHashtags(nl2br(replace_links($row->subject))).'
                              </div>';
                    $type = '<span> added a status</span>';
               	}
                  
                  $current_user = find_user_by_id($row->poster_id);
                  
                  $output .= '
                 <!-- Post here -->
                 <div class="bg-white shadow border border-gray-100 rounded-lg dark:bg-gray-900 lg:mx-0 uk-animation-slide-bottom-small" id="'.$row->id.'">
                          <div class="flex justify-between items-center lg:p-4 p-2.5">
                              <div class="flex flex-1 items-center space-x-4">
                                  <a href="#">
                                      <img src="/'.e($current_user->profilepic).'" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                  </a>
                                  <div class="flex-1 font-semibold capitalize">
                                      <a href="#" class="text-black"> '.e($current_user->name).' '.e($current_user->nom2).' </a>'.$type.'
                                      <div class="text-gray-700 flex items-center space-x-2"> <small class="text-secondary">'.zungvi_time_ago($row->created_at).'</small> <ion-icon name="people"></ion-icon></div>
                                  </div>
                              </div>
                            <div>
                              <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                              <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                              uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                            
                                  <ul class="space-y-1">
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                         <i class="uil-share-alt mr-1"></i> Share
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                         <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                         <i class="uil-comment-slash mr-1"></i>   Disable comments
                                        </a> 
                                    </li> 
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                         <i class="uil-favorite mr-1"></i>  Add favorites 
                                        </a> 
                                    </li>
                                    <li>
                                      <hr class="-mx-2 my-2 dark:border-gray-800">
                                    </li>
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                         <i class="uil-trash-alt mr-1"></i>  Delete
                                        </a> 
                                    </li>
                                  </ul>
                              
                              </div>
                            </div>
                          </div>
                          '.$legend.'
                          '.$content.'
                          <div class="p-4 space-y-3"> 
                             <div class="flex items-center space-x-3 pt-2">
                             '.display_forum_likers($row->id).'
                             </div>
                              <div class="flex space-x-4 lg:font-bold">
                                  '.$like.'
                              </div>
                              <div id="display_reactions'.$row->id.'">
                              '.$reactions.'
                              </div>
                              <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                                  <input placeholder="Your reaction.." class="comment_box bg-transparent max-h-10 shadow-none px-5" id="comment_box'.$row->id.'" data-post_id="'.$row->id.'">
                                  <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                      <a href="" class="py-3 px-4 post_comment" id="cbtn'.$row->id.'" data-post_type="'.$row->type.'"  style="display:none; font-size:15px;">Post</a>
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
