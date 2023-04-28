<?php 
$forum = selectCurrentForumData($_GET['name']);
$subjects=forum_three_subject_getters($forum->id);
$title = "$forum->forum_name forum"; ?>
<meta property="image" content="<?= $poster->profilepic  ?>">
<?php include('partials/_header.php'); ?>
<link rel="stylesheet" href="assets/css/channel/style.css">
<style>
 #post{
    width: 500px;
    height: 400px;
    margin-left:auto;
    margin-right: auto; 
 }

 .main-container{
 	margin-left:5%;
 	margin-right: 5%;

 }

 .forums_suggestion
 {
 	margin-top: 5px;
 }
 .post
 {
 	width: 50px;
 	height: 50px;
 }

 @media (max-width:780px){
           #post{
             height: 290px;
             margin-right: auto;
             margin-left: auto;
             width: 345px;  
           }

           .forums_suggestion
			 {
			 	margin-top: 5px;
			 }
        }   
</style>
<body style="margin-top: 80px;">
	<div class="container">
		<div class="main-container">
			<div class="card">
			<img src="<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/forum1.jpg') ?>" style="width:100%; height: 300px;" class="card-img">

			<div class="card-img-overlay text-center card_content">
              <h3 class="card-title"><?= e($forum->forum_name) ?></h3>
                <a data-toggle="modal" data-target="#reactionModal<?= e($forum->id) ?>" class="btn btn-outline-primary btn-xs">Join the forum <i class="fas fa-users"> <?= forum_members_count($forum->id) ?></i> <i class="fas fa-tasks">  <?= forum_subject_count($forum->id); ?></i></a>
                <p class="text-white"><?= $forum->description ?></p>
            </div>
		    </div>
		    <div class="card">
		    <div class="card-body">
		    	<?php if($forum->subjectsVisibility=="public" && count($subjects) !=0 || already_in_forum(get_session('user_id'))): ?>
                         <?php foreach ($subjects as $subject): ?>
                     <div class="row">
                     <!-- Affichage d'une question du forum -->
                    <div class="col-sm-2">
                        <h3 class="text-primary"><i class="fas fa-brain"></i></h3> 
                    </div>
                    <div class="col-sm-7" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; ">
                        <h6 class="text-primary"><?= $subject->subject ?></h6>
                        <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $subject->created_at ?>"><?= $subject->created_at ?></span>
                    </div>
                    <div class="col-sm-3 text-center">
                    <a href="morereaction.php?rid=<?= $subject->id ?>"><h4 style="font-style: italic;"><?= $subject->reaction ?></h4>
                        <h6 style="font-style: italic;"><?= $subject->reaction>1 ? 'reactions' : 'reaction'  ?></h6></a> 
                     </div>
                     <!-- Fin d'affichage question forum -->
                     
                     </div>
                 <?php endforeach; ?>
                 <?php elseif($forum->subjectsVisibility != "public" && count($subjects) !=0): ?>
                    <p>Only members of this forum can see topics discussed in...</p>
                 <?php else: ?>
                    <p>No subject has been discussed in this forum ...</p>
             <?php endif; ?>
		    	
		    </div>
		    
		    <!-- Modal for joinning forum  -->
		      <div class="modal fade" id="reactionModal<?= e($forum->id) ?>">
            
            <div class="modal-dialog modal-md" >
                
                <div class="modal-content">
                   <div class="modal-header" style="background-color: white;">
                    <div class="row">
                        <div class="col-md-10">
                        <?= e($forum->forum_name) ?>
                        </div>
                        <div class="col-md-2">
                           <?php if(!if_already_sent($forum->id)): ?>
                         <a href="joinForumRequest.php?fr_i=<?= $forum->id ?>" class="btn btn-outline-primary btn-xs" style="float: left;">Rejoindre <i class="fas fa-sign-in-alt"></i></a> 
                           <?php else: ?>
                         <a href="cancelForumRequest.php?fr_i=<?= $forum->id ?>" class="btn btn-outline-danger btn-xs" style="float: left;">Annuler <i class="fas fa-sign-out-alt"></i></a> 
                           <?php endif; ?>  
                        </div>
                    </div>
                    </div>
                    
                <div class="modal-body" style="background-color: #e9ebee;"> 
                <div class="card bg-dark text-white">
                  <img src="<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>" class="card-img" alt="..." with="95">
                </div> 
                </div>
                
                <div class="modal-footer text-center">
                <p>
                 <?= e($forum->description) ?>   
                </p>                
                </div>
                    
                </div>
            </div>
        </div>
		    <!-- Modal for joinning forum     -->
		    <div class="card-footer text-center">
            <div id="Copyright">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved |Zungvi</div>
            </div> 	
		    </div>
		</div>

			
	</div>	
</body>
<!-- SCRIPTS -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.timeago.js"></script>
<script src="assets/js/jquery.timeago.fr.js"></script>
 <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
         $(".timeago").timeago();
         fetch_online_user();
         fetch_incomming_msg();

        setInterval(function(){
           update_last_activity();
           fetch__online_user();
           fetch_incomming_msg();
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

        function update_last_activity()
        {
          $.ajax({
            url:"ajax/update_last_activity.php",
            success:function()
            {

            }
          })
        }

        $(document).on('click', '.like', function(){

        var id= $(this).attr("id");
        var url='ajax/micropost_like.php';
        var action = $(this).data('action');
        var poster = $(this).data('poster');
        var postid = $(this).data('postid');
        var micropostId = id.split("like")[1];
            $.ajax({
                type:'POST',
                url:url,
                data: {
                       micropost_id: micropostId,
                       action: action,
                       poster:poster,
                       postid:postid
                      },
                success: function(likers){
                   fetch_current_post_data();
                }

            });
        });

        var post_id;
        var user_id;
        $(document).on('click','.post_comment', function(){
              post_id = $(this).attr('id');
              user_id = $(this).data('user_id');
              var action = 'fetch_comment';
              $.ajax({
                url:"action.php",
                method:"POST",
                data:{post_id:post_id,user_id:user_id,action:action},
                success:function(data){
                  $('#old_comment'+post_id).html(data);
                  $('#comment_form'+post_id).slideToggle('slow');
                }
              })
             
              
        });

        $(document).on('click','.submit_comment',function(){
         var comment = $('#comment'+post_id).val();
         var action = 'submit_comment';
         var receiver_id = user_id;
         var poster = $(this).data('poster');

         if(comment != '')
         {
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{post_id:post_id,receiver_id:receiver_id,comment:comment,action:action,poster:poster},
           success:function(data)
           {
            $('#comment_form'+post_id).slideUp('slow');
            fetch_post();
            fetch_current_user_last_post();
           } 
          })
         }
        });

        $(document).on('click','.like_comment',function(){
          var poster_id = $(this).data('poster_id');
          var comment= $(this).data('comment');
          var post= $(this).data('post');
          var commentid= $(this).data('commentid');
          var action= 'like_comment';
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
            success:function(data)
            {
             fetch_post();
            }
          })

        });

        $(document).on('click','.unlike_comment',function(){
          var poster_id = $(this).data('poster_id');
          var comment= $(this).data('comment');
          var post= $(this).data('post');
          var commentid= $(this).data('commentid');
          var action= 'unlike_comment';
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
            success:function(data)
            {
             fetch_post();
            }
          })

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
    });
    
</script>
<!-- SCRIPT -->
