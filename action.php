<?php
session_start();
require("includes/init.php");
require("includes/functions.php");
require("config/database.php");
extract($_POST);

if(isset($_POST['action']))
{
	$output = '';
	if($_POST['action'] == 'insert')
	 {
	 	$data = array(
	 		':user_id'      => $_SESSION["user_id"],
	 		':content'      => $_POST["post_content"],
	 		':created_at'   => date("Y-m-d") . ' ' . date("H:i:s", STRTOTIME(date('h:i:sa')))

	 	);

	 	$query= "INSERT INTO microposts(legend,user_id,created_at)
	                  VALUES (:content,:user_id,:created_at)
	                  ";
	    $statement = $db->prepare($query);
	    $statement->execute($data);


	 }

	 if($_POST['action'] == 'follow')
	 {

	$q =$db-> prepare(
		               'INSERT INTO friends_relationships(user_id1,user_id2)
		               VALUES(:user_id1,:user_id2)');

	$q->execute([
		'user_id1'=>get_session('user_id'),
		'user_id2'=>$destinator_id
	]);
	// Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)
                         VALUES(:subject_id, :name, :user_id)');
                $q->execute([
                'subject_id' => $destinator_id,
                'name' => 'friend_request_sent',
                'user_id' => get_session('user_id'),
                ]);
	 }

   if($_POST['action'] == 'accept_friends_request')
	 {

	$q =$db-> prepare("UPDATE friends_relationships
		               SET status ='1'
		               WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
			   	       OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");

	$q->execute([
		'user_id1'=>get_session('user_id'),
		'user_id2'=>$user_id
	]);

	// Sauvegarde de la notification
    $q = $db->prepare('INSERT INTO notifications(subject_id, name, user_id)
                       VALUES(:subject_id, :name, :user_id)');

						$q->execute([
							'subject_id' => $user_id,
							'name' => 'friend_request_accepted',
							'user_id' => get_session('user_id'),
                        ]);
	 }

   if($_POST['action'] == 'unlike_comment')
   {
     $q=$db->prepare('DELETE FROM notifications
                       WHERE user_id= :user_id AND name= :name AND comment_id= :comment_id');
             $q->execute([
                 'user_id'=> get_session('user_id'),
                 'name'=> 'comment_liked',
                 'comment_id'=> $commentid
             ]);
   }

   if($_POST['action'] == 'like_comment')
   {

    if($poster_id != get_session('user_id'))
    {
     // Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(subject_id, name,type, user_id,post_id,comment_id)
                         VALUES(:subject_id, :name,:type,:user_id,:post_id,:comment_id)');
                $q->execute([
                'subject_id' => $poster_id,
                'name' => 'comment_liked',
                'type' =>$comment,
                'user_id' => get_session('user_id'),
                'post_id' =>$post,
                'comment_id'=>$commentid
                ]);
    }
   }

	 if($_POST["action"] == 'submit_comment')
	 {
	 	$data = array(
                ':post_id'    =>$_POST["post_id"],
                ':user_id'    =>$_SESSION["user_id"],
                ':comment'    =>$_POST["comment"],
                ':created_at' =>date("Y-m-d") . ' ' .date("H:i:s",STRTOTIME(date('h:i:sa')))
	 	);
	 	$query = "
          INSERT INTO comments(post_id,user_id,comment,created_at)
          VALUES(:post_id, :user_id, :comment, :created_at)
	 	";
	 	$statement = $db->prepare($query);
	 	$statement->execute($data);

    if(get_session('user_id') != $poster)
       {
         // Sauvegarde de la notification
      $q = $db->prepare('INSERT INTO notifications(subject_id, name,type, user_id,post_id)
                         VALUES(:subject_id, :name,:type ,:user_id,:post_id)');
                $q->execute([
                'subject_id' => $poster,
                'name' => 'has_commented',
                'type' =>$_POST["comment"],
                'user_id' => get_session('user_id'),
                'post_id' => $_POST["post_id"]
                ]);
       }

	 }
	 if($_POST["action"] == "fetch_user_last_post")
	 {
       $query = "
          SELECT * FROM microposts
          WHERE user_id = '".$_SESSION["user_id"]."'
          ORDER BY -created_at LIMIT 1
	 	";
	 	$statement = $db->prepare($query);
	 	$output = '';
	 	if($statement->execute())
	 	{
	 		$result = $statement->fetchAll(PDO::FETCH_OBJ);
	 		if(count($result) != 0){
	 		foreach ($result as $row) {

				if(user_has_already_liked_the_micropost($row->id)){
                  $like='
                  <button type="button" class="btn btn-zung btn-block btn-sm like" id="unlike'. $row->id .'" data-action="unlike"><i class="fas fa-heart" aria-hidden="true"></i> Unlike</button>
                  ';
               	}else{
               		$like='
                    <button type="button" class="btn btn-zung btn-block btn-sm like" id="like'.$row->id .'" data-action="like" data-poster="'.$row->user_id.'" data-postid="'.$row->id.'"><i class="far fa-heart" aria-hidden="true"></i> like</button>
               		';
               	}

								if($row->urlMedia !=null)
               	{
                     $media='<a href="postviewer.php?p_i='.$row->id.'"><img class="" src="'.$row->urlMedia.'" alt="Failed to load...please refresh the page" style="width:100%;min-height:200px; max-height:600px;"></a>';
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
                      <a href="postviewer.php?p_i='.$row->id.'"><h3 style="color: #44717C; padding:10px;"><i class="fas fa-headphones-alt"></i></h3></a>
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
               	$firstname=get_user_name($row->user_id);
               	$secondname=get_user_second_name($row->user_id);
               	$profilepic=selectUserProfilePic($row->user_id);

                if($row->type == "quotes")
                {
                   $output .= '
                  <div class="card my-3" id="'.$row->id.'">
                                          <div class="card-header  border-0 py-2">
                                          <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="/'. e($profilepic->profilepic) .'" style="height: 30px; width: 30px; border:1.5px solid #f5f6fa;" alt="" />
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($firstname->name).' '.e($secondname->nom2).'</a> <b>(You)</b> '.$type.'
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span><small>'.zungvi_time_ago($row->created_at).'</small></span><i class="fa fa-globe" aria-hidden="true"></i></div>
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
                            <div class="text-center">
                             <h3 style = "font-family:georgia,garamond,serif;font-size:26px;font-style:italic; color:#282923;"><i class="fas fa-quote-left"></i> '. convertHashtags(nl2br($row->legend)).' <i class="fas fa-quote-right"></i></h3>
                            </div>
                            <div class="text-right">
                            <p style="color:#282923;">- '.nl2br($row->quote_author).'</p>&nbsp
                            </div>
                            <a href="profile.php?id='.get_session('user_id').'#post_list" class="btn btn-outline-primary" >see all your publications <i class="fas fa-user"></i></a>
                            <div class="card-footer  border-0 p-0">
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
                           <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                                <div id="comment_form'.$row->id.'" style="display:none;">
                                 <span class = "text-dark"id="old_comment'.$row->id.'"></span>
                                 <div class="form-group mb-0">
                                 <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                 </div>
                                 <div class="form-group" align="right">
                                 <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                 </div>
                                </div>
                            </div>
                        </div>';

                }elseif($row->type="sound")
                {
                   $output .= '
                   '.$modal.'
                  <div class="card my-3" id="'.$row->id.'">
                                          <div class="card-header  border-0 py-2">
                                          <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="/'. e($profilepic->profilepic) .'" style="height: 40px; width: 40px; border:1.5px solid #f5f6fa;" alt="" />
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($firstname->name).' '.e($secondname->nom2).'</a> <b>(You)</b> '.$type.'
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span class = "text-muted" title="'. $row->created_at .'">'.zungvi_time_ago($row->created_at).'</span><i class="fa fa-globe" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    <div class="dropdown" style="font-style: italic;">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="modal" data-target="#option'.$row->id.'" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" id="dropdown-buttom">
                                            <a class="dropdown-item" href="delete_micropost.php?id='. $row->id .'"><i class="fa fa-trash"></i> Supprimer</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            '.convertHashtags(nl2br(replace_links($row->legend))).'
                            </div>
                            '.$media.'
                            <div>
                            </div>
                             <div class="card-body text-center">
                            </div>
                            <a class="btn btn-outline-primary" href="profile.php?idi='.get_session('user_id').'">All your publications <i class="fas fa-user"></i></a>
                            <div class="card-footer  border-0 p-0">
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
                           <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i> Comment</button>
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                                <div id="comment_form'.$row->id.'" style="display:none;">
                                 <span class = "text-dark"id="old_comment'.$row->id.'"></span>
                                 <div class="form-group mb-0">
                                 <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                 </div>
                                 <div class="form-group" align="right">
                                 <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment" data-poster="'.$row->user_id.'">Comment </button>
                                 </div>
                                </div>
                            </div>
                        </div>';

                }
                else
                {
                  $output .= '
                     <div class="card my-3" id="post'.$row->id.'">
                                      <div class="card-header  border-0 py-2">
                                          <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="/'. e($profilepic->profilepic) .'" style="height: 30px; width: 30px; border:1.5px solid #f5f6fa;" alt="" />
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="profile.php?id='.e($row->user_id).'" style="font-style: italic;">'. e($firstname->name).' '.e($secondname->nom2).'</a> <b>(You)</b> '.$type.'
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all; font-style: italic;"><span><small>'.zungvi_time_ago($row->created_at).'</small></span><i class="fa fa-globe" aria-hidden="true"></i></div>
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

                            <div class="card-body pt-0 pb-2">

                            </div>
                            '.$media.'
                             '.convertHashtags(nl2br(replace_links($row->legend))).'
                            <a href="profile.php?id='.get_session('user_id').'" class="btn btn-outline-primary" >see all your publications <i class="fas fa-user"></i></a>
                            <div class="card-footer  border-0 p-0">
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
                           <button type="button" class="btn btn-zung btn-block btn-sm post_comment" id="'.$row->id.'">'.count_comment($db,$row->id).' <i class="far fa-comment" aria-hidden="true"></i></button>
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                                <div id="comment_form'.$row->id.'" style="display:none;">
                                 <span class = "text-dark"id="old_comment'.$row->id.'"></span>
                                 <div class="form-group mb-0">
                                 <textarea name="comment" class="form-group border-0" id="comment'.$row->id.'" placeholder="your comment..." cols="63" maxlength="160"></textarea>
                                 </div>
                                 <div class="form-group" align="right">
                                 <button type="button" name="submit_comment" class="btn btn-zung btn-block btn-sm submit_comment">Comment </button>
                                 </div>
                                </div>
                            </div>
                        </div>

                ';
                }

            }
	 		echo $output;
	 		 }

	 	}
	 }

	 if($_POST["action"] == "fetch_comment")
	 {
	 	$query = "
          SELECT * FROM comments INNER JOIN users ON users.id= comments.user_id
          WHERE post_id = '".$_POST["post_id"]."'
          ORDER BY comment_id ASC
	 	";
	 	$statement = $db->prepare($query);
	 	$output = '';
	 	if($statement->execute())
	 	{
	 		$result = $statement->fetchAll(PDO::FETCH_OBJ);
	 		foreach ($result as $row) {

        if(if_already_liked(get_session('user_id'),$row->comment_id))
        {
          $button= '
              <button type="button" class="btn btn-zung btn-block btn-sm unlike_comment" name="unlike_comment" data-poster_id="'.$row->user_id.'" data-comment="'.$row->comment.'" data-post="'.$row->post_id.'" data-commentid="'.$row->comment_id.'"><i class="fas fa-heart" aria-hidden="true"></i></button>
                   ';
        }else
        {
          $button = '
            <button type="button" class="btn btn-zung btn-block btn-sm like_comment" name="like_comment" data-poster_id="'.$row->user_id.'" data-comment="'.$row->comment.'" data-post="'.$row->post_id.'" data-commentid="'.$row->comment_id.'"><i class="far fa-heart" aria-hidden="true"></i></button>
                    ';
        }
	 			$output .= '
                <div class="row" style="margin-left:10px;">
                   <div class="col-md-2">
                   <img src="/'.$row->profilepic.'" class="img-thumbnail img-responsive rounded-circle" style="width:50px;height:50px;"/>
                   </div>
                   <div class="col-md-8" style="margin-top:2px;padding-left:0;">
                    <small><b>'.$row->name.'</b><br/>
                      '.convertHashtags(replace_links(e($row->comment))).'
                    </small>
                   </div>
                   <div class="col-md-2">
                   '.$button.'
                   </div>
                   </div>
                   <br />
	 			';
	 		}
	 		echo $output;
	 	}
	 }

}
