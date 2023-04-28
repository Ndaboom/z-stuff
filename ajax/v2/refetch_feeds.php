<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
require('../../includes/adds_functions.php');

if(isset($_POST["limit2"], $_POST["from"]))
  {
  $query = "SELECT U.id user_id,U.name, U.nom2, U.email, U.profilepic,
                          M.id m_id, M.legend,M.user_id ,M.created_at, M.urlMedia, M.urlmedia1, M.add_image1, M.cmprssd_add_image1, M.add_image2, M.cmprssd_add_image2, M.like_count,M.type,M.quote_author,M.place_id,M.from_user_id,M.sub_type
                          FROM users U, microposts M, friends_relationships F
                          WHERE M.user_id = U.id

                          AND

                          CASE
                          WHEN F.user_id1 = :user_id
                          THEN F.user_id2 = M.user_id

                          WHEN F.user_id2 = :user_id
                          THEN F.user_id1 = M.user_id
                          END

                          AND F.status = 2
                          ORDER BY M.created_at DESC LIMIT ".$_POST["from"].", ".$_POST["limit2"]."";
        $statement = $db->prepare($query);
    	$statement->execute([
           'user_id'=>get_session('user_id')
    	]);
    	$result = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();
    	$output= '';
    	if($total_row > 0)
    	{

            foreach ($result as $row)
               {

                 	$query = "
                    SELECT * FROM comments INNER JOIN users ON users.id= comments.user_id
                    WHERE post_id = '".$row->m_id."'
                    ORDER BY comment_id ASC 
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
	 	            
	 	            $latest_comments = '<div class="py-4 space-y-4 dark:border-gray-600" id="display_reactions'.$row->m_id.'">';

	 	            foreach($comments as $comment){
	 	                
	 	            if($comment->user_id == get_session('user_id')){
	 	             $delete_btn = '<a href="" class="text-red-600 delete_comment" id="dcomment'.$comment->comment_id.'" data-poster_id="'.$comment->user_id.'" data-commentid="'.$comment->comment_id.'"> <i class="uil-heart"></i> Delete </a>';   
	 	            }else{
	 	             $delete_btn = "";   
	 	            }
	 	            
	 	            $lastest_comments .='
                   <div class="flex">
                      <div class="w-10 h-10 rounded-full relative flex-shrink-0">
                      <a href="timeline.php?id='.$comment->user_id.'&n='.$comment->name.'"><img src="/'.$comment->profilepic.'" alt="" class="absolute h-full rounded-full w-full"></a>
                      </div>
                      <div>
                          <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">
                              <p class="leading-6">'.convertHashtags(replace_links($comment->comment)).' <urna class="i uil-heart"></urna> <i
                                      class="uil-grin-tongue-wink"> </i> </p>
                              <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>
                          </div>
                          <div class="text-sm flex items-center space-x-3 mt-2 ml-5">
                              <a href="" class="text-blue-600 like_comment" data-poster_id="'.$comment->user_id.'" data-comment="'.$comment->comment.'" data-post="'.$row->m_id.'" data-commentid="'.$comment->comment_id.'"> <i class="uil-heart"></i>'.get_comment_likes($comment->comment_id).' Like </a>
                              '.$delete_btn.'
                              <span> '.zungvi_time_ago($comment->posted_at).' </span>
                          </div>
                      </div>
                  </div>';
                  
	 	            }
	 	            
	 	          $latest_comments .= '</div>';
	 	          
	 	        }else{
	 	            $lastest_comments = '';
	 	        }
               	if(user_has_already_liked_the_micropost($row->m_id)){
                  $like='
                  <a class="flex items-center space-x-2 like" id="unlike'. $row->m_id .'" data-postid="'.$row->m_id.'" data-action="unlike">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#ec5252" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div></div>
                  </a>
                  <a class="flex items-center space-x-2 like" id="like'.$row->m_id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->m_id.'" style="display:none;">
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
                    <a class="flex items-center space-x-2 like" id="like'.$row->m_id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->m_id.'">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke="currentColor" fill="#F3F4F6" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart dark:text-gray-100">
                              <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                          </svg>
                      </div>
                      <div></div>
                  </a>
               	  <a class="flex items-center space-x-2 like" id="unlike'. $row->m_id .'" data-postid="'.$row->m_id.'" data-action="unlike" style="display:none;">
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
               	     if($row->add_image2){
               	     
                     $content = '<div uk-lightbox="">
                                   <div class="grid grid-cols-2 gap-2 p-2">
                   
                                       <a href="/'.$row->urlMedia.'" class="col-span-2">  
                                           <img src="/'.$row->urlMedia.'" alt="" class="rounded-md w-full lg:h-76 object-cover" style="max-height:300px;">
                                       </a>
                                       <a href="/'.$row->add_image1.'">  
                                           <img src="/'.$row->cmprssd_add_image1.'" alt="" class="rounded-md w-full h-full" style="max-height:200px;">
                                       </a>
                                       <a href="/'.$row->add_image2.'" class="relative">  
                                           <img src="/'.$row->cmprssd_add_image2.'" alt="" class="rounded-md w-full h-full" style="max-height:200px;">
                                       </a>
                  
                                   </div>
                               </div>';
                     
                     }else if(!$row->add_image2 && $row->add_image1){
                     
                     $content = '<div uk-lightbox="">
                                   <div class="grid grid-cols-2 gap-2 p-2">
                   
                                       <a href="/'.$row->urlMedia.'">  
                                           <img src="/'.$row->urlMedia.'" alt="" class="rounded-md w-full h-full">
                                       </a>
                                       <a href="/'.$row->add_image1.'">  
                                           <img src="/'.$row->cmprssd_add_image1.'" alt="" class="rounded-md w-full h-full">
                                       </a>
                                   </div>
                               </div>';
               
                     }else{
                     
                     $content = '<div uk-lightbox>
                                  <a href="/'.$row->urlMedia.'">  
                                      <img src="/'.$row->urlMedia.'" alt="" class="max-h-96 w-full object-cover">
                                  </a>
                                 </div>';
                     
                     }
               	}
               	else
               	{
                   $content = '';
               	}

                if(!a_post_has_already_been_shared($_SESSION['user_id'],$row->m_id))
                {
                  $repost_btn = '
                  <a class="flex items-center space-x-2" id="repost'. $row->m_id .'" uk-toggle="target: #shareModal'.$row->m_id.'">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                         <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>
                      </div>
                      <div> '.post_shares_count($row->m_id).'</div>
                  </a>
                   ';
                }
                else
                {
                   $repost_btn = '
                  <a class="flex items-center space-x-2" id="repost'. $row->m_id .'" uk-toggle="target: #shareModal'.$row->m_id.'">
                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#28A745" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>
                      </div>
                      <div> '.post_shares_count($row->m_id).'</div>
                  </a>
                   ';
                }

                $shareModal = '
                <!-- Sharing post modal -->
    <div id="shareModal'.$row->m_id.'" class="share-modal" uk-modal>
        <div
            class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical relative shadow-2xl uk-animation-slide-bottom-small">
    
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> Share post </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2"  type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            
            <!-- Content -->
            <a href="" class="flex items-center m-15 px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800 share_publication" data-poster="'.$row->user_id.'" data-media="'.$row->urlMedia.'" data-legend="'.$row->legend.'" data-postid="'.$row->m_id.'" data-post_type="'.$row->type.'" data-quote_author="'.$row->quote_author.'" id="sharing_button'.$row->m_id.'">Share with friends</a>   
            <small class="text-blue-600" style="display:none;" id="share_pending'.$row->m_id.'"> posting...please wait</small>
            <span class="text-green-600" style="display:none;" id="share_confirmation'.$row->m_id.'"> Shared!</span>
            <!-- End Content -->
        </div>
    </div>
    <!-- Sharing post modal -->
                ';

                if($row->type == "profile_updated")
                {
                  $type ='<span> updated his profile picture</span>';
                }
                elseif($row->type == "quotes")
                {
                 $type='<span> added a quote </span>';
                 $content = '<div class="p-3">
                             <h3 style = "font-family:georgia,garamond,serif;font-size:26px;"><i class="fas fa-quote-left"></i> '. convertHashtags(nl2br($row->legend)).'</h3>
                            </div>
                            <div class="text-right">
                            <p>- '.nl2br($row->quote_author).'</p>&nbsp
                            </div>';
                }
                elseif($row->type == "cover_updated")
                {
                 $type='<span> updated his cover photo</span>';
                }
                elseif($row->type == "sound")
                {
                 $legend = '<div class="p-3">
                            '.convertHashtags(nl2br(replace_links($row->legend))).'
                          </div>';
                 $type='<span> added a sound</span>';
                 $content = '<div uk-lightbox>
                                  <a href="/'.$row->urlMedia.'">     
                                               <audio controls style="width:100%;">
                                               <source src="/'.$row->urlMedia.'" type="audio/mpeg">
                                               </audio>
                                  </a>
                                </div>
                            ';
                }
                elseif($row->type == "video")
                {
                $legend = '<div class="p-3">
                            '.convertHashtags(nl2br(replace_links($row->legend))).'
                          </div>';
                $type = '<span class="text_box"> added a video</span>';
    
                $content = '
                <div uk-lightbox>
                  <a href="/'.$row->urlMedia.'">
                      <video controls preload="meta-data" class="max-h-96 w-full object-cover" loop poster="">
                        <source src="/'.$row->urlMedia.'">
                        </source>
                     </video>
                   </a>
                </div>
                ';
                }
                elseif($row->type == "shared_a_place")
                {
                 $place = find_place_by_id($row->place_id);
                 $type='<span> shared the place <a href="homeplace.php?pl_i='.$place->id.'">'.$place->place_name.'</a> </span>';
                }
                elseif($row->type == "shared_post") {
                  $from = find_user_by_id($row->from_user_id);
                  $type='<span> shared a post from <a href="timeline.php?id='.$row->from_user_id.'" >'.$from->name.'</a> </span>';
                  $legend = '';
                  if($row->sub_type == "quotes"){

                  $content = '<div class="p-3">
                             <h3 style = "font-family:georgia,garamond,serif;font-size:26px;"><i class="fas fa-quote-left"></i> '. convertHashtags(nl2br($row->legend)).'</h3>
                            </div>
                            <div class="text-right">
                            <p>- '.nl2br($row->quote_author).'</p>&nbsp
                            </div>';
                  }elseif($row->sub_type == "sound"){
                    $legend = '<div class="p-3">
                            '.convertHashtags(nl2br(replace_links($row->legend))).'
                          </div>';
                    $content = '<div uk-lightbox>
                                  <a href="/'.$row->urlMedia.'">     
                                               <audio controls style="width:100%;">
                                               <source src="/'.$row->urlMedia.'" type="audio/mpeg">
                                               </audio>
                                  </a>
                                </div>
                            ';
            }elseif($row->sub_type == "video"){
                 $legend = '<div class="p-3">
                            '.convertHashtags(nl2br(replace_links($row->legend))).'
                          </div>';
                 $content = '
                    <div uk-lightbox>
                      <a href="/'.$row->urlMedia.'">
                          <video controls preload="meta-data" class="max-h-96 w-full object-cover" loop poster="">
                            <source src="/'.$row->urlMedia.'">
                            </source>
                         </video>
                       </a>
                    </div>
                    ';
            }else {
              $legend = '<div class="p-3">
                            '.convertHashtags(nl2br(replace_links($row->legend))).'
                          </div>';
            }
                }
                else
                {
                  $legend = '<div class="p-3">
                            '.convertHashtags(nl2br(replace_links($row->legend))).'
                          </div>';
                  $type='<span> added a status</span>';
                }

                if(get_session('user_id') == $row->user_id){
                    $modal='<div class="modal fade" id="monModal'.$row->m_id.'">
                         <div class="modal-dialog" >
                               <div class="modal-content">
                                   <div class="modal-body" style="background-color: #e9ebee;">
                                  <a href="delete_micropost.php?id='. $row->id .'" ><div class="alert text-danger"><i class="far fa-trash-alt"></i> Delete</div></a>
                                  </div>
                                 </div>
                              </div>
                </div>';
                }else{
                    $modal='
                    <div class="modal fade" id="monModal'.$row->m_id.'">
                         <div class="modal-dialog" >
                               <div class="modal-content">
                                  <div class="modal-body text-center">
                                  <div class="input-group mb-3">
                                    <div class="input-group-append">
                                      <span class="input-group-text"><i class="fas fa-link"></i></span>
                                    </div>
                                    <input type="text" name="post_link" class="form-control" value="https://zungvi.com/android/postviewer.php?p_i='.$row->m_id.'" readonly/>
                                  </div>
                                  <div class="card" id="abox'.$row->m_id.'">
                                     <div class="card-body">
                                     <a class="btn btn-link text-primary not_interested" data-post_id="'.$row->m_id.'"> Not interested</a>
                                     </div>
                                  </div>

                                  <div class="card" id="moreBox'.$row->m_id.'" style="display:none;">
                                      <div class="card-body">
                                      <div class="text-center">
                                      <a class="btn btn-link text-danger remove_friend" data-post_id="'.$row->m_id.'" data-user_id="'.$row->user_id.'"> Remove '. e($row->name).' '.e($row->nom2).' from my friends</a>
                                      </div><br>
                                      <div class="text-center">
                                      <a class="btn btn-link text-primary cancel_button" data-post_id="'.$row->m_id.'">Cancel</a>
                                      </div>
                                      </div>
                                  </div>
                                  <div class="card" id="rsuccess'.$row->m_id.'" style="display:none;">
                                  <div class="card-body">
                                  <span class="text-success" style="font-size:16px;"> <a href="timeline.php?id='.$row->user_id.'">'. e($row->name).' '.e($row->nom2).'</a> has been removed from your friends</span>
                                  </div>
                                  </div>
                                  </div>
                                 </div>
                              </div>
                    </div>
                    ';
                }
                	$query1 = "
                    SELECT * FROM micropost_like
                    WHERE micropost_id = '".$row->m_id."'
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
                             <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                                    <a href="timeline.php?id='.$luser->id.'" href="timeline.php?id='.$luser->id.'"iv class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="/'.$luser->profilepic.'" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline.php?id='.$luser->id.'" class="text-base font-semibold capitalize">  '.$luser->name.' '.$luser->nom2.' </a>
                                        <div class="text-sm text-gray-500 mt-0.5"> '.zungvi_time_ago($liker->created_at).'</div>
                                    </div>
                             </div>
	 	                    ';
	 	                     }
	 	                }
                $likeModal='
                <div id="liked-modal'.$row->m_id.'" class="liked-modal" uk-modal>
                    <div
                        class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
                
                        <div class="text-center py-4 border-b">
                            <h3 class="text-lg font-semibold"> Liked by </h3>
                            <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
                        </div>
                        <div class="bsolute bottom-0 p-4 w-full">
                            '.$persons.'
                        </div>
                    </div>
                </div>
                 ';
                 
                 //Check is the post is already added to favorites collection
                  $fav_btn = '';
                  if(is_favorite(get_session('user_id'), $row->m_id)){
                  $fav_btn = '';
                  }else{
                  $fav_btn = '<li> 
                                    <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800 add_favorites" data-post_id="'.$row->m_id.'" data-user_id="'.$row->user_id.'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>  Add to favorites 
                                    </a> 
                                </li>';
                  }
                  // End Check
                
                  $output .= '
                  '.$shareModal.'
                  '. $likeModal.'
                 <!-- Post here -->
                 <div class="post_box bg-white shadow border border-gray-100 rounded-lg dark:bg-gray-900 lg:mx-0 uk-scrollspy-inview uk-animation-slide-bottom" id="post_box'.$row->m_id.'">
                          <div class="flex justify-between items-center lg:p-4 p-2.5">
                              <div class="flex flex-1 items-center space-x-4">
                                  <a href="#">
                                      <img src="/'.e($row->profilepic).'" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                                  </a>
                                  <div class="flex-1 font-semibold capitalize">
                                      <a href="timeline.php?id='.$row->user_id.'" class="text-black"> '.e($row->name).' '.e($row->nom2).' </a>'.$type.'
                                      <div class="text-gray-700 flex items-center space-x-2"> <small class="text-secondary">'.zungvi_time_ago($row->created_at).'</small> <ion-icon name="people"></ion-icon></div>
                                  </div>
                              </div>
                            <div>
                              <a href="#"> <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg> </a>
                              <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                              uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
                            
                                  <ul class="space-y-1">
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 text-red-800 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>  Inbox
                                        </a> 
                                    </li>

                                    '.$fav_btn.'
                                    <li>
                                      <hr class="-mx-2 my-2 dark:border-gray-800">
                                    </li>
                                    <li> 
                                        <a href="" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600 remove_friend" data-post_id="'.$row->m_id.'" data-user_id="'.$row->user_id.'">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>  Block '.$row->name.' '.$row->nom2.'
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
                             '.display_likers_v2($row->m_id).'
                             </div>
                              <div class="flex space-x-4 lg:font-bold">
                                  '.$like.'
                                  <a href="#" class="flex items-center space-x-2">
                                      <div class="p-2 rounded-full text-black lg:bg-gray-100">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                      </div>
                                      <div></div>
                                  </a>
                                  '.$repost_btn.'
                              </div>
                             '.$lastest_comments.'
                              '.$more_comments.'
                              <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                                  <input placeholder="Add your Comment.." id="comment_box'.$row->m_id.'" class="comment_box bg-transparent max-h-10 shadow-none px-5" data-post_id="'.$row->m_id.'">
                                  <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                      <a href="" class="py-3 px-4 post_comment" data-poster="'.$row->user_id.'" id="cbtn'.$row->m_id.'" style="display:none; font-size:15px;">Post</a>
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
