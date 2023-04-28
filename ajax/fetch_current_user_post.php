<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

        $q= $db->prepare('SELECT *
                      FROM microposts
                      WHERE user_id= :user_id
                      ');
        $q->execute([
           'user_id'=>$_GET['id']
        ]);
        $result = $q->fetchAll(PDO::FETCH_OBJ);


                $output= '';
        foreach ($result as $row) {

               	if(user_has_already_liked_the_micropost($row->id)){
                  $like='
                  <button type="button" class="btn btn-fbook btn-block btn-sm like" id="unlike'. $row->id .'" data-action="unlike"><i class="far fa-heart" aria-hidden="true"></i> Unlike</button>
                  ';
               	}else{
               		$like='
                    <button type="button" class="btn btn-fbook btn-block btn-sm like" id="like'.$row->id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->id.'"><i class="far fa-heart" aria-hidden="true"></i> like</button>
               		';
               	}

               	if($row->urlMedia !=null)
               	{
                     $media='<img class="card-img-top rounded-0 img-thumbnail" src="'.$row->urlMedia.'" alt="Card image cap">';
               	}
               	else
               	{
                   $media='';
               	}

                if($row->type == "profile_updated")
                {
                  $type ='<span style="color: black; font-style: italic;"> profile updated</span>';
                }
                else
                {
                  $type='<span style="color: black; font-style: italic;"> added a status</span>';
                }
$output .= '
            <div class="card my-3" id="'.$row->id.'">
                                      <div class="card-header border-0 py-2">
                                          <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="'. e($row->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($row->name).' '.e($row->nom2).'</a>
                                                '.$type.'
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    <div class="dropdown" style="font-style: italic;">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                            <a class="dropdown-item" href="delete_micropost.php?id='. $row->id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-0 pb-2" style="font-style: italic;">

                            </div>
                             '. nl2br(replace_links($row->legend)) .'
                             '.$media.'
                            <div class="card-footer border-0 p-0">
                                <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                    <div id="displayer_'. $row->id .'">
                                        '.likers_updater($row->id,$db).'
                                    </div>
                                    <div id="likers_'. $row->id .'">
                                        '.display_likers($row->id).'
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center my-1">
                                    <div class="col">
                                 '.$like.'
                                    </div>
                                    <div class="col">
                           <button type="button" class="btn btn-fbook btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                                <div id="comment_form'.$row->id.'" style="display:none;">
                                 <span id="old_comment'.$row->id.'"></span>
                                 <div class="form-group mb-0">
                                 <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                 </div>
                                 <div class="form-group" align="right">
                                 <button type="button" name="submit_comment" class="btn btn-fbook btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                 </div>
                                </div>
                            </div>
                        </div>
                        ';
                        echo $output;
	                 }
