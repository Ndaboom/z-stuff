<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);
        $q=$db->prepare('SELECT * FROM microposts WHERE id=?');
	    $q->execute([get_session('p_i')]);
        $data=$q->fetch(PDO::FETCH_OBJ);
        $user=find_user_by_id($data->user_id);

	 	$output='';
	 	if(user_has_already_liked_the_micropost($data->id)){
                  $like='
                  <button type="button" class="btn btn-zung btn-block btn-sm like" id="unlike'. $data->id .'" data-action="unlike"><i class="far fa-heart" aria-hidden="true"></i> Unlike</button>
                   <button type="button" class="btn btn-zung btn-block btn-sm like" id="like'.$data->id .'" data-action="like" data-poster="'.$data->user_id.'" data-postid="'.$data->id.'" style="display:none;"><i class="far fa-heart" aria-hidden="true" ></i> like</button>
                  ';
        }
        else
        {
               		$like='
                    <button type="button" class="btn btn-zung btn-block btn-sm like" id="like'.$data->id .'" data-action="like" data-poster="'.$data->user_id.'" data-postid="'.$data->id.'"><i class="far fa-heart" aria-hidden="true"></i> like</button>
                    <button type="button" class="btn btn-zung btn-block btn-sm like" id="unlike'. $data->id .'" data-action="unlike" style="display:none;"><i class="far fa-heart" aria-hidden="true"></i> Unlike</button>
               		';
        }
        
        $buttons_box = '';
        $reaction_box = '';
        $title = '';
        if(get_session('user_id'))
        {
        $reaction_box = '
                        <div class="d-flex justify-content-between align-items-center my-1">
                                    <div class="col">
                                 '.$like.'
                                    </div>
                                    <div class="col">
                           <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$data->id.'">'.count_comment($db,$data->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                    </div>
                                    <div class="col">
                                        
                                    </div>
                                </div>';
        }else
        {
        $buttons_box = '
        <div class="d-flex justify-content-between align-items-center" style="padding :10px;">
        <div>
        <a class="btn btn-outline-primary" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
        </div>
        <div>
        <a class="btn btn-outline-success" href="inscription.php"><i class="fas fa-user-plus"></i> Sign up</a>
        </div>
        </div>
        ';
        $title = '<div class="text-center">
	 	          <span><b class="text-primary" style="font-size:35px;">Zungvi</b><small style="color:black;">.com</small></span><br>
	 	          <small class="text-primary" style="font-style:italic;">Your social network</small>
	 	          </div>';
        }

        if($data->type == "sound")
               	{
               	     $media = 
               	           ' <div style="width:100%;">
                            <div class="text-center" style="width:100%;">
                                <h4 class="text-primary"><i class="fas fa-headphones-alt"></i></h4> 
                            </div>
                            <div class="text-center" style="width:100%;">
                                   <audio controls>
                                   <source src="'.$data->urlMedia.'" type="audio/mpeg">
                                   </audio>
                            </div>
                            </div>
                            <div class="card-body pt-0 pb-2 text-center" style="font-style: italic;">
                               '.nl2br($data->legend).'  
                            </div>';
                     
               	}
               	elseif($data->urlMedia !=null || $data->type == "profile_updated" || $data->type == "cover_updated" || $data->type == "")
               	{
                $media='<a href="imageViewer.php?picname='.$data->urlMedia.'"><img class="img-thumbnail img-responsive" src="'.$data->urlMedia.'" alt="Image not uploaded successfuly"></a>';
                     $legend = ''.nl2br(replace_links($data->legend)).'';  
               	}
        
        if($data->user_id == get_session('user_id'))
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
                                                <a href="profile.php?id='.e($data->user_id).'" style="font-style: italic;">You added</a> <span style="color: black; font-style: italic;"> added a status</span>
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

	 	$output .='
	 	         '.$title.'
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

                             '.$legend.'
                             '.$media.'
                            <div class="card-footer border-0 p-0">
                                <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                    <div id="displayer_'. $data->id .'">
                                        '.likers_updater($data->id,$db).'  
                                    </div>
                                    <div id="likers_'. $data->id .'">
                                        '.display_likers($data->id).'
                                    </div>
                                </div>
                                '.$reaction_box.'
                                <div id="comment_form'.$data->id.'" style="display:none;">
                                 <span id="old_comment'.$data->id.'"></span>
                                 <div class="form-group mb-0">
                                 <textarea name="comment" class="form-group border-0" id="comment'.$data->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                 </div>
                                 <div class="form-group" align="right">
                                 <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$data->user_id.'">Comment </button>
                                 </div>
                                </div>
                                '.$buttons_box.'
                            </div>
                        </div>
	 	          ';
        echo $output;

