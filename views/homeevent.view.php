<?php 
if($notifications_count > 0)
{
  $notifications_nbr = "(".$notifications_count.")";
}else{
  $notifications_nbr = "";
}
$title= $notifications_nbr." ".$event->event_name." ";?>

<?php 
require('includes/functions.php');
require('includes/event_functions.php');
include('partials/_header.php');
require('config/database.php');

$_SESSION['ev_n'] = $event->event_name;
$_SESSION['ev_i'] = $event->id;
$_SESSION['cr_i'] = $event->creator_id;
?>


<link rel="stylesheet" href="assets/css/forum/style.css">

<body style="margin-top: 60px; overflow-x:hidden;">
<div class="container-fluid">
<div class="row">
  <div class="col-lg-3 offset-fixed f-left">
      <div class="side-left">
         <div class="card">
             <div class="card-body">
              <h6 style="color: #44717C;"><i class="fas fa-circle"></i> Intro :</h6><br>
              <p id="eventDescriptionBox">
                 <?= $event->event_description ?>      
              </p>
             </div>
         </div>
          <div class="card">
             <div class="card-body">
              <h6 style="color: #44717C;"><i class="fas fa-circle"></i> Contact :</h6>
              
               <p>
               email: <br>
               website:
              </p>
               
             </div>
  <?php if(get_session('user_id') == get_session('cr_i')): ?>
             <div class="card-footer text-center">
  <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#eventdashboard">
    <i class="fas fa-users-cog"></i> Tableau de bord </button>     
             </div>
  <?php endif; ?>
         </div>
      </div>
     
  </div>
  <div class="col-lg-7 offset-lg-3">
      <div class="row">
          <div class="col-lg-8"> 
                  <div class="coverPic">
                  <div class="card bg-dark text-white" style="width: 670px;">
                        <img src="<?= $event->coverpic ?>" class="card-img" alt="...">
                       <!--<div class="card-img-overlay text-center">
                        <h3 class="card-title"><?= $event->event_name ?></h3>
                           <a href="" class="btn btn-outline-primary btn-xs" data-toggle="modal" data-target="#msgModal">Message?</a>
                        </div> -->
                  </div>
                  </div>
                  <!-- Affichage du modal pour l'envoie du msg -->
        <div class="modal fade" id="msgModal">
            <div class="modal-dialog modal-sm" > 
                <div class="modal-content"> 
                <div class="modal-body" style="background-color: #e9ebee;">

                  <div class="row">
                    <div class="col-md-3">
                    <img src="images/default.png" class="rounded-circle" style="height: 60px; width: 60px; border:1.5px solid #f5f6fa;">
                    </div> 
                    <div class="col-md-9">     
                    <input type="text" name="userMsg" class="form-control" placeholder="Votre message" id="userMsg">
                    <div class="text-right" style="padding-top: 2px;"> 
                    <a class="btn btn-outline-primary" id="sendButton" style="display: none;">Send</a>
                    </div>
                    </div>      
                  </div>
               
                </div>
                </div>
            </div>
        </div>

                  <!-- Fin de l'affichage du modal -->
                  <div class="postCard">
                    
                     <div class="card">
                      <div class="card-header">
                          <div class="row">
                            <div class="col">
                            <b><?php if(an_event_has_already_been_followed(get_session('ev_i'),get_session('user_id'))): ?>
                            Vous et
                            <?php endif; ?>
                            <i class="fas fa-users"></i><?= event_followers_count($event->id) ?> abonné<?= event_followers_count($event->id) >1 ? 's' : ''?></b>
                            </div>
                            <div class="col text-right">
                                <?php if(an_event_has_already_been_followed(get_session('ev_i'),get_session('user_id'))): ?>
                                 <a href="unfollow_event.php" class="btn btn-outline-primary active btn-xs"><i class="far fa-bell"></i> Suivi</a>
                                 <?php else: ?>
                                 <a href="follow_event.php" class="btn btn-outline-primary btn-xs"><i class="far fa-bell"></i> Suivre</a>
                                 <?php endif; ?>
                            </div>
                           <!-- <small class="text-center">Appuyez sur le button voter pour donner une chance à votre candidat de se qualifier à la session suivante</small>
                            -->
                         </div>

                <?php if(get_session('user_id') == $event->creator_id): ?>
                <?php include('partials/events_dashboard.php'); ?>
                  <div class="card-body py-2">
                                <div class="d-flex">
                                    <div>
                                        <img src= "<?= e($src =($user2->profilepic != null) ? $user2->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="rounded-circle" style="height: 60px; width: 60px; border:1.5px solid #f5f6fa;" >
                                    </div>
                                    <div class="col">
                                        <form action="eventposts.php" method="post" enctype="multipart/form-data">
                                            <div class="form-group mb-0">
                                                <label class="sr-only" for="content">Add a post</label>
                                                <textarea class="form-control border-0" name="content" id="eventTextPostBox" placeholder="Hey, what's new about <?= $event->event_name ?> today?" maxlength="100000" require="require" ></textarea>
                                            </div>
                                            <div class="form-group mb-0">
                                                <?php include('partials/add_pic_or_video_modal.php');
                                                       ?>
                                            </div>
                                            <img class="img-thumbnail img-responsive" id="preview2" style="width:70px; display:none;" />
                                            <div class="form-group mb-0 status-post-submit">
                                                <button type="submit" name="publish" id="publish" class="btn btn-default btn-xs" style="float: right; border-radius: 14px 14px 14px 14px; display:none;"><i class="far fa-paper-plane"></i> Partager</button>
                                            </div>
                                        </form> <script src="script.js"></script>
                                        <?php include('partials/post_quotes.php');
                                              include('partials/post_sounds.php');
                                              include('partials/post_videos.php');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col">
                                        <button type="button" class="btn btn-zungposts btn-block btn-sm" data-toggle="modal" data-target="#monModal"><i class="fas fa-images"></i></button>
                                    </div>
                                </div>
                            </div>
                <?php endif; ?>   
                </div>
                      
            </div>
            <!--  Vote box -->
                    <div class="d-flex justify-content-center" style="display: none;">
                        <div class="spinner-grow text-primary spinner" role="status" style="display:none;">
                        <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-danger spinner" style="display:none;" role="status">
                        <span class="sr-only">Loading...</span>
                        </div>
                        <div class="spinner-grow text-info spinner" role="status" style="display:none;">
                        <span class="sr-only">Loading...</span>
                        </div>
                      </div>
                        <?php if(count($candidates) != 0):  ?>
                        <div class="card" style="box-shadow: 1rem 1rem 1rem -1rem #a0a0a033;max-height:100px;padding-top:-17px;">
                              <div class="card-body">
                                  <div class="text-center" >
                                      <b>Phase 4 - Finale</b><br> <small><span class="text-primary">*</span>Le vote est à choix unique par phase</small>
                                      
                                        <!-- Load Facebook SDK for JavaScript -->
                                         <div id="fb-root"></div> 
                                   <script>(function(d, s, id) {
                                        var js, fjs = d.getElementsByTagName(s)[0];
                                        if (d.getElementById(id)) return;
                                        js = d.createElement(s); js.id = id;
                                        js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
                                        fjs.parentNode.insertBefore(js, fjs);
                                        }(document, 'script', 'facebook-jssdk'));
                                    </script>

                                        <!-- Your share button code -->
                                    <div class="fb-share-button" 
                                    data-href="https://www.zungvi.com/mobile/homeevent.php?ev_i=<?= $event->id ?>" 
                                    data-layout="button_count">
                                    </div>

                                   </script>
                                   <!-- Facebook sdk and sharing button end --> 
                                  </div>
                           <!--Don card place -->
                            
                            </div>
                        </div>
                         <div class="card" style="box-shadow: 1rem 1rem 1rem -1rem #a0a0a033; max-height: 670px; overflow-x: auto;">
                            <div class="card-body">
                                <div class="d-inline-flex bd-highlight" style="overflow-x:auto;" id="display_candidates">
                               
                                </div>
                            </div>
                         </div>
                        <?php else: ?>
                         <div class="card">
                    	   <div class="card-body text-center">
                    	    <b>Aucune phase n'est en cours...</b>
                    	   </div>
                    	 </div>
                        <?php endif; ?>
                <!-- Vote box -->
                
                <!--  Publications -->
                 <div id="posts_list">

                 </div>
                <!-- Publications  -->

        </div>
  <div class="col-lg-2 offset-fixed f-right">
      <div class="side-right">
          <div class="h7 text-center">Friends</div>
         <div id="user_details">
           
         </div>
      </div>
  </div>
</div>
</div>
 <!--SCRIPT -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.timeago.js"></script>
    <script src="js/homeevent.js"></script>


<script type="text/javascript">
$(document).ready(function() {

        fetch_online_user();
        fetch_incomming_msg();
        fetch_candidates();
        
        setInterval(function(){
             update_last_activity();
             fetch_online_user();
             fetch_incomming_msg();
             fetch_candidates();
        },6000);
        
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
              }
        
          });
        });
        
        
        $("#sendButton").on("click", function(e){
          e.preventDefault();
          alert("Message sent");
        });
        
        //userMsg
        
        $('input#userMsg').on('keyup', function(){
          $("#sendButton").show();
          });
          
          $(document).on('click', '.vote', function(){
                //var id= $(this).attr("id");
                var url='ajax/vote_action.php';
                var action = $(this).data('action');
                var session_id = $(this).data('session_id');
                var event_id = $(this).data('event_id');
                var candidate_id = $(this).data('candidate_id');
        
                    $.ajax({
                        type:'POST',
                        url:url,
                        data: {
                               session_id: session_id,
                               event_id: event_id,
                               candidate_id: candidate_id,
                               action:action
                              },
                        beforeSend: function(){
                            $("#current"+candidate_id).hide();
                            $("#button"+candidate_id).show();
                        },
                        success: function(){
                           fetch_candidates();
                        }
        
                    });
                });
        
                $(document).on('click', '.unvote', function(){
                //var id= $(this).attr("id");
                var url='ajax/vote_action.php';
                var action = $(this).data('action');
                var session_id = $(this).data('session_id');
                var event_id = $(this).data('event_id');
                var candidate_id = $(this).data('candidate_id');
        
                    $.ajax({
                        type:'POST',
                        url:url,
                        data: {
                               session_id: session_id,
                               event_id: event_id,
                               candidate_id: candidate_id,
                               action:action
                              },
                        beforeSend: function(){
                            $("#current"+candidate_id).show();
                            $("#button"+candidate_id).hide();
                        },
                        success: function(){
                           fetch_candidates();
                        }
        
                    });
                });
        
                 function fetch_candidates()
                {
                  $.ajax({
                    url:"ajax/fetch_candidates.php",
                    method:"POST",
                     beforeSend: function(){
                            $(".spinner").show();
                            $("#sharing_box").hide();
                        },
                    success:function(data){
                      $('#display_candidates').html(data);
                      $(".spinner").hide();
                      $("#sharing_box").show();
                    }
                  })
                }
        
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
        
        
        
        $('#uploadFile').on('change', function(){
        $('#uploadImage').ajaxSubmit({
        target: "#group_chat_message",
        resetForm: true
        });
        });

});

</script>
<!-- SCRIPT -->

</body>