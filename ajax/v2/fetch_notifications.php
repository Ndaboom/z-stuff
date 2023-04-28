<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
  
        $query ="SELECT *
          FROM notifications
          WHERE subject_id= :subject_id
          AND seen= :seen 
          ORDER BY created_at DESC LIMIT ".$_POST["start"].", 5000";
        $statement = $db->prepare($query);
    	$statement->execute([
           'subject_id'=>get_session('user_id'),
           'seen'=>0
    	]);

    	$notifications = $statement->fetchAll(PDO::FETCH_OBJ);
    	$total_row = $statement->rowCount();

        if($total_row == 0){

            $query ="SELECT *
            FROM notifications
            WHERE subject_id= :subject_id
            AND seen= :seen 
            ORDER BY created_at DESC LIMIT ".$_POST["start"].", 15";
            $statement = $db->prepare($query);
            $statement->execute([
                'subject_id'=>get_session('user_id'),
                'seen'=>1
            ]);
    
            $notifications = $statement->fetchAll(PDO::FETCH_OBJ);
            $total_row = $statement->rowCount();
  
        }

    	$output= '';
    	
    	if($total_row > 0)
    	{
            foreach ($notifications as $notification)
               {

              $user_profile = find_user_by_id($notification->user_id);
              $him = find_user_by_id($notification->subject_id);
              
              if($notification->seen == 1){
              $status = "";
              }else{
              $status = "class=not-read";
              }
              
              if($notification->name=="friend_request_accepted"){
                
                $output .= '
                     <li '.$status.'>
                                             <a href="timeline.php?id='.$user_profile->id.'&n='.$user_profile->name.'">
                                                 <div class="drop_avatar status-online"> <img src="/'.$user_profile->profilepic.'" alt="" style="height:50px; width:50px;">
                                                 </div>
                                                 <div class="drop_text">
                                                     <p>
                                                        <strong class="text-link">'.$user_profile->name.' '.$user_profile->nom2.'</strong> Accepted your friendship request
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                                         </li>
                ';
              
              }elseif($notification->name=="newOrders"){
                $output .= '
                 <li '.$status.'>
                                             <a href="#">
                                                 <div class="drop_avatar"> <img src="/icons/shopping-cart.png" alt="">
                                                 </div>
                                                 <span class="drop_icon bg-gradient-primary">
                                                    <i class="icon-feather-thumbs-up"></i>
                                                </span>
                                                 <div class="drop_text">
                                                     <p>
                                                        New order for you!
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                                         </li>
                ';
              }elseif($notification->name == "relatives_suggestion"){
                $output .= '
                 <li '.$status.'>
                                             <a href="timeline.php?id='.$user_profile->id.'&n='.$user_profile->name.'">
                                                 <div class="drop_avatar status-online"> <img src="/'.$user_profile->profilepic.'" alt="" style="height:50px; width:50px;">
                                                 </div>
                                                 <div class="drop_text">
                                                     <p>
                                                        Looks like you may know  <span class="text-link">'.$relatives->name.' '.$relatives->nom2.'</span>
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                                         </li>
                ';
              }elseif($notification->name == "shared_your_post"){
                $output .= '
                <li '.$status.'>
                                             <a href="#">
                                                 <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" alt="" style="height:50px; width:50px;">
                                                 </div>
                                                 <div class="drop_text">
                                                     <p>
                                                        <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> Shared your post
                                                        <span class="text-link">Css Flex Box </span>
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                                         </li>
                ';
              }elseif($notification->type=="A commence a suivre votre place "){
                $place = find_place_by_id($notification->place_id);
                $output .= '
                <li '.$status.'>
                                             <a href="#">
                                                 <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" alt="" style="height:50px; width:50px;">
                                                 </div>
                                                 <div class="drop_text">
                                                     <p>
                                                        <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> started following your page
                                                        <span class="text-link">'.$place->place_name.'</span>
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                                         </li>
                ';
              }elseif($notification->type == "A commence a suivre votre activite"){
                $event = find_event_by_id($notification->event_id);
                $output .= '
                <li '.$status.'>
                                             <a href="event_home.php?n='.$event->event_name.'&ev_i='.$event->id.'">
                                                 <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'"  style="height:50px; width:50px;" alt="">
                                                 </div>
                                                 <div class="drop_text">
                                                     <p>
                                                        <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> started following your page
                                                        <span class="text-link">'.$event->event_name.'</span>
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                </li>
                ';
              }elseif($notification->name=="friend_request_sent")
              {
              
              if(!already_friends_min($notification->user_id,get_session('user_id')))
                {
                
                $button = '
                <span class="text-link accept_friends" id="request_button'.$notification->user_id.'" data-user_id="'.$notification->user_id.'" data-notification_id="'.$notification->id.'">Accept</span>
                <span id="request_accepted'.$notification->id.'" style="display:none;"> - Request accepted</span>
                ';
                }else{
                
                $button = '<span id="request_accepted'.$notification->id.'"> - Request accepted</span>';
                
                }
              
              $output .= '
                 <li '.$status.'>
                                             <a href="timeline.php?id='.$user_profile->id.'&n='.$user_profile->name.'">
                                                 <div class="drop_avatar status-online"><img src="/'.e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : '/images/default.png') .'" style="width:50px; height:50px;" alt="">
                                                 </div>
                                                 <div class="drop_text">
                                                     <p>
                                                        <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> sent you a friend request
                                                        '.$button.'
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                                         </li>
              ';
              
              }elseif($notification->type=="A commence a suivre votre place"){
                   $place = find_place_by_id($notification->place_id);
                $output .= '
                <li '.$status.' >
                                             <a href="place_home.php?n='.$place->place_name.'&pl_i='.$place->id.'">
                                                 <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" alt="" style="height:50px; width:50px;">
                                                 </div>
                                                 <div class="drop_text">
                                                     <p>
                                                        <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> started following your page
                                                        <span class="text-link">'.$place->place_name.'</span>
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                                         </li>
                ';
              }elseif($notification->name=="forum request accepted")
              {
                   $fpic=get_forum_pic($notification->forum_id);
                   $fname=get_forum_name($notification->forum_id);

                   $output .= '
                    <li '.$status.' >
                      <a href="forum_home.php?n='.e($fname->forum_name).'&fr_i='.$notification->forum_id.'">
                                                 <div class="drop_avatar"> <img src="/'.e($src =($fpic->forum_pic != null) ? $fpic->forum_pic : '/images/portada_7.png').'"  style="height:50px; width:50px;" alt="">
                                                 </div>
                                                 <div class="drop_text">
                                                     <p>
                                                        <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> Your request to join the forum
                                                        <span class="text-link">'.e($fname->forum_name).'</span>
                                                     </p>
                                                     <time> '.zungvi_time_ago($notification->created_at).' </time>
                                                 </div>
                                             </a>
                  </li>
                   ';
              }elseif($notification->name=="join_forum_request")
              {
                  $userpic=selectUserProfilePic($notification->user_id);
                   $fname=get_forum_name($notification->forum_id);
                   if(!is_him_in($notification->user_id,$notification->forum_id))
                   {
                       $is_him_in = '<a class="text-green-600 accept" href="" data-user_id="'.$notification->user_id.'" data-forum_id="'.$notification->forum_id.'">Accept</a>
                                     <a class="text-red-600">Refuse</a>';
                   }else{
                    $is_him_in = '';
                   }

                   $output .= '
                    <li '.$status.'>
                      <a href="#">
                        <div class="drop_avatar"> <img src="/'.$userpic->profilepic.'"  style="height:50px; width:50px;" alt="">
                        </div>
                        <div class="drop_text">
                            <p>
                            <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> request to join your forum
                            <span class="text-link">'.e($fname->forum_name).'</span>
                            </p>
                            '.$is_him_in.'
                            <time> '.zungvi_time_ago($notification->created_at).' </time>
                        </div>
                    </a>
                  </li>
                   ';
              }elseif($notification->type=="Invite you to join this event")
              {
                $event = find_event_by_id($notification->event_id);

                if(!an_event_has_already_been_followed($notitication->event_id, $notification->subject_id))
                 {
                     $is_him_in = '<button class="btn btn-outline-success follow_event" data-user_id="'.$notification->user_id.'" 
                     data-event_id="'.$notification->event_id.'" data-event_name="'.$event->event_name.'" data-notification_id="'.$notification->id.'"> Follow</button>
                                   <button class="btn btn-outline-warning ignore_event" data-notification_id="'.$notification->id.'">Ignore</button>';
                 }else{
                  $is_him_in = 'You are already following this activity';
                 }

                 $output .= '
                  <li '.$status.'>
                      <a href="#">
                        <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'"  style="height:50px; width:50px;" alt="">
                        </div>
                        <div class="drop_text">
                            <p>
                            <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> request to join your forum
                            <span class="text-link">'.e($event->event_name).'</span>
                            </p>
                            '.$is_him_in.'
                            <time> '.zungvi_time_ago($notification->created_at).' </time>
                        </div>
                    </a>
                  </li>
                   ';
              }elseif($notification->name=="viewed_your_profile"){
                 $output .= '
                 <li '.$status.'>
                 <a href="exporer.php?id='.$_SESSION['user_id'].'">
                     <div class="drop_avatar"> <img src="/images/default.png" alt="">
                     </div>
                     <div class="drop_text">
                         <p>
                            <strong>People </strong>viewed your profile
                            <span class="text-link">make you more friends </span>
                         </p>
                         <time> '.zungvi_time_ago($notification->created_at).' </time>
                     </div>
                 </a>
                </li>
                 ';
              }elseif($notification->name=="liked_post"){

                $row = get_post_data($notification->post_id);

                  if($row->urlMedia != null)
                  {
                      $media = ' <img src="/'.$row->urlMedia.'" class="img-thumbnail img-responsive" >';
                  }else{
                      $media = '';
                  }

                  $output .= '
                  <li '.$status.'>
                    <a href="post.php?id='.$row->id.'">
                        <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" style="width:50px; height:50px;" alt="">
                        </div>
                        <span class="drop_icon bg-gradient-primary">
                        <i class="icon-feather-thumbs-up"></i>
                    </span>
                        <div class="drop_text">
                            <p>
                            <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> liked your post
                            </p>
                            <time> '.zungvi_time_ago($notification->created_at).' </time>
                        </div>
                    </a>
                </li>';

              }elseif($notification->name=="has_commented"){

                $row = get_post_data($notification->post_id);
                $output .= '
                <li '.$status.'>
                <a href="post.php?id='.$row->id.'">
                    <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" alt="'.$user_profile->name.' profile picture">
                    </div>
                    <div class="drop_text">
                        <p>
                           <strong>'.$user_profile->name.' '.$user_profile->nom2.' </strong>commented on your post : '.$notification->type.'
                        </p>
                        <time> '.zungvi_time_ago($notification->created_at).' </time>
                    </div>
                </a>
                </li>';
              }elseif($notification->name=="comment_liked"){

                $row = get_post_data($notification->post_id);
                $output .= '
                <li '.$status.'>
                    <a href="post.php?id='.$row->id.'">
                        <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" alt="">
                        </div>
                        <span class="drop_icon bg-gradient-primary">
                        <i class="icon-feather-thumbs-up"></i>
                    </span>
                        <div class="drop_text">
                            <p>
                            <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> liked your comment
                            '.$notification->type.'
                            </p>
                            <time> '.zungvi_time_ago($notification->created_at).' </time>
                        </div>
                    </a>
                </li>';

              }elseif($notification->type == "post_liked"){

                $row = find_place_by_id($notification->place_id);

                $output .= '
                <li '.$status.'>
                    <a href="place_home.php?n='.$row->place_name.'&pl_i='.$row->id.'">
                        <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" alt="">
                        </div>
                        <span class="drop_icon bg-gradient-primary">
                        <i class="icon-feather-thumbs-up"></i>
                    </span>
                        <div class="drop_text">
                            <p>
                            <strong>'.$user_profile->name.' '.$user_profile->nom2.'</strong> liked '.$row->place_name.' post
                            </p>
                            <time> '.zungvi_time_ago($notification->created_at).' </time>
                        </div>
                    </a>
                </li>';
              }elseif($notification->type == "has_commented"){

                $row = find_place_by_id($notification->place_id);

                $output .= '
                <li '.$status.'>
                <a href="place_home.php?n='.$row->place_name.'&p_i='.$row->id.'">
                    <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" alt="'.$user_profile->name.' profile picture">
                    </div>
                    <div class="drop_text">
                        <p>
                           <strong>'.$user_profile->name.' '.$user_profile->nom2.' </strong>commented on '.$row->place_name.' post
                        </p>
                        <time> '.zungvi_time_ago($notification->created_at).' </time>
                    </div>
                </a>
                </li>';

              }elseif($notification->type == "place_admin_has_commented"){

                $row = find_place_by_id($notification->place_id);

                $output .= '
                <li '.$status.'>
                <a href="place_home.php?n='.$row->place_name.'&p_i='.$row->id.'">
                    <div class="drop_avatar"> <img src="/'.$user_profile->profilepic.'" alt="'.$user_profile->name.' profile picture">
                    </div>
                    <div class="drop_text">
                        <p>
                           <strong>'.$user_profile->name.' '.$user_profile->nom2.' </strong>also commented on '.$row->place_name.' post
                        </p>
                        <time> '.zungvi_time_ago($notification->created_at).' </time>
                    </div>
                </a>
                </li>';

              }
                     
              }
              
              echo $output;
        }else{
            echo "<p class='text-center'>No new notifications</p>";
        }
  
  }
