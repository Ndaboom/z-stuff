<?php
session_start();
require("includes/init.php");
include('filters/auth_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");

if(isset($_POST["limit2"], $_POST["from"]))
{
  $query = "SELECT U.id user_id,U.name, U.nom2, U.email, U.profilepic,
                          M.id m_id, M.legend,M.user_id ,M.created_at, M.urlMedia, M.like_count,M.type,M.quote_author,M.place_id,M.from_user_id,M.sub_type
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
           ";
            $statement = $db->prepare($query);
              if($statement->execute())
                {
                    $comment = $statement->fetch(PDO::FETCH_OBJ);
                }
        if($comment->profilepic != null && $comment->comment != null){
            $last_comment='<div id="display_last_comment'.$row->m_id.'">
                           <div class="row" style="margin-left:10px;">
               <div class="col-md-2">
               <img src="'.$comment->profilepic.'" class="img-thumbnail img-responsive img-circle" width="30"/>
               </div>
               <div class="col-md-8" style="margin-top:2px;padding-left:0;">
                <small><b>'.$comment->name.'</b><br />
                  '.convertHashtags(replace_links(e($comment->comment))).'
                </small>
               </div></div>';
        }else{
            $last_comment = '';
        }
            if(user_has_already_liked_the_micropost($row->m_id)){
              $like='
              <button type="button" class="btn btn-zung btn-block btn-sm like" id="unlike'. $row->m_id .'" data-action="unlike"><i class="far fa-heart" aria-hidden="true"></i> Unlike</button>
               <button type="button" class="btn btn-zung btn-block btn-sm like" id="like'.$row->m_id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->m_id.'" style="display:none;"><i class="far fa-heart" aria-hidden="true" ></i> like</button>
              ';
            }else{
              $like='
                <button type="button" class="btn btn-zung btn-block btn-sm like" id="like'.$row->m_id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->m_id.'"><i class="far fa-heart" aria-hidden="true"></i> like</button>
               <button type="button" class="btn btn-zung btn-block btn-sm like" id="unlike'. $row->m_id .'" data-action="unlike" style="display:none;"><i class="far fa-heart" aria-hidden="true"></i> Unlike</button>
              ';
            }


              if(!a_post_has_already_been_shared($_SESSION['user_id'],$row->m_id))
              {
                $repost_btn = '
                 <button type="button" class="btn btn-zung btn-block btn-sm" id="repost'. $row->m_id .'" data-toggle="modal" data-target="#shareModal'.$row->m_id.'"><i class="fas fa-circle-notch"> '.post_shares_count($row->m_id).'</i></button>
                 ';
              }else{
                $repost_btn = '
                 <button type="button" class="btn btn-zung btn-block btn-sm text-success" id="repost'. $row->m_id .'" data-toggle="modal" data-target="#shareModal'.$row->m_id.'"><i class="fas fa-circle-notch"> '.post_shares_count($row->m_id).'</i></button>
                 ';
              }

            if($row->urlMedia !=null)
            {
                 $media='<a href="postviewer.php?p_i='.$row->m_id.'"><img class="" src="'.$row->urlMedia.'" alt="Image not uploaded successfuly" style="width:100%;min-height:200px; max-height:600px;"></a>';
            }
            else
            {
               $media='';
            }

            if($row->type == "profile_updated")
            {
              $type ='<span class = "text-dark"> updated his profile picture</span>';
            }
            elseif($row->type == "quotes")
            {
             $type='<span class = "text-dark"> added a quotes</span>';
             $media = '<div class="text-center">
                         <h3 style = "font-family:georgia,garamond,serif;font-size:26px;font-style:italic; color:#282923;"><i class="fas fa-quote-left"></i> '. e(nl2br($row->legend)).' <i class="fas fa-quote-right"></i></h3>
                        </div>
                        <div class="text-right">
                        <p style="color:#282923; font-style:italic;">- '.e(nl2br($row->quote_author)).'</p>&nbsp
                        </div>';
            }
            elseif($row->type == "sound")
            {
             $type='<span class = "text-dark"> added a sound</span>';
             $media = '<div class="row">
             <div class="col-md-2">
                 <a href="postviewer.php?p_i='.$row->m_id.'"><h3 style="color: #44717C; padding:10px;"><i class="fas fa-headphones-alt"></i></h3></a>
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

            $type = '<span class = "text-dark"style="color: black; font-style: italic;" class="text_box"> added a video</span>';
            $media = '<video controls preload="meta-data" loop poster="" style="max-height: 400px;">
                        <source src="'.$row->urlMedia.'">
                        </source>
                     </video>';
            }
            elseif($row->type == "cover_updated")
            {
             $type='<span class = "text-dark"> updated his cover photo</span>';
            }
            elseif($row->type == "shared_a_place")
            {
             $place = find_place_by_id($row->place_id);
             $type='<span class = "text-dark"> shared the place <a href="homeplace.php?pl_i='.$place->id.'">'.$place->place_name.'</a> </span>';
            }
            elseif($row->type == "shared_post") {
              $from = find_user_by_id($row->from_user_id);
              $type='<span class = "text-dark"> shared a post from <a href="profile.php?id='.$row->from_user_id.'" >'.$from->name.'</a> </span>';
              $legend = '';
              if($row->sub_type == "quotes"){

              $media = '<div class="text-center">
                         <h3 style = "font-family:georgia,garamond,serif;font-size:26px;font-style:italic; color:#282923;"><i class="fas fa-quote-left"></i> '. e(nl2br($row->legend)).' <i class="fas fa-quote-right"></i></h3>
                        </div>
                        <div class="text-right">
                        <p style="color:#282923; font-style:italic;">- '.e(nl2br($row->quote_author)).'</p>&nbsp
                        </div>';
              }elseif($row->sub_type == "video"){
              $legend = convertHashtags(replace_links(nl2br(e($row->legend))));
              $media = '<video controls preload="meta-data" loop poster="" style="max-height: 400px;">
                        <source src="'.$row->urlMedia.'">
                        </source>
                     </video>';
              }elseif($row->sub_type == 'sound'){
              $legend = convertHashtags(replace_links(nl2br(e($row->legend))));
              $media = '<div class="row">
              <div class="col-md-2">
                  <a href="postviewer.php?p_i='.$row->m_id.'"><h3 style="color: #44717C; padding:10px;"><i class="fas fa-headphones-alt"></i></h3></a>
              </div>
              <div class="col-md-10">
                     <audio controls>
                     <source src="'.$row->urlMedia.'" type="audio/mpeg">
                     </audio><br>
              </div>
              </div>';
              }else{
                  $legend = convertHashtags(replace_links(nl2br(e($row->legend))));
              }
            }
            else
            {
              $type='<span class = "text-dark"style="color: black; font-style: italic;"> added a status</span>';
            }

            if(get_session('user_id') == $row->user_id){
                $modal='<div class="modal fade" id="monModal'.$row->m_id.'">
                     <div class="modal-dialog" >
                           <div class="modal-content">
                               <div class="modal-body">
                              <div class="row">
                                <div class="col-md-2 text-danger">
                                <i class="far fa-trash-alt"></i>
                                </div>
                                <div class="col-md-10">
                                <a class="text-danger" data-confirm="Voulez-vous vraiment supprimer cette publication ?" href="delete_micropost.php?id='. $row->m_id .'" > Delete</a>
                                </div>
                              </div>

                                    <div class="row">
                                       <div class="col-md-2 text-success">
                                       <i class="far fa-copy"></i>
                                       </div>
                                       <div class="col-md-10">
                                       <input type="text" class="form-control" value="https://zungvi.com/postviewer.php?p_i='.$row->m_id.'" readonly/>
                                       </div>
                                    </div>
                              </div>
                             </div>
                          </div>
            </div>';
            }else{
                $modal='<div class="modal fade" id="monModal'.$row->m_id.'">
                         <div class="modal-dialog" >
                               <div class="modal-content">
                                   <div class="modal-body">
                                        <div class="row">
                                           <div class="col-md-2 text-success">
                                           <button type="button" data-post_id="'.$row->m_id.'" class="btn btn-light link_button"><i class="far fa-copy"></i></button>
                                           </div>
                                           <div class="col-md-10">
                                           <input type="text" class="form-control" id="link'.$row->m_id.'" value="https://zungvi.com/postviewer.php?p_i='.$row->m_id.'" readonly/>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                     </div>
                </div>';
            }

            $shareModal = '
            <div class="modal fade" id="shareModal'.$row->m_id.'">
                     <div class="modal-dialog" >
                           <div class="modal-content">
                               <div class="modal-body">
                               <div class="card">
                               <div class="card-body">
                               <span>Share this post :</span><br>
                               <a class="share_publication" href="" data-poster="'.$row->user_id.'" data-media="'.$row->urlMedia.'" data-legend="'.$row->legend.'" data-postid="'.$row->m_id.'" data-post_type="'.$row->type.'" data-quote_author="'.$row->quote_author.'" id="sharing_button'.$row->m_id.'"><i class="fas fa-users"></i> with friends</a>
                               <small class="text-info" style="display:none;" id="share_pending'.$row->m_id.'"> posting...please wait</small>
                               <span class = "text-dark"class="text-success" style="display:none;" id="share_confirmation'.$row->m_id.'"> Shared!</span>
                               </div>
                               </div>
                                </div>
                            </div>
                 </div>
            </div>
            ';
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
                    <div class="row">
                    <div class="col-md-2"><img src="'.$luser->profilepic.'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" class="rounded-circle"/></div>
                    <div class="col-md-6">'.$luser->name.' '.$luser->nom2.'</div>
                    <div class="col-md-4">'.zungvi_time_ago($liker->created_at).'</div>
                    </div>
                    ';
                     }
                }
            $likeModal='<div class="modal fade" id="likesModal'.$row->m_id.'">
                           <div class="modal-dialog" >
                             <div class="modal-content">
                             <div class="modal-header">
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
              <div class="card my-3" id="'.$row->m_id.'">
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
                                        <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class = "text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#monModal'.$row->m_id.'">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="modal" data-target="#monModal'.$row->m_id.'" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                        <a class="dropdown-item" href="delete_micropost.php?id='. $row->m_id .'"><i class="fa fa-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0 pb-2" style="font-style: italic;">

                        </div>
                        '.$media.'
                        <div class="card-footer border-0 p-0">
                            <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                <div id="displayer_'. $row->m_id .'">
                                    '.likers_updater($row->m_id,$db).'
                                </div>
                                <div id="likers_'. $row->m_id .'" data-toggle="modal" data-target="#likesModal'.$row->m_id.'">
                                    '.display_likers($row->m_id).'
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center my-1">
                                <div class="col">
                             '.$like.'
                                </div>
                                <div class="col">
                       <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->m_id.'">'.count_comment($db,$row->m_id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                </div>
                                <div class="col">
                                '.$repost_btn.'
                                </div>
                            </div>

                            </div>
                            <div id="comment_form'.$row->m_id.'" style="display:none;">
                             <span class = "text-dark"id="old_comment'.$row->m_id.'"></span>
                             <div class="form-group mb-0">
                             <textarea name="comment" class="form-group border-0" id="comment'.$row->m_id.'" placeholder="your comment..." ></textarea>
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
                 <div class="card my-3" id="'.$row->m_id.'">
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
                                        <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class="text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#monModal'.$row->m_id.'">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="modal" data-target="#monModal'.$row->m_id.'" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                        <a class="dropdown-item" href="delete_micropost.php?id='. $row->m_id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0 pb-2" style="font-style: italic;">

                        </div>
                         '. convertHashtags(replace_links(nl2br(e($row->legend)))) .'
                         '.$media.'
                        <div class="card-footer border-0 p-0">
                            <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                <div id="displayer_'. $row->m_id .'">
                                    '.likers_updater($row->m_id,$db).'
                                </div>
                                <div id="likers_'. $row->m_id .'" data-toggle="modal" data-target="#likesModal'.$row->m_id.'">
                                    '.display_likers($row->m_id).'
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center my-1">
                                <div class="col">
                             '.$like.'
                                </div>
                                <div class="col">
                       <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->m_id.'">'.count_comment($db,$row->m_id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                </div>
                                <div class="col">
                                '.$repost_btn.'
                                </div>
                            </div>
                            </div>
                            <div id="comment_form'.$row->m_id.'" style="display:none;">
                             <span class = "text-dark"id="old_comment'.$row->m_id.'"></span>
                             <div class="form-group mb-0">
                             <textarea name="comment" class="form-group border-0" id="comment'.$row->m_id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
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
                 <div class="card my-3" id="'.$row->m_id.'">
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
                                        <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class = "text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#monModal'.$row->m_id.'">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="modal" data-target="#monModal'.$row->m_id.'" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                        <a class="dropdown-item" href="delete_micropost.php?id='. $row->m_id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        '.$media.'
                         <div class="card-body pt-0 pb-2 text-center">
                           '.convertHashtags(nl2br($row->legend).'
                        </div>
                        <div class="card-footer border-0 p-0">
                            <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                <div id="displayer_'. $row->m_id .'">
                                    '.likers_updater($row->m_id,$db).'
                                </div>
                                <div id="likers_'. $row->m_id .'" data-toggle="modal" data-target="#likesModal'.$row->m_id.'">
                                    '.display_likers($row->m_id).'
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center my-1">
                                <div class="col">
                             '.$like.'
                                </div>
                                <div class="col">
                       <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->m_id.'">'.count_comment($db,$row->m_id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                </div>
                                <div class="col">
                                '.$repost_btn.'
                                </div>
                            </div>
                            </div>
                            <div id="comment_form'.$row->m_id.'" style="display:none;">
                             <span class = "text-dark"id="old_comment'.$row->m_id.'"></span>
                             <div class="form-group mb-0">
                             <textarea name="comment" class="form-group border-0" id="comment'.$row->m_id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
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
                 <div class="card my-3" id="'.$row->m_id.'">
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
                                        <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class = "text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="dropdown" style="font-style: italic;" data-toggle="modal" data-target="#monModal'.$row->m_id.'">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="modal" data-target="#monModal'.$row->m_id.'" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                        <a class="dropdown-item" href="delete_micropost.php?id='. $row->m_id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0 pb-2" style="font-style: italic;">

                        </div>
                         '. convertHashtags(replace_links(nl2br(e($row->legend)))) .'
                         '.$media.'
                        <div class="card-footer  border-0 p-0">
                            <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                <div id="displayer_'. $row->m_id .'">
                                    '.likers_updater($row->m_id,$db).'
                                </div>
                                <div id="likers_'. $row->m_id .'" data-toggle="modal" data-target="#likesModal'.$row->m_id.'">
                                    '.display_likers($row->m_id).'
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center my-1">
                                <div class="col">
                             '.$like.'
                                </div>
                                <div class="col">
                       <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->m_id.'">'.count_comment($db,$row->m_id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                </div>
                                <div class="col">
                                '.$repost_btn.'
                                </div>
                            </div>
                            </div>
                            <div id="comment_form'.$row->m_id.'" style="display:none;">
                             <span class = "text-dark"id="old_comment'.$row->m_id.'"></span>
                             <div class="form-group mb-0">
                             <textarea name="comment" class="form-group border-0" id="comment'.$row->m_id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
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
                 <div class="card my-3" id="'.$row->m_id.'">
                                  <div class="card-header border-0 py-2">
                                      <div class="d-flex justify-content-between">
                                          <div class="d-flex justify-content-between">
                                            <a href="#">
                                        <img class="rounded-circle" src="'. e($row->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                    </a>
                                    <div class="ml-3">
                                        <div class="h6 m-0">
                                            <a href="profile.php?id='.e($row->user_id).'" >'. e($row->name).' '.e($row->nom2).'</a>
                                            '.$type.'
                                        </div>
                                        <div class="text-muted h8" style="word-break: break-all;"><span class = "text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="dropdown" data-toggle="modal" data-target="#monModal'.$row->m_id.'">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="modal" data-target="#monModal'.$row->m_id.'" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                        <a class="dropdown-item" href="delete_micropost.php?id='. $row->m_id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0 pb-2">

                        </div>
                         <div class="card">
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
                                <div id="displayer_'. $row->m_id .'">
                                    '.likers_updater($row->m_id,$db).'
                                </div>
                                <div id="likers_'. $row->m_id .'" data-toggle="modal" data-target="#likesModal'.$row->m_id.'">
                                    '.display_likers($row->m_id).'
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center my-1">
                                <div class="col">
                             '.$like.'
                                </div>
                                <div class="col">
                       <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->m_id.'">'.count_comment($db,$row->m_id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                </div>
                                <div class="col">
                                '.$repost_btn.'
                                </div>
                            </div>
                            </div>
                            <div id="comment_form'.$row->m_id.'" style="display:none;">
                             <span class = "text-dark"id="old_comment'.$row->m_id.'"></span>
                             <div class="form-group mb-0">
                             <textarea name="comment" class="form-group border-0" id="comment'.$row->m_id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
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
                 <div class="card my-3" id="'.$row->m_id.'">
                                  <div class="card-header border-0 py-2">
                                      <div class="d-flex justify-content-between">
                                          <div class="d-flex justify-content-between">
                                            <a href="profile.php?id='.$row->user_id.'">
                                        <img class="rounded-circle" src="'. e($row->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                    </a>
                                    <div class="ml-3">
                                        <div class="h6 m-0">
                                            <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($row->name).' '.e($row->nom2).'</a>
                                            '.$type.'
                                        </div>
                                        <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class = "text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="dropdown" style="font-style: italic;">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="modal" data-target="#monModal'.$row->m_id.'" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                        <a class="dropdown-item" href="delete_micropost.php?id='. $row->m_id .'"><i class="fa fa-trash"></i> Supprimer</a>
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
                                <div id="displayer_'. $row->m_id .'">
                                    '.likers_updater($row->m_id,$db).'
                                </div>
                                <div id="likers_'. $row->m_id .'" data-toggle="modal" data-target="#likesModal'.$row->m_id.'">
                                    '.display_likers($row->m_id).'
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center my-1">
                                <div class="col">
                             '.$like.'
                                </div>
                                <div class="col">
                       <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->m_id.'">'.count_comment($db,$row->m_id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                </div>
                                <div class="col">
                                '.$repost_btn.'
                                </div>
                            </div>
                            </div>
                            <div id="comment_form'.$row->m_id.'" style="display:none;">
                             <span class = "text-dark"id="old_comment'.$row->m_id.'"></span>
                             <div class="form-group mb-0">
                             <textarea name="comment" class="form-group border-0" id="comment'.$row->m_id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
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
                 <div class="card my-3" id="'.$row->m_id.'">
                                  <div class="card-header border-0 py-2">
                                      <div class="d-flex justify-content-between">
                                          <div class="d-flex justify-content-between">
                                            <a href="profile.php?id='.$row->user_id.'">
                                        <img class="rounded-circle" src="'. e($row->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                    </a>
                                    <div class="ml-3">
                                        <div class="h6 m-0">
                                            <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($row->name).' '.e($row->nom2).'</a>
                                            '.$type.'
                                        </div>
                                        <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class = "text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="dropdown" style="font-style: italic;">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="modal" data-target="#monModal'.$row->m_id.'" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                        <a class="dropdown-item" href="delete_micropost.php?id='. $row->m_id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0 pb-2" style="font-style: italic;">

                        </div>
                         '. convertHashtags(replace_links(nl2br(e($row->legend)))) .'
                         '.$media.'
                        <div class="card-footer border-0 p-0">
                            <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                <div id="displayer_'. $row->m_id .'">
                                    '.likers_updater($row->m_id,$db).'
                                </div>
                                <div id="likers_'. $row->m_id .'" data-toggle="modal" data-target="#likesModal'.$row->m_id.'">
                                    '.display_likers($row->m_id).'
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center my-1">
                                <div class="col">
                             '.$like.'
                                </div>
                                <div class="col">
                       <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->m_id.'">'.count_comment($db,$row->m_id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                </div>
                                <div class="col">
                                '.$repost_btn.'
                                </div>
                            </div>
                            </div>
                            <div id="comment_form'.$row->m_id.'" style="display:none;">
                             <span class = "text-dark"id="old_comment'.$row->m_id.'"></span>
                             <div class="form-group mb-0">
                             <textarea name="comment" class="form-group border-0" id="comment'.$row->m_id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
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
          $output = '';
        }
        echo $output;
}
