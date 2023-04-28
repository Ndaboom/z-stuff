<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["channel_id"]))
  {
        
    	$output= '
      <div class="like-btn" data-action="like" data-channel_id='.$_POST["channel_id"].' uk-tooltip="Unlike it">
      <i class="far fa-thumbs-up"></i>
      <span class="likes">'.count_channel_likes($_POST["channel_id"]).'</span>
      </div>
      <div class="flex h-2 w-36 bg-gray-200 rounded-lg overflow-hidden">
          <div class="w-2/3 bg-gradient-to-br from-purple-400 to-blue-400 h-4"></div>
      </div>
      <div class="like-btn" data-action="unlike" data-channel_id='.$_POST["channel_id"].' uk-tooltip="I like it">
          <i class="far fa-thumbs-down"></i>
          <span class="likes">'.count_channel_unlikes($_POST["channel_id"]).'</span>
      </div>
        ';

        echo $output;
 }