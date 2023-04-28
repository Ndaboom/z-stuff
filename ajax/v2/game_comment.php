<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

               
$comments= fetch_game_comments($_SESSION['game_id']);
$output = '';

if(count($comments) != 0){
   foreach($comments as $row)
{
    $user = find_user_by_id($row->user_id);
    if($_SESSION['user_id'] == $row->user_id){
        $delete_btn = '<a href="" class="delete_comment" data-comment_id="'.$row->id.'" data-poster_id="'.$row->user_id.'" style="color:red;cursor: pointer;font-size:11px;font-weight:bold;">Delete comment</a>';
    }else{
        $delete_btn = '';
    }
    $output .= '<div class="flex gap-x-4 mb-5 relative" id="comment_box'.$row->id.'">
                    <img src="/'.$user->profilepic.'" alt="" class="rounded-full shadow w-12 h-12">
                    <div>
                        <h4 class="text-base m-0 font-semibold">'.$row->username.'</h4>
                        <span class="text-gray-700 text-sm"> '.$user->profession.' </span>
                        <p class="mt-3">
                            '.$row->legend.'
                        </p>
                        <img class="w-full" src="'.$row->urlMedia.'" />
                        '.$delete_btn.'
                    </div>
                </div>
                ';
}
    echo $output;
}else{
    echo "No comment yet...";
}