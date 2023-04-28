<?php $title="Stories ";
     require ('includes/functions.php');
     //include('partials/_header.php');
     require('config/database.php');
?>

    <link rel="stylesheet" href="assets/css/forum/style.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

    <script async src="https://cdn.ampproject.org/v0.js"></script>
  <title><?= $title ?></title>

  <script async custom-element="amp-story" src="https://cdn.ampproject.org/v0/amp-story-1.0.js"></script>
  <script async custom-element="amp-video" src="https://cdn.ampproject.org/v0/amp-video-0.1.js"></script>
  <script async custom-element="amp-story-auto-ads" src="https://cdn.ampproject.org/v0/amp-story-auto-ads-0.1.js"></script>
  <style amp-custom>
    * {
      box-sizing: border-box;
    }
    amp-story * {
      font-family: 'Helvitica Nueve', sans-serif;
      color: white;
    }
    amp-story-page {
      background: white;
    }
    amp-story h1 {
      font-size: 46px;
    }
    amp-story h2 {
      font-size: 36px;
    }
    amp-story p {
      font-size: 16px;
      line-height: 24px;
    }
    .bold {
      font-weight: bold;
    }
    .bottom {
      align-content: end;
    }
    .medium {
      font-weight: 600;
    }
    .first {
      padding-top: 65px;
    }
    .last {
      padding: 20px;
      background: black;
      opacity: 0.7;
    }
    .blue {
      color: #4285F4;
    }
    .twenty-px {
      font-size: 20px;
    }
    .center {
      text-align: center;
    }
    .lh30 {
      line-height: 30px;
    }
    .icon {
      background-image: url(https://ampbyexample.com/img/AMP-Brand-White-Icon.svg);
      background-repeat: no-repeat;
      background-size: 50px 50px;
      height: 50px;
      object-fit: contain;
      width: 50px;
    }
    .byline {
      letter-spacing: 1.28px;
      padding-bottom: 58px;
    }
    .introducing * {
      line-height: 42px;
    }
    .subtitle-page {
      padding-top: 80px;
    }
    .button {
      align-items: center;
      border: 4px solid #FFFFFF;
      color: #FFFFFF;
      display: flex;
      height: 60px;
      margin: 0 auto;
      max-width: 240px;
      text-decoration:none;
    }
    .button p {
      font-size: 20px;
      width: 100%;
    }
    amp-ad[template="image-template"] img,
    amp-ad[template="video-template"] {
      object-fit: cover;
    }
    ::cue {
      background-color: rgba(0, 0, 0, 0.75);
      font-size: 24px;
      line-height: 1.5;
    }
  </style>
    <body style="margin-top: 60px;">
      <amp-story standalone
        title="Zungvi stories"
        publisher="Powered by amp"
        publisher-logo-src="https://ampbyexample.com/img/AMP-Brand-White-Icon.svg"
        poster-portrait-src="https://ampbyexample.com/img/overview.jpg">

        <!--Content -->
        <?php foreach ($slides as $key => $slide): ?>

       <?php
       // Get the poster info
       $poster = find_user_by_id($slide->user_id);
       if($slide->urlMedia !=null)
       {
            $output ='<amp-story-page id="page-'.($key + 1).'">
                        <amp-story-grid-layer template="fill">
                          <amp-img width="400" height="750" layout="fill" src="'.$slide->urlMedia.'"></amp-img>
                        </amp-story-grid-layer>
                        <amp-story-grid-layer template="vertical" class="bottom">
                         <p class="last"><b>'.$poster->name.'</b> '.$slide->legend.'</p>
                        </amp-story-grid-layer>
                      </amp-story-page>';
       }else{
             $output ='<amp-story-page id="page-'.($key + 1).'">
                         <amp-story-grid-layer template="fill">
                           <amp-img width="400" height="750" layout="fill" src="assets/css/message/chat_background.jpg"></amp-img>
                         </amp-story-grid-layer>
                         <amp-story-grid-layer template="vertical" class="bottom">
                          <p class="last"><b>'.$poster->name.'</b> '.$slide->legend.'</p>
                         </amp-story-grid-layer>
                       </amp-story-page>';
       }


      if($slide->type == "profile_updated")
      {
        $type ='updated his profile picture';
        $output = '<amp-story-page id="page-'.($key + 1).'">
                    <amp-story-grid-layer template="fill">
                      <amp-img width="400" height="750" layout="fill" src="'.$slide->urlMedia.'"></amp-img>
                    </amp-story-grid-layer>
                    <amp-story-grid-layer template="vertical" class="bottom">
                     <p class="last"><b>'.$poster->name.'</b> '.$type.'</p>
                    </amp-story-grid-layer>
                  </amp-story-page>';
      }
      elseif($slide->type == "quotes")
      {
       $type='<span style="color: black;"> added a quotes</span>';
       $output = '<amp-story-page id="page-'.($key + 1).'">
                  <amp-story-grid-layer template="fill">
                  <amp-img width="400" height="750" layout="fill" src="images/cover.jpeg"></amp-img>
                  </amp-story-grid-layer>
                  <amp-story-grid-layer template="vertical" class="bottom">
                  <h1 class="bold"><i class="fas fa-quote-left"></i> '.$slide->legend.'</h1>
                  <p class="last">- '.$slide->quote_author.' posted by <b>'.$poster->name.' '.$poster->nom2.'</b></p>
                  </amp-story-grid-layer>
                 </amp-story-page>';
      }
      elseif($slide->type == "sound")
      {
       $type='<span style="color: black;"> added a sound</span>';
       $media = '<div class="row">
       <div class="col-md-2">
           <a href="postviewer.php?p_i='.$slide->m_id.'"><h3 style="color: #44717C; padding:10px;"><i class="fas fa-headphones-alt"></i></h3></a>
       </div>
       <div class="col-md-10">
              <audio controls>
              <source src="'.$slide->urlMedia.'" type="audio/mpeg">
              </audio><br>
       </div>
       </div>';
      }
      elseif($slide->type == "video")
      {

      $type = '<span style="color: black; font-style: italic;" class="text_box"> added a video</span>';

       $output = '<amp-story-page id="page-'.($key + 1).'" auto-advance-after="stamp-vid">
                      <amp-story-grid-layer template="fill">
                       <amp-video autoplay
                         id="stamp-vid"
                         width="400"
                         height="750"
                         poster="'.$poster->profilepic.'"
                         layout="fill">
                         <source src="'.$slide->urlMedia.'" type="video/mp4">
                         <track default src="" srclang="en">
                       </amp-video>
                      </amp-story-grid-layer>
                      <amp-story-grid-layer template="thirds">
                       <div grid-area="lower-third" class="subtitle-page">
                         <p class="bold twenty-px center">
                          '.replace_links($slide->legend).'
                         </p>
                       </div>
                      </amp-story-grid-layer>
                 </amp-story-page>';
      }
      elseif($slide->type == "cover_updated")
      {
       $type='<span style="color: black;"> updated his cover photo</span>';
       $output = '<amp-story-page id="page-'.($key + 1).'">
                   <amp-story-grid-layer template="fill">
                     <amp-img width="400" height="750" layout="fill" src="'.$slide->urlMedia.'"></amp-img>
                   </amp-story-grid-layer>
                   <amp-story-grid-layer template="vertical" class="bottom">
                    <p class="last"><b>'.$poster->name.' '.$poster->nom2.' updated his cover picture</b></p>
                   </amp-story-grid-layer>
                 </amp-story-page>';
      }
      elseif($slide->type == "shared_a_place")
      {
       $place = find_place_by_id($slide->place_id);
       $type='<span style="color: black;"> shared the place <a href="homeplace.php?pl_i='.$place->id.'">'.$place->place_name.'</a> </span>';
      }
      elseif($slide->type == "shared_post") {
        $from = find_user_by_id($slide->from_user_id);
        $type='<span style="color: black;"> shared a post from <a href="profile.php?id='.$slide->from_user_id.'" >'.$from->name.'</a> </span>';
        $legend = '';
        if($slide->sub_type == "quotes"){

        $media = '<div class="text-center">
                   <h3 style = "font-family:georgia,garamond,serif;font-size:26px;font-style:italic; color:#282923;"><i class="fas fa-quote-left"></i> '. e(nl2br($slide->legend)).' <i class="fas fa-quote-right"></i></h3>
                  </div>
                  <div class="text-right">
                  <p style="color:#282923; font-style:italic;">- '.e(nl2br($slide->quote_author)).'</p>&nbsp
                  </div>';
        }elseif($slide->sub_type == "video"){
        $from = find_user_by_id($slide->from_user_id);
        $type='<b>'.$poster->name.' '.$poster->nom2.'</b> shared a post from <a href="profile.php?id='.$slide->from_user_id.'" >'.$from->name.'</a>';
        $output = '<amp-story-page id="page-'.($key + 1).'" auto-advance-after="stamp-vid">
                       <amp-story-grid-layer template="fill">
                        <amp-video autoplay
                          id="stamp-vid"
                          width="400"
                          height="750"
                          poster="'.$poster->profilepic.'"
                          layout="fill">
                          <source src="'.$slide->urlMedia.'" type="video/mp4">
                          <track default src="" srclang="en">
                        </amp-video>
                       </amp-story-grid-layer>
                       <amp-story-grid-layer template="thirds">
                        <div grid-area="lower-third" class="subtitle-page">
                          <p class="last">'.$type.' :
                           '.replace_links($slide->legend).'
                          </p>
                        </div>
                       </amp-story-grid-layer>
                  </amp-story-page>';

        }elseif($slide->sub_type == 'sound'){

        $media = '<div class="row">
        <div class="col-md-2">
            <a href="postviewer.php?p_i='.$slide->m_id.'"><h3 style="color: #44717C; padding:10px;"><i class="fas fa-headphones-alt"></i></h3></a>
        </div>
        <div class="col-md-10">
               <audio controls>
               <source src="'.$slide->urlMedia.'" type="audio/mpeg">
               </audio><br>
        </div>
        </div>';
      }else{
        if($slide->urlMedia != ""){
        $media = $slide->urlMedia;
        }else{
          $media = 'assets/css/message/chat_background.jpg';
        }
        $type='<b>'.$poster->name.' '.$poster->nom2.'</b> shared a post from <a href="profile.php?id='.$slide->from_user_id.'" >'.$from->name.'</a>';
        $output = '<amp-story-page id="page-'.($key + 1).'">
                    <amp-story-grid-layer template="fill">
                      <amp-img width="400" height="750" layout="fill" src="'.$media.'"></amp-img>
                    </amp-story-grid-layer>
                    <amp-story-grid-layer template="vertical" class="bottom">
                     <p class="last"> '.$type.' :<br>
                     '.replace_links($slide->legend).'
                     </p>
                    </amp-story-grid-layer>
                  </amp-story-page>';
      }
      }
      else
      {
        $type='<span style="color: black; font-style: italic;"> added a status</span>';
      }

       ?>

       <?php echo $output; ?>





      <?php endforeach ?>

        <amp-story-page id="page-2">
               <amp-story-grid-layer template="fill">
                 <amp-img width="400" height="750" layout="fill" src="https://ampbyexample.com/img/overview.jpg"></amp-img>
               </amp-story-grid-layer>
               <amp-story-grid-layer template="vertical" class="bottom">
                 <h2 class="bold">Overview</h2>
                 <p>We held the second AMP Conf to celebrate the breadth of the AMP
                   community and announce the latest AMP innovations. We engaged 400+
                   devs in-person over two days and thousands globally on live stream.</p>
                 <p class="last">Here are the key launches by the AMP team and others this year</p>
               </amp-story-grid-layer>
        </amp-story-page>
        <!-- Content -->

      </amp-story>
    </body>
    <!-- SCRIPT -->
<script src="assets/js/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".timeago").timeago();
         fetch_online_user();
         fetch_incomming_msg();
         fetch_forum_online_user();
         fetch_relatives_list();

        setInterval(function(){
           update_last_activity();
           fetch__online_user();
           fetch_incomming_msg();
           fetch_forum_online_user();
        },5000);

         function fetch_online_user()
        {
          $.ajax({
            url:"ajax/fetch_online_user.php",
            method:"POST",
            success:function(data){
              $('#user_details').html(data);
            }
          })
        }

        function update_last_activity()
        {
          $.ajax({
            url:"ajax/update_last_activity.php",
            success:function()
            {

            }
          })
        }

        function fetch_incomming_msg()
        {
          $.ajax({
            url:"ajax/fetch_incomming_msg.php",
            method:"POST",
            success:function(data)
            {
              $('#message').html(data);
            }
          })
        }


        function fetch_forum_online_user()
        {
          $.ajax({
            url:"ajax/fetch_forum_online_users.php",
            method:"POST",
            success:function(data){
              $('#online_users').html(data);
            }
          })
        }
         $("a.show").on("click", function(e){
            e.preventDefault();
            var url='ajax/forum_members_selector.php';
            alert('Boom');
         $.ajax({
                type:'POST',
                url:url,
                success: function(response){
                    $("#display_members").html(response);
                }

            });
        });


         $("a.validate").on("click", function(e){
            e.preventDefault();
            var url='ajax/validate_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("validate")[1];
            var action = $(this).data('action');

              $.ajax({
                type:'POST',
                url:url,
                data: {
                       reaction_id: reactionId,
                       action: action
                      },
                success: function(response){
                    $("#likers_"+ reactionId).html(response);
                    $("#revalidate"+reactionId).show();
                    $("#validate"+reactionId).hide();
                     $("#redenied"+reactionId).hide();
                    $("#denied"+reactionId).show();
                   // $("#validate"+reactionId).show();

                }

            });
        });


        $("a.denied").on("click", function(e){
            e.preventDefault();

            var url='ajax/denied_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("denied")[1];
              $.ajax({
                type:'POST',
                url:url,
                data: {
                       reaction_id: reactionId
                      },
                success: function(response){
                    $("#revalidate"+reactionId).hide();
                    $("#validate"+reactionId).show();
                    $("#redenied"+reactionId).show();
                    $("#denied"+reactionId).hide();
                    $("#likers_"+ reactionId).html(response);
                }
            });
        });


        $("a.satisfied").on("click", function(e){
            e.preventDefault();

            var url='ajax/satisfiedwith_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("satisfied")[1];

              $.ajax({
                type:'POST',
                url:url,
                data: {
                       reaction_id: reactionId
                      },
                success: function(response){

                    $("#satisfied"+reactionId).hide();
                    $("#validate"+reactionId).hide();
                    $("#denied"+reactionId).hide();
                   // $("#validate"+reactionId).show();

                   $("#likers_"+ reactionId).html(response);

                }

            });
        });

        $("a.comment").on("click", function(e){
            e.preventDefault();

            var url='ajax/comment_forum.php';
            var id= $(this).attr("id");
            var reaction_id = id.split("comment")[1];
            var messageVar= "msg"+reaction_id;
            var message = $('textarea#'+messageVar).val();
                if (message.length > 0) {
             $.ajax({
                type:'POST',
                url:url,
                data: {
                       reactionId: reaction_id,
                       message: message
                      },
                success: function(response){
                   $("#comment_displayer"+reaction_id).html(response);
                   $("textarea#"+messageVar).html('');
                }

            });
           }
        });

         $("a.like").on("click", function(e){
            e.preventDefault();

        var id= $(this).attr("id");
        var url='ajax/forumpost_like.php';
        var action = $(this).data('action');
        var forumpostId = id.split("like")[1];

            $.ajax({
                type:'POST',
                url:url,
                data: {
                       forumpost_id: forumpostId,
                       action: action
                      },
                beforeSend: function(){
                    if(action == 'like'){
                        $("#"+id).html('<a id="unlike<?= $post->id ?>" data-action="unlike" href="unlike_forumpost.php?id=<?= $post->id ?>" class="like"><button type="button" class="btn btn-fbook btn-block btn-sm"><i class="far fa-heart" aria-hidden="true"></i> unlike</button></a>').data('action', 'unlike');
                    }else{
                        $("#"+id).html('<a id="like<?= $post->id ?>" data-action="like" href="like_forumpost.php?id=<?= $post->id ?>" class="like"><button type="button" class="btn btn-fbook btn-block btn-sm"><i class="far fa-heart" aria-hidden="true"></i> like</button></a>').data('action', 'like');
                    }
                },
                success: function(likers){
                   $("#likers_"+ forumpostId).html(likers);
                }

            });
        });



    });


    $(document).ready(function() {

          setInterval(function(){
          fetch_group_chat_history();
          }, 5000);

          $('[id^=detail-]').hide();
          $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
        });
          var url ='ajax/search.php';
        $('input#searchbox').on('keyup', function(){
            var query = $(this).val();
        if (query.length > 2) {
          $.ajax({
                type:'POST',
                url:url,
                data: {
                       query: query
                      },
                beforeSend: function(){
                    $("#spinner").show();
                },
                success: function(data){
                   $("#spinner").hide();
                   $("#display-results ").html(data).show();

                }

            });
        }else{
            $("#display-results ").hide();
        }

    });

    $('#group_chat_dialog').dialog({
      autoOpen:false,
      width:600
    });

    $('#group_chat').click(function(){
      $('#group_chat_dialog').dialog('open');
      $('#is_active_group_chat_window').val('yes');
      fetch_group_chat_history();
    });

    $('#send_group_chat').click(function(){
      var chat_message = $('#group_chat_message').html();
      var action = 'insert_data';
      if(chat_message != '')
      {
        $.ajax({
          url:"ajax/group_chat.php",
          method: "POST",
          data:{chat_message:chat_message,action:action},
          success:function(data){
            $('#group_chat_message').html('');
            $('#group_chat_history').html(data);
          }
        })
      }
    });

    function fetch_group_chat_history()
    {
      var group_chat_dialog_active = $('#is_active_group_chat_window').val();
      var action = "fetch_data";
      if(group_chat_dialog_active == 'yes')
      {
          $.ajax({
            url:"ajax/group_chat.php",
            method: "POST",
            data:{action:action},
            success:function(data)
            {
             $('#group_chat_history').html(data);
            }
          })
      }
    }

    $('#uploadFile').on('change', function(){
         $('#uploadImage').ajaxSubmit({
         target: "#group_chat_message",
         resetForm: true
         });
    });

    function fetch_relatives_list() {
        $.ajax({
            url: "ajax/fetch_relatives_list.php",
            method: "POST",
            beforeSend: function(){
              $('#relatives_spinner').show();
            },
            success: function(data) {
                $('#relativesList').html(data);
            }
        })
    }

        });

</script>
<!-- SCRIPT -->
