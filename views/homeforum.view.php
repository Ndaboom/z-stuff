<?php $title="Forum";
     require ('includes/functions.php');
     include('partials/_header.php');
     require('config/database.php');
?>

    <link rel="stylesheet" href="assets/css/forum/style.css">
<?php $_SESSION['fr_i']=$forum->id;
      $_SESSION['fr_n']=$forum->forum_name; ?>

    <body style="margin-top: 60px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                   <div class="card">
                       <div class="card-body" style="font-style: italic;">
                        <h6 class="text-primary"><i class="fas fa-circle"></i> Intro :</h6><br>
                        <p>
                            <?= nl2br(replace_links(e($forum->description))) ?>
                        </p>
                       </div>
                   </div>
                    <div class="card">
                       <div class="card-body" style="font-style: italic;">
                        <h6 class="text-primary"><i class="fas fa-circle"></i> Contact :</h6>

                         <p>
                         email: <br>
                         website:
                        </p>

                       </div>
                      <?php if(get_session('user_id') == $forum->creator_id): ?>
                       <div class="card-footer text-center" style="font-style: italic;">
                      <?php if(forum_notifications_count(get_session('fr_i')) == 0): ?>
            <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#forumdashboard">
              <i class="fas fa-users-cog"></i> Dashboard </button>
                      <?php else: ?>
            <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#forumdashboard">
              <i class="fas fa-users-cog"></i> Dashboard </button>
                      <?php endif; ?>
                       </div>
                      <?php endif; ?>

                   </div>
                </div>

            </div>
            <?php include('query/forum_queries.php'); ?>
            <div class="col-lg-7 offset-lg-3">
                <div class="row">
                    <div class="col-lg-8">
                            <div class="coverPic">
                            <div class="card  text-white" style="width: 685px; font-style: italic;">
                                  <img src="<?= e($src =($cover->coverpic != null) ? $cover->coverpic : 'images/forum1.jpg') ?>" class="card-img" alt="..." with="685" height="360">
                                 <div class="card-img-overlay text-center">
                                  <h3 class="card-title"><?= e($forum->forum_name) ?></h3>
                                     <a href="" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#monModal3">ask a question?</a><br><br><br><br>
                                    <br><br>
                                     <?php foreach ($forumsubjects as $subject): ?>
                                    <h5 class="card-text"><?= e($subject->subject) ?></h5>
                                  <?php endforeach; ?>
                                  </div>
                                </div>
                            </div>

                            <div class="postCard" style="font-style: italic;">

                               <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <h3><?= e($forum->forum_name) ?></h3>
                               <a href="">
                                 <h6 class="text-primary"><i class="fas fa-users"></i> <?= forum_members_count($forum->id) ?> member<?= forum_members_count($forum->id) ==1 ? '' : 's'?></h6></a>
                                        </div>
                                    </div>

                            <?php include('partials/subject_post.php');
                                  include('partials/forum_dashboard.php');
                                   ?>


                                    <div class="card-body py-2">
                                    <div class="d-flex">
                                    <div>
                                        <img src= "<?= e($src =($user2->profilepic != null) ? $user2->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="rounded-circle" width="75" >
                                    </div>
                                    <div class="col">
                                        <form action="forumposts.php" method="post" enctype="multipart/form-data">
                             <div class="form-group mb-0">
                                                <div class="row">
                                     <div class="col-md-11">
                                       <label class="sr-only" for="content">Add a post</label>
                                        <textarea class="form-control border-0" name="content" id="content" rows="2"
                                        placeholder="Ajouter une mise a jour" maxlength="2500" required="required" style="font-style: italic;"></textarea>
                                     </div>
                                      <div class="col-md-1">
                                      <img width="60" src="images/questionMark.png"
                                      data-toggle="modal" data-target="#monModal3">
                                      </div>
                                   </div>
                               </div>
                                <div class="form-group mb-0">
                                    <?php include('partials/modal_forum_post_view.php'); ?>
                                </div>
                               <div class="form-group mb-0 status-post-submit">
                                   <button type="submit" name="publish" class="btn btn-default" style="font-style: italic;"><i class="far fa-paper-plane"></i> Share</button>
                               </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                             <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                   <!--  <div class="col">
                                        <button type="button" class="btn btn-zungposts btn-block btn-sm" style="font-style: italic;"><i class="fas fa-birthday-cake"></i> Wish</button>
                                    </div> -->
                                    <div class="col">
                                        <button type="button" class="btn btn-zungposts btn-block btn-sm" data-toggle="modal" data-target="#monModal" style="font-style: italic;"><i class="fas fa-images"></i> Photos</button>
                                    </div>
                                    <div class="col">
                               <!--<button type="button" class="btn btn-zungposts btn-block btn-sm" style="font-style: italic;" data-toggle="modal" data-target="#quotes">
                                    <i class="fas fa-quote-left"></i> Quotes <i class="fas fa-quote-right"></i></button> -->
                                    </div>
                                </div>
                            </div>
                                </div>

                            </div>

                            <div class="onlineUsersCard">
                                <div class="card">
                                <div class="card-body">
                                	<h6 class="text-primary"> Online members :</h6>
                                	<div class="row" id="online_users" style="overflow-y:auto;">

                                	</div>
                                    </div>
                                    <div class="card-footer text-center" style="font-style: italic;">
                                    <input type="hidden" id="is_active_group_chat_window" value="no"/>
                                    <button type="button" name="group_chat" id="group_chat" class="btn btn-outline-warning btn-xs"><?= unread_forum_msg(get_session('fr_i'),get_session('user_id'))  ?> <i class="far fa-envelope"></i> Unread message(s)</button>
                                    </div>
                                </div>
                                <div id="group_chat_dialog" title="Chat room">
                                  <div id="group_chat_history" style="height: 380px; border:1px solid #ccc; overflow-y: scroll; margin-bottom: 24px; padding: 16px;">

                                  </div>
                                  <div class="form-group">
                                   <div class="chat_message_area">
                                     <div id="group_chat_message" contenteditable class="form-control">

                                     </div>
                                     <div class="image_upload">
                                      <form id="uploadImage" method="post" action="upload.php">
                                        <label for="uploadFile"><img src="images/ib_attach.png"/></label>
                                        <input type="file" name="uploadFile" id="uploadFile" accept=".jpeg,.jpg, .png, .gif" />
                                      </form>
                                     </div>
                                   </div>
                                  </div>
                                  <div class="form-group" align="right">
                                    <button type="button" name="send_group_chat" id="send_group_chat" class="btn btn-info send_chat" >Send <i class="fas fa-location-arrow"></i></button>
                                  </div>
                                </div>
                            </div>
                                  <!-- Affichage des questions -->
                         <?php if(count($forumsubjects) !=0): ?>
                            <div class="questionsDoneCard">

                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                              <h6 style="color: #44717C; font-style: italic;">Sujets dans le forum </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                            <?php foreach ($forumsubjects as $subject): ?>
                                       <div class="row" data-toggle="modal" data-target="#reactionModal<?= e($subject->id) ?>">
                                          <!-- Affichage des questions resolues -->
                                          <div class="col-md-1">
                                     <h3 class="text-primary"><i class="fas fa-brain"></i></h3>
                                     </div>
                                     <div class="col-md-9" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; font-style: italic; " >
                                       <h5 style="color: #44717C;"><?= nl2br(replace_links(e($subject->subject))) ?></h5>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $subject->created_at ?>"><?= e($subject->created_at) ?></span>
                                     </div>
                                     <div class="col-md-2 text-center">
                                     <a ><h4 style="font-style: italic;"><?= e($subject->reaction) ?></h4>
                                     <h6 style="font-style: italic;">Reactions</h6></a>
                                     </div>
                                      <!-- Fin d'affichage des questions resolues -->
                                    </div>
                                    <?php endforeach; ?>
                                    <div class="text-center">
                                    <a href="" class="btn btn-outline-primary" data-toggle="modal" data-target="#moreSubject"> Voir plus</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                      <?php endif; ?>
          <!-- Fin du chargement du marketplace -->


                             <?php include('partials/question_modal.php');
                                  include('partials/subject_modal.php');
                                   ?>
                             <?php if(count($AllforumPost) !=0): ?>
                              <?php foreach ($AllforumPost as $post): ?>
                              <?php $user_profile=place_followerspic_displayer($post->poster_id);
                                     include('partials/comment_modal.php');   ?>
                            <div class="pubCard" style="font-style: italic;">
                              <!-- Affichage des posts -->

                                  <div class="card my-3">
                                      <div class="card-header border-0 py-2">
                                          <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                  <img src= "<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>" alt="image" class="rounded-circle" width="75" style="height: 45px; width: 45px; border:1.5px solid #f5f6fa;">
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                              <?php $username=get_user_name($post->poster_id);    ?>
                                                <?php if($post->type=="subject"): ?>
                                                  <a href="#">
                                                  <?=  $username->name ?></a>
                                                <span style="color: black;">added a new topic</span>
                                                <?php else: ?>
                                                  <a href="#"> <?=  $username->name ?></a>
                                                <span style="color: black;">added a status</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all;">
                                            <span class="timeago" title="<?= $post->created_at ?>"><?= $post->created_at ?></span>
                                            <i class="fa fa-globe" aria-hidden="true"></i></div>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="delete_micropost.php?id=<?= $micropost->id ?>"><i class="fa fa-trash"></i> Supprimer</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php if($post->type =="subject"): ?>
                            <?php  include('partials/reaction_modal.php'); ?>
                            <div class="text-center" data-toggle="modal" data-target="#reactionModal<?= e($post->id) ?>">
                            <h3 class="text-primary"> <i class="fas fa-brain"></i> <?= nl2br(replace_links(e($post->subject))) ?></h3>
                            </div>
                            <div class="text-right" data-toggle="modal" data-target="#reactionModal<?= e($post->id) ?>">
                              <?php if($post->reaction>0): ?>
                              <span class="badge" style="background-color: #0F9FEA; color: white;" ><?= e($post->reaction) ?> </span>
                              reaction<?= e($post->reaction==1) ? '' : 's' ?>
                              <?php else: ?>
                              No reaction
                              <?php endif; ?>
                            </div>

                            <a href="" class="btn btn-outline-primary" data-toggle="modal" data-target="#reactionModal<?= e($post->id) ?>">Reply <i class="far fa-comments"></i></a>
                            <?php else: ?>
                              <div class="card-body pt-0 pb-2">
                                <?= nl2br(replace_links(e($post->subject))) ?>
                            </div>
                             <?php if( $post->urlmedia1 !=null): ?>
                            <img class="card-img-top rounded-0 img-thumbnail" src="<?= $post->urlmedia1 ?>" alt="Card image cap">
                            <?php endif; ?>

                                <div class="card-footer border-0 p-0">
                                <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                    <div id="details<?= $post->id ?>" data-toggle="modal" data-target="#commentModal<?= $post->id ?>">
                                    <?= refresh_forumpost_details($post->id) ?>
                                    </div>
                                   <div id="likers_<?= $post->id ?>">
                                        <?= display_forum_likers($post->id)?>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center my-1">
                                    <div class="col">
                                      <?php if(user_has_already_liked_the_forumpost($post->id)): ?>
                                        <a id="unlike<?= $post->id ?>" data-action="unlike" href="unlike_forumpost.php?id=<?= $post->id ?>" class="like"><button type="button" class="btn btn-zung btn-block btn-sm"><i class="far fa-heart" aria-hidden="true"></i> unlike</button></a>
                                      <?php else: ?>
                                        <a id="like<?= $post->id ?>" data-action="like" href="like_forumpost.php?id=<?= $post->id ?>" class="like"><button type="button" class="btn btn-zung btn-block btn-sm"><i class="far fa-heart" aria-hidden="true"></i> like</button></a>
                                      <?php endif; ?>
                                    </div>
                                    <div class="col" id="row<?= $post->id ?>">
                                       <button type="button" class="btn btn-zung btn-block btn-sm" data-toggle="modal" data-target="#commentModal<?= $post->id ?>"><i class="far fa-comments" aria-hidden="true"></i> Comment</button>
                                    </div>
                                    <div class="col">
                                        <!-- <a type="button" class="btn btn-zung btn-block btn-sm" href="shareplacepost.php"><i class="fa fa-share"
                                                aria-hidden="true"></i>Partager</a> -->
                                    </div>
                                </div>

                            </div>
                            <?php endif; ?>

                        </div>



                            </div>
                          <?php endforeach; ?>
                      <?php endif; ?>







                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-fixed f-right" style="font-style: italic;">
                <div class="side-right">
                    <div class="h7 text-center">Friends</div>
                   <div id="user_details">

                   </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </body>
    <!-- SCRIPT -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.timeago.js"></script>
<script src="assets/js/jquery.timeago.en.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="assets/js/jquery.form.min.js"></script>
<script type="text/javascript" src="js/homeforum.js"></script>


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
