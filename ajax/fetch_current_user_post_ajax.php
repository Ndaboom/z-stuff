<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

extract($_POST);
if(isset($_POST["limit"], $_POST["start"]))
 {


$query = "SELECT * FROM microposts WHERE user_id= :user_id
ORDER BY created_at DESC LIMIT ".$_POST["start"].", ".$_POST["limit"]."";
$statement = $db->prepare($query);
$statement->execute([
'user_id'=>get_session('him')
]);
$result = $statement->fetchAll(PDO::FETCH_OBJ);
$total_row = $statement->rowCount();
$user=find_user_by_id(get_session('him'));
$output= '';
if($total_row > 0)
{

foreach ($result as $row)
{

                   	$query = "
                      SELECT * FROM comments INNER JOIN users ON users.id= comments.user_id
                      WHERE post_id = '".$row->id."'
                      ORDER BY comment_id ASC
  	 	           ";
  	 	           	$statement = $db->prepare($query);
  	 	           		if($statement->execute())
  	 	                {
  	 	                    $comment = $statement->fetch(PDO::FETCH_OBJ);
  	 	                }
  	 	        if($comment->profilepic != null && $comment->comment != null){
  	 	            $last_comment='<div id="display_last_comment'.$row->id.'">
                                 <div class="row" style="margin-left:10px;">
                     <div class="col-md-2">
                     <img src="'.$comment->profilepic.'" class="img-thumbnail img-responsive img-circle" width="30"/>
                     </div>
                     <div class="col-md-8" style="margin-top:2px;padding-left:0;">
                      <small><b>'.$comment->name.'</b><br/>
                        '.convertHashtags(replace_links(nl2br(e($comment->comment)))).'
                      </small>
                     </div></div>';
  	 	        }else{
  	 	            $last_comment = '';
  	 	        }
                 	if(user_has_already_liked_the_micropost($row->id)){
                    $like='
                    <button type="button" class="btn btn-zung btn-block btn-sm like" id="unlike'. $row->id .'" data-action="unlike"><i class="far fa-heart" aria-hidden="true"></i> Unlike</button>
                     <button type="button" class="btn btn-zung btn-block btn-sm like" id="like'.$row->id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->id.'" style="display:none;"><i class="far fa-heart" aria-hidden="true" ></i> like</button>
                    ';
                 	}else{
                 		$like='
                      <button type="button" class="btn btn-zung btn-block btn-sm like" id="like'.$row->id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->id.'"><i class="far fa-heart" aria-hidden="true"></i> like</button>
                 		 <button type="button" class="btn btn-zung btn-block btn-sm like" id="unlike'. $row->id .'" data-action="unlike" style="display:none;"><i class="far fa-heart" aria-hidden="true"></i> Unlike</button>
                 		';
                 	}


                    if(!a_post_has_already_been_shared($_SESSION['user_id'],$row->id))
                    {
                      $repost_btn = '
                       <button type="button" class="btn btn-zung btn-block btn-sm" id="repost'. $row->id .'" data-toggle="modal" data-target="#shareModal'.$row->id.'"><i class="fas fa-circle-notch"> '.post_shares_count($row->id).'</i></button>
                       ';
                    }else{
                      $repost_btn = '
                       <button type="button" class="btn btn-zung btn-block btn-sm text-success" id="repost'. $row->id .'" data-toggle="modal" data-target="#shareModal'.$row->id.'"><i class="fas fa-circle-notch"> '.post_shares_count($row->id).'</i></button>
                       ';
                    }

                 	if($row->urlMedia !=null)
                 	{
                       $media='<a href="postviewer.php?p_i='.$row->id.'"><img class="card-img-top rounded-0 img-thumbnail myelevate" src="'.$row->urlMedia.'" alt="Failed to load...please refresh the page" data-zoom-image="'.$row->urlMedia.'" style="width:100%;min-height:200px;"></a>';
                       $legend = '<p style="padding-left:15px;">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</p>';
                 	}
                 	else
                 	{
                     $media='';
                 	}

                  if($row->type == "profile_updated")
                  {
                    $type ='<span style="color: black;"> updated his profile picture</span>';
                  }
                  elseif($row->type == "quotes")
                  {
                   $type='<span style="color: black;"> added a quotes</span>';
                   $media = '<div class="text-center">
                               <h3 style = "font-family:georgia,garamond,serif;font-size:26px;font-style:italic; color:#282923;"><i class="fas fa-quote-left"></i> '.convertHashtags(replace_links(nl2br(e($row->legend)))).' <i class="fas fa-quote-right"></i></h3>
                              </div>
                              <div class="text-right">
                              <p style="color:#282923; font-style:italic;">- '.e(nl2br($row->quote_author)).'</p>&nbsp
                              </div>';
                  }
                  elseif($row->type == "sound")
                  {
                   $legend = '<p style="padding-left:15px;">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</p>';
                   $type='<span style="color: black;"> added a sound</span>';
                   $media = '<div class="row">
                   <div class="col-md-2">
                       <a href="postviewer.php?p_i='.$row->id.'"><h3 style="color: #44717C; padding:10px;"><i class="fas fa-headphones-alt"></i></h3></a>
                   </div>
                   <div class="col-md-10">
                          <audio controls>
                          <source src="'.$row->urlMedia.'" type="audio/mpeg">
                          </audio><br>
                   </div>
                   </div>';
                  }
                  elseif($row->type == "video")
                  {
                  $legend = '<p style="padding-left:15px;">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</p>';
                  $type = '<span style="color: black; font-style: italic;" class="text_box"> added a video</span>';
                  $media = '<video controls preload="meta-data" loop poster="" style="max-height: 400px;">
                              <source src="'.$row->urlMedia.'">
                              </source>
                           </video>';
                  }
                  elseif($row->type == "cover_updated")
                  {
                   $type='<span style="color: black;"> updated his cover photo</span>';
                  }
                  elseif($row->type == "shared_a_place")
                  {
                   $place = find_place_by_id($row->place_id);
                   $type='<span style="color: black;"> shared the place <a href="homeplace.php?pl_i='.$place->id.'">'.$place->place_name.'</a> </span>';
                  }
                  elseif($row->type == "shared_post") {
                    $from = find_user_by_id($row->from_user_id);
                    $type='<span style="color: black;"> shared a post from <a href="profile.php?id='.$row->from_user_id.'" >'.$from->name.'</a> </span>';
                    $legend = '';
                    if($row->sub_type == "quotes"){

                    $media = '<div class="text-center">
                               <h3 style = "font-family:georgia,garamond,serif;font-size:26px;font-style:italic; color:#282923;"><i class="fas fa-quote-left"></i> '. convertHashtags(replace_links(nl2br(e($row->legend)))).' <i class="fas fa-quote-right"></i></h3>
                              </div>
                              <div class="text-right">
                              <p style="color:#282923; font-style:italic;">- '.e(nl2br($row->quote_author)).'</p>&nbsp
                              </div>';
                    }elseif($row->sub_type == "video"){
                    $legend = '<p style="padding-left:15px;">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</p>';
                    $media = '<video controls preload="meta-data" loop poster="">
                              <source src="'.$row->urlMedia.'">
                              </source>
                           </video>';
                    }elseif($row->sub_type == 'sound'){
                    $legend = '<p style="padding-left:15px;">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</p>';
                    $media = '<div class="row">
                    <div class="col-md-2">
                        <a href="postviewer.php?p_i='.$row->id.'"><h3 style="color: #44717C; padding:10px;"><i class="fas fa-headphones-alt"></i></h3></a>
                    </div>
                    <div class="col-md-10">
                           <audio controls>
                           <source src="'.$row->urlMedia.'" type="audio/mpeg">
                           </audio><br>
                    </div>
                    </div>';
                  }else{
                    $legend = '<p style="padding-left:15px;">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</p>';
                  }
                  }
                  else
                  {
                    $legend = '<p style="padding-left:15px;">'.convertHashtags(replace_links(nl2br(e($row->legend)))).'</p>';
                    $type='<span style="color: black; font-style: italic;"> added a status</span>';
                  }

                  if(get_session('user_id') == $row->user_id){
                      $modal='<div class="modal fade" id="monModal'.$row->id.'">
                           <div class="modal-dialog" >
                                 <div class="modal-content">
                                     <div class="modal-body">
                                    <div class="row">
                                      <div class="col-md-2 text-danger">
                                      <i class="far fa-trash-alt"></i>
                                      </div>
                                      <div class="col-md-10">
                                      <a class="text-danger" data-confirm="Voulez-vous vraiment supprimer cette publication ?" href="delete_micropost.php?id='. $row->id .'" > Delete</a>
                                      </div>
                                    </div>

                                          <div class="row">
                                             <div class="col-md-2 text-success">
                                             <i class="far fa-copy"></i>
                                             </div>
                                             <div class="col-md-10">
                                             <input type="text" class="form-control" value="https://zungvi.com/postviewer.php?p_i='.$row->id.'" readonly/>
                                             </div>
                                          </div>
                                    </div>
                                   </div>
                                </div>
                  </div>';
                  }else{
                      $modal='<div class="modal fade" id="monModal'.$row->id.'">
                           <div class="modal-dialog" >
                                 <div class="modal-content">
                                     <div class="modal-body">
                                          <div class="row">
                                             <div class="col-md-2 text-success">
                                             <i class="far fa-copy"></i>
                                             </div>
                                             <div class="col-md-10">
                                             <input type="text" class="form-control" value="https://zungvi.com/postviewer.php?p_i='.$row->id.'" readonly/>
                                             </div>
                                          </div>
                                      </div>
                                  </div>
                       </div>
                  </div>';
                  }

                  $shareModal = '
                  <div class="modal fade" id="shareModal'.$row->id.'">
                           <div class="modal-dialog" >
                                 <div class="modal-content">
                                     <div class="modal-body">
                                     <div class="card">
                                     <div class="card-body">
                                     <span>Share this post :</span><br>
                                     <a class="share_publication" href="" data-poster="'.$row->user_id.'" data-media="'.$row->urlMedia.'" data-legend="'.$row->legend.'" data-postid="'.$row->id.'" data-post_type="'.$row->type.'" data-quote_author="'.$row->quote_author.'" id="sharing_button'.$row->id.'"><i class="fas fa-users"></i> with friends</a>
                                     <small class="text-info" style="display:none;" id="share_pending'.$row->id.'"> posting...please wait</small>
                                     <span class="text-success" style="display:none;" id="share_confirmation'.$row->id.'"> Shared!</span>
                                     </div>
                                     </div>
                                      </div>
                                  </div>
                       </div>
                  </div>
                  ';
                  	$query1 = "
                      SELECT * FROM micropost_like
                      WHERE micropost_id = '".$row->id."'
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
                  $likeModal='<div class="modal fade" id="likesModal'.$row->id.'">
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

                  if($row->type == "quotes"){
                    $output .= '
                    '.$modal.'
                    '.$likeModal.'
                    '.$shareModal.'
                    <div class="card my-3" id="'.$row->id.'">
                                        <div class="card-header border-0 py-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-between">
                                                  <a href="#">
                                              <img class="rounded-circle" src="'. e($user->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                          </a>
                                          <div class="ml-3">
                                              <div class="h6 m-0">
                                                  <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($user->name).' '.e($user->nom2).'</a>
                                                  '.$type.'
                                              </div>
                                              <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                          </div>
                                      </div>
                                      <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#monModal'.$row->id.'">
                                          <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                              data-toggle="modal" data-target="#monModal'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
                                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                              <a class="dropdown-item" href="delete_micropost.php?id='. $row->id .'"><i class="fa fa-trash"></i> Delete</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="card-body pt-0 pb-2" style="font-style: italic;">

                              </div>
                              '.$media.'
                              <div class="card-footer border-0 p-0">
                                  <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                      <div id="displayer_'. $row->id .'">
                                          '.likers_updater($row->id,$db).'
                                      </div>
                                      <div id="likers_'. $row->id .'" data-toggle="modal" data-target="#likesModal'.$row->id.'">
                                          '.display_likers($row->id).'
                                      </div>
                                  </div>
                                  <div class="d-flex justify-content-between align-items-center my-1">
                                      <div class="col">
                                   '.$like.'
                                      </div>
                                      <div class="col">
                             <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                      </div>
                                      <div class="col">
                                      '.$repost_btn.'
                                      </div>
                                  </div>

                                  </div>
                                  <div id="comment_form'.$row->id.'" style="display:none;">
                                   <span id="old_comment'.$row->id.'"></span>
                                   <div class="form-group mb-0">
                                   <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." ></textarea>
                                   </div>
                                   <div class="form-group" align="right">
                                   <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                   </div>
                                  </div>
                              </div>
                          </div>';

                  }elseif($row->type== "profile_updated"){
                    $output .= '
                    '.$modal.'
                    '.$likeModal.'
                    '.$shareModal.'
                       <div class="card my-3" id="'.$row->id.'">
                                        <div class="card-header border-0 py-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-between">
                                                  <a href="#">
                                              <img class="rounded-circle" src="'.e($user->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                          </a>
                                          <div class="ml-3">
                                              <div class="h6 m-0">
                                                  <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($user->name).' '.e($user->nom2).'</a>
                                                  '.$type.'
                                              </div>
                                              <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                          </div>
                                      </div>
                                      <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#monModal'.$row->id.'">
                                          <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                              data-toggle="modal" data-target="#monModal'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
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
                               '.$media.'
                              <div class="card-footer border-0 p-0">
                                  <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                      <div id="displayer_'. $row->id .'">
                                          '.likers_updater($row->id,$db).'
                                      </div>
                                      <div id="likers_'. $row->id .'" data-toggle="modal" data-target="#likesModal'.$row->id.'">
                                          '.display_likers($row->id).'
                                      </div>
                                  </div>
                                  <div class="d-flex justify-content-between align-items-center my-1">
                                      <div class="col">
                                   '.$like.'
                                      </div>
                                      <div class="col">
                             <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                      </div>
                                      <div class="col">
                                      '.$repost_btn.'
                                      </div>
                                  </div>
                                  </div>
                                  <div id="comment_form'.$row->id.'" style="display:none;">
                                   <span id="old_comment'.$row->id.'"></span>
                                   <div class="form-group mb-0">
                                   <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                   </div>
                                   <div class="form-group" align="right">
                                   <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                   </div>
                                  </div>
                              </div>
                          </div>

                  ';
                  }elseif($row->type== "sound"){
                    $output .= '
                    '.$modal.'
                    '.$likeModal.'
                    '.$shareModal.'
                       <div class="card my-3" id="'.$row->id.'">
                                        <div class="card-header border-0 py-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-between">
                                                  <a href="#">
                                              <img class="rounded-circle" src="'. e($user->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                          </a>
                                          <div class="ml-3">
                                              <div class="h6 m-0">
                                                  <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($user->name).' '.e($user->nom2).'</a>
                                                  '.$type.'
                                              </div>
                                              <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                          </div>
                                      </div>
                                      <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#monModal'.$row->id.'">
                                          <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                              data-toggle="modal" data-target="#monModal'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
                                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                              <a class="dropdown-item" href="delete_micropost.php?id='. $row->id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                              <a class="dropdown-item" href="#">Another action</a>
                                              <a class="dropdown-item" href="#">Something else here</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              '.$media.'
                               <div class="card-body pt-0 pb-2 text-center">
                                 '.$legend.'
                              </div>
                              <div class="card-footer border-0 p-0">
                                  <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                      <div id="displayer_'. $row->id .'">
                                          '.likers_updater($row->id,$db).'
                                      </div>
                                      <div id="likers_'. $row->id .'" data-toggle="modal" data-target="#likesModal'.$row->id.'">
                                          '.display_likers($row->id).'
                                      </div>
                                  </div>
                                  <div class="d-flex justify-content-between align-items-center my-1">
                                      <div class="col">
                                   '.$like.'
                                      </div>
                                      <div class="col">
                             <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                      </div>
                                      <div class="col">
                                      '.$repost_btn.'
                                      </div>
                                  </div>
                                  </div>
                                  <div id="comment_form'.$row->id.'" style="display:none;">
                                   <span id="old_comment'.$row->id.'"></span>
                                   <div class="form-group mb-0">
                                   <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                   </div>
                                   <div class="form-group" align="right">
                                   <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                   </div>
                                  </div>
                              </div>
                          </div>

                  ';
                  }
                  elseif($row->type== "cover_updated")
                  {
                    $output .= '
                    '.$modal.'
                       <div class="card my-3" id="'.$row->id.'">
                                        <div class="card-header border-0 py-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-between">
                                                  <a href="#">
                                              <img class="rounded-circle" src="'. e($user->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                          </a>
                                          <div class="ml-3">
                                              <div class="h6 m-0">
                                                  <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($user->name).' '.e($user->nom2).'</a>
                                                  '.$type.'
                                              </div>
                                              <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                          </div>
                                      </div>
                                      <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#monModal'.$row->id.'">
                                          <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                              data-toggle="modal" data-target="#monModal'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
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
                               '.$legend.'
                               '.$media.'
                              <div class="card-footer bg-white border-0 p-0">
                                  <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                      <div id="displayer_'. $row->id .'">
                                          '.likers_updater($row->id,$db).'
                                      </div>
                                      <div id="likers_'. $row->id .'" data-toggle="modal" data-target="#likesModal'.$row->id.'">
                                          '.display_likers($row->id).'
                                      </div>
                                  </div>
                                  <div class="d-flex justify-content-between align-items-center my-1">
                                      <div class="col">
                                   '.$like.'
                                      </div>
                                      <div class="col">
                             <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                      </div>
                                      <div class="col">
                                      '.$repost_btn.'
                                      </div>
                                  </div>
                                  </div>
                                  <div id="comment_form'.$row->id.'" style="display:none;">
                                   <span id="old_comment'.$row->id.'"></span>
                                   <div class="form-group mb-0">
                                   <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                   </div>
                                   <div class="form-group" align="right">
                                   <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                   </div>
                                  </div>
                              </div>
                          </div>

                  ';
                  }elseif($row->type== "shared_a_place"){
                  $output .= '
                    '.$modal.'
                    '.$likeModal.'
                       <div class="card my-3" id="'.$row->id.'">
                                        <div class="card-header border-0 py-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-between">
                                                  <a href="#">
                                              <img class="rounded-circle" src="'. e($user->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                          </a>
                                          <div class="ml-3">
                                              <div class="h6 m-0">
                                                  <a href="profile.php?id='.e($row->user_id).'" >'. e($user->name).' '.e($user->nom2).'</a>
                                                  '.$type.'
                                              </div>
                                              <div class="text-muted h8" style="word-break: break-all;"><span class="timeago" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                          </div>
                                      </div>
                                      <div class="dropdown" data-toggle="modal" data-target="#monModal'.$row->id.'">
                                          <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                              data-toggle="modal" data-target="#monModal'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
                                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                              <a class="dropdown-item" href="delete_micropost.php?id='. $row->id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                              <a class="dropdown-item" href="#">Another action</a>
                                              <a class="dropdown-item" href="#">Something else here</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="card-body pt-0 pb-2">

                              </div>
                               <div class="card text-white">
                                    <img src="'.$place->coverpic.'" class="card-img" alt="...">
                                   <div class="card-img-overlay text-center" style="padding-top:15%;">
                                    <h4 class="card-title" style="font-family:Arial Black;font-size:25px;font-style:bold;">'.$place->place_name.'</h4>
                                       <a href="homeplace.php?pl_i='.$place->id .'" class="btn btn-outline-primary btn-xs">Visit</a>
                                    </div>
                                    <div class="card-footer">
                                     <small>'. convertHashtags(substr(e($place->description),0,180)).'...</small>
                                    </div>
                               </div>

                              <div class="card-footer border-0 p-0">
                                  <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                      <div id="displayer_'. $row->id .'">
                                          '.likers_updater($row->id,$db).'
                                      </div>
                                      <div id="likers_'. $row->id .'" data-toggle="modal" data-target="#likesModal'.$row->id.'">
                                          '.display_likers($row->id).'
                                      </div>
                                  </div>
                                  <div class="d-flex justify-content-between align-items-center my-1">
                                      <div class="col">
                                   '.$like.'
                                      </div>
                                      <div class="col">
                             <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                      </div>
                                      <div class="col">
                                      '.$repost_btn.'
                                      </div>
                                  </div>
                                  </div>
                                  <div id="comment_form'.$row->id.'" style="display:none;">
                                   <span id="old_comment'.$row->id.'"></span>
                                   <div class="form-group mb-0">
                                   <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                   </div>
                                   <div class="form-group" align="right">
                                   <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                   </div>
                                  </div>
                              </div>
                          </div>
                  ';
                  }elseif($row->type == "shared_post"){
                   $output .= '
                    '.$modal.'
                    '.$likeModal.'
                    '.$shareModal.'
                       <div class="card my-3" id="'.$row->id.'">
                                        <div class="card-header border-0 py-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-between">
                                                  <a href="profile.php?id='.$row->user_id.'">
                                              <img class="rounded-circle" src="'. e($user->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                          </a>
                                          <div class="ml-3">
                                              <div class="h6 m-0">
                                                  <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($user->name).' '.e($user->nom2).'</a>
                                                  '.$type.'
                                              </div>
                                              <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                          </div>
                                      </div>
                                      <div class="dropdown" style="font-style: italic;">
                                          <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                              data-toggle="modal" data-target="#monModal'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
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
                               '.$legend.'
                               '.$media.'
                              <div class="card-footer border-0 p-0">
                                  <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                      <div id="displayer_'. $row->id .'">
                                          '.likers_updater($row->id,$db).'
                                      </div>
                                      <div id="likers_'. $row->id .'" data-toggle="modal" data-target="#likesModal'.$row->id.'">
                                          '.display_likers($row->id).'
                                      </div>
                                  </div>
                                  <div class="d-flex justify-content-between align-items-center my-1">
                                      <div class="col">
                                   '.$like.'
                                      </div>
                                      <div class="col">
                             <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                      </div>
                                      <div class="col">
                                      '.$repost_btn.'
                                      </div>
                                  </div>
                                  </div>
                                  <div id="comment_form'.$row->id.'" style="display:none;">
                                   <span id="old_comment'.$row->id.'"></span>
                                   <div class="form-group mb-0">
                                   <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                   </div>
                                   <div class="form-group" align="right">
                                   <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                   </div>
                                  </div>
                              </div>
                          </div>

                  ';

                  }else
                  {
                    $output .= '
                    '.$modal.'
                    '.$likeModal.'
                    '.$shareModal.'
                       <div class="card my-3" id="'.$row->id.'">
                                        <div class="card-header border-0 py-2">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex justify-content-between">
                                                  <a href="profile.php?id='.$row->user_id.'">
                                              <img class="rounded-circle" src="'. e($user->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                          </a>
                                          <div class="ml-3">
                                              <div class="h6 m-0">
                                                  <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($user->name).' '.e($user->nom2).'</a>
                                                  '.$type.'
                                              </div>
                                              <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="timeago" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                          </div>
                                      </div>
                                      <div class="dropdown" style="font-style: italic;">
                                          <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                              data-toggle="modal" data-target="#monModal'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
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
                               '. $legend .'
                               '.$media.'
                              <div class="card-footer border-0 p-0">
                                  <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                      <div id="displayer_'. $row->id .'">
                                          '.likers_updater($row->id,$db).'
                                      </div>
                                      <div id="likers_'. $row->id .'" data-toggle="modal" data-target="#likesModal'.$row->id.'">
                                          '.display_likers($row->id).'
                                      </div>
                                  </div>
                                  <div class="d-flex justify-content-between align-items-center my-1">
                                      <div class="col">
                                   '.$like.'
                                      </div>
                                      <div class="col">
                             <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                      </div>
                                      <div class="col">
                                      '.$repost_btn.'
                                      </div>
                                  </div>
                                  </div>
                                  <div id="comment_form'.$row->id.'" style="display:none;">
                                   <span id="old_comment'.$row->id.'"></span>
                                   <div class="form-group mb-0">
                                   <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                   </div>
                                   <div class="form-group" align="right">
                                   <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                   </div>
                                  </div>
                              </div>
                          </div>

                  ';
                  }

  }
 }
else
{
$output = '<button class="btn btn-zung btn-block btn-sm more_post"></button>';
}
echo $output;
}
