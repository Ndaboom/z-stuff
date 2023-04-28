<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
        $q=$db->prepare('SELECT * FROM microposts WHERE user_id=? ORDER BY -created_at');
	    $q->execute([get_session('him')]);
        $row=$q->fetchAll(PDO::FETCH_OBJ);
        
        $user=find_user_by_id(get_session('him'));
        $user_connected=find_user_by_id(get_session('user_id'));

	 	$output='';
	 	
	 	foreach($row as $data)
	 	{
	 	   if(user_has_already_liked_the_micropost($data->id)){
                  $like='
                  <button type="button" class="btn btn-zung btn-block btn-sm like" id="unlike'. $data->id .'" data-action="unlike"><i class="far fa-heart" aria-hidden="true"></i> Unlike</button>
                  ';
        }
        else
        {
               		$like='
                    <button type="button" class="btn btn-zung btn-block btn-sm like" id="like'.$data->id .'" data-action="like" data-poster="'.$data->user_id.'" data-postid="'.$data->id.'"><i class="far fa-heart" aria-hidden="true"></i> like</button>
               		';
        }

        if($data->urlMedia !=null && $data->type != "sound")
               	{
                     $media='<a href="postviewer.php?p_i='.$data->id.'"><img class="img-thumbnail img-responsive" src="'.$data->urlMedia.'" alt=":("></a>';                        
               	}
        	elseif($data->urlMedia != null && $data->type == "sound")
               	{
                   $media='<div class="row">
                            <div class="col-md-2">
                                <h3 style="color: #44717C; padding:10px;"><i class="fas fa-headphones-alt"></i></h3> 
                            </div>
                            <div class="col-md-10">
                                   <audio controls>
                                   <source src="'.$data->urlMedia.'" type="audio/mpeg">
                                   </audio><br>
                            </div>
                            </div>
                             <div class="card-body pt-0 pb-2 text-center" style="font-style: italic;">
                               '.nl2br($data->legend).'  
                            </div>';
               	}
               	elseif($data->urlMedia != null && $data->type == "video")
                {
                
                $type = '<span style="color: black; font-style: italic;" class="text_box"> added a video</span>';
                $media = '<video controls preload="meta-data" loop poster="">
                            <source src="'.$row->urlMedia.'">
                            </source>
                         </video>';
                         
                }
               	else{
               	    $media='';
               	}
        if($data->user_id == get_session('user_id') && $data->type == "quotes")
        {
            $you='
                                    <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="/'. e($user->profilepic) .'" alt="" 
                                            style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;"/>
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="profile.php?id='.e($data->user_id).'" style="font-style: italic;">You </a> <span style="color: black; font-style: italic;"> added a quotes</span>
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $data->created_at .'">'.zungvi_time_ago($data->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                 ';
        }elseif($data->user_id == get_session('user_id') && $data->type == "profile_updated"){
           $you='
                                    <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="/'. e($user->profilepic) .'" alt="" 
                                            style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;"/>
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="profile.php?id='.e($data->user_id).'" style="font-style: italic;">You </a> <span style="color: black; font-style: italic;"> updated your profile</span>
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $data->created_at .'">'.zungvi_time_ago($data->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                 ';   
        }
        else
        {
        	$you='
        	                        <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="'. e($user->profilepic) .'" alt="" 
                                            style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;"/>
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="profile.php?id='.e($data->user_id).'" style="font-style: italic;">'. e($user->name).' '.e($user->nom2).'</a> <span style="color: black; font-style: italic;"> added a status</span>
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $data->created_at .'">'.zungvi_time_ago($data->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    ';
        }
        
        if($data->type == "quotes")
        {
          $author='
          <div class="text-right">
          '.$data->quote_author.'
          </div>
          ';  
        }else{
          $author='';  
        }
        	$query1 = "
                    SELECT * FROM micropost_like 
                    WHERE micropost_id = '".$data->id."'
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
	 	                    <div class="row">
	 	                    <div class="col-md-2"><img src="'.$luser->profilepic.'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" class="rounded-circle"/></div>
	 	                    <div class="col-md-6">'.$luser->name.' '.$luser->nom2.'</div>
	 	                    <div class="col-md-4">'.zungvi_time_ago($liker->created_at).'</div>
	 	                    </div>
	 	                    ';
	 	                     }
	 	                }
                $likeModal='<div class="modal fade" id="likesModal'.$data->id.'">
                               <div class="modal-dialog" >
                                 <div class="modal-content">
                                 <div class="modal-header" style="color:white;">
                                 <button type="button" class="close" data-dismiss="modal" style="float:right;">X</button>
                                 </div>
                                   <div class="modal-body">
                                  '.$persons.'
                                   </div>     
                                 </div>
                              </div>
                </div>
                 ';
                

	 	$output .='
	 	 '.$likeModal.'
                   <div class="card my-3" style="width=200px; height=200px;">
                                      <div class="card-header border-0 py-2">
                                         '.$you.'
                                    <div class="dropdown" style="font-style: italic;">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                            <a class="dropdown-item" href="delete_micropost.php?id='. $data->id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0 pb-2" style="font-style: italic;">
                                
                            </div>
                             '. nl2br(replace_links($data->legend)) .'
                             '.$media.' '.$author.'
                            <div class="card-footer border-0 p-0">
                                <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                    <div id="displayer_'. $data->id .'">
                                        '.likers_updater($data->id,$db).'  
                                    </div>
                                    <div id="likers_'. $data->id .'" data-toggle="modal" data-target="#likesModal'.$data->id.'">
                                        '.display_likers($data->id).'
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center my-1">
                                    <div class="col">
                                 '.$like.'
                                    </div>
                                    <div class="col">
                           <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$data->id.'">'.count_comment($db,$data->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                    </div>
                                    <div class="col">
                                        
                                    </div>
                                </div>
                                <div id="comment_form'.$data->id.'" style="display:none;">
                                 <span id="old_comment'.$data->id.'"></span>
                                 <div class="form-group mb-0">
                                 <textarea name="comment" class="form-group border-0" id="comment'.$data->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                 </div>
                                 <div class="form-group" align="right">
                                 <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$data->user_id.'">Comment </button>
                                 </div>
                                </div>
                            </div>
                        </div>
	 	          ';
         
	 	}
	 	$output .='';
	 	echo $output;

