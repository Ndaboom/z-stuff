<?php $title="Find people";?>

	<?php 
	require "includes/functions.php";
	include('partials/_header.php');?>
	
     <link rel="stylesheet" href="assets/css/channel/style.css">

<body style="margin-top: 60px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                  <br>
                    <div class="d-flex">
                       <div class="card">
                             <div class="card-body">
                                 <div class="h6">Share ideas with others by joining forums</div>
                              <?php if(count($forums) != 0): ?>
                       <?php foreach ($forums as $forum): ?>
                <?php if(!is_already_in($forum->id)): ?>
                <?php $subjects=forum_three_subject_getters($forum->id);
                      ?>
                  <div id="forum<?= $forum->id ?>" style="border-bottom: solid 1px #DDDDDD;">
                     <img src="<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>" width="250"> 
                     <?= e($forum->forum_name)?> 
                     <?php if(!if_already_sent($forum->id)): ?>
             <button type="button" name="join_button" class="btn btn-outline-primary join_button" data-forum_id="<?= $forum->id ?>" style="font-style: italic; width: 235px;"> <i class="fas fa-sign-in-alt"></i> join <i class="fas fa-users"> <?= forum_members_count($forum->id) ?> </i></button>
            <?php else: ?>
            <a href="" class="btn btn-outline-success" style="
            font-style: italic;" data-toggle="modal" data-target="#reactionModal<?= e($forum->id) ?>">Request sent <i class="fas fa-users"> <?= forum_members_count($forum->id) ?> </i></a>
            <?php endif; ?>
                  </div>
          <?php endif; ?>
        <?php endforeach ?>
                  <?php endif; ?>
                  <a class="btn btn-link" href="list_forums.php">see more</a>
                 </div>
                 <div class="card-footer">
                  <div style="">Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                  All rights reserved |Zungvi<a href=""><h6>Conditions</h6>
                      </a><i class="fa fa-heart-o" aria-hidden="true"></i></div> 
                 </div>  
              </div>
                    </div>
                    
                     <div>
                    </div>

                </div>
            </div>
            <div class="col-lg-7 offset-lg-3">
                <div class="row">
                    <div class="col-lg-8">
                    <!--- Affichage de la liste des utilisateurs--->
                    <h3 style="font-family:georgia,garamond,serif; padding:5px;"><i class="fas fa-users"></i> Friends around you</h3>  
        <div id="friends_list">
       
        </div>
        <div id="users_list_message">
            
        </div>
                        <div class="d-flex justify-content-center" style="display: none;">
                            <i class="fas fa-spinner fa-spin" style="display: none; color: blue; margin-top: 10px;" id="spinner1"></i>
                        </div>
       
  </div>
                    <div class="col-lg-4">
                        <div class="card my-3">
                            <div class="card-body p-2">
                              <div class="h6">Some interesting places :</div>
                              <?php foreach($places as $row): ?>
                                <?php if(!a_place_has_already_been_followed($row->id,get_session('user_id'))): ?>
                                 <div class="card bg-dark text-white">
                                  <img src="<?= e($src =($row->coverpic != null) ? $row->coverpic : 'images/place_cover.jpg') ?>" class="card-img" alt="..." with="95">
                                 <div class="card-img-overlay text-center">
                                  <h5 class="card-title" style="font-family:Arial Black;font-size:20px;font-style:bold;"><?= $row->place_name ?></h5>
                                     <a href="homeplace.php?pl_i=<?= $row->id ?>" class="btn btn-outline-primary btn-xs">Visit</a>
                                  </div>
                                </div> <br>
                              <?php endif; ?>
                              <?php endforeach; ?>
                                <a class="btn btn-link" href="list_places.php">see more</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-fixed f-right">
                <div class="side-right">
                    <div class="h7 text-center"> Friends</div>
                    <div id="user_details">
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--SCRIPT -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.timeago.js"></script> 
<script src="assets/js/jquery.timeago.fr.js"></script>  


<script type="text/javascript">
    $(document).ready(function() {
        $(".timeago").timeago();
         fetch_online_user();
         fetch_incomming_msg()

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
        
        var limit = 27;
        var start = 0;
        var limit2=10;
        var action= 'inactive';
        function load_data(limit,start){
          $.ajax({
            url:"ajax/fetch_friends.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            beforeSend: function(){
                    $("#spinner1").show();
                },
            success:function(data)
            { 
              $('#friends_list').append(data);
              $("#spinner1").hide();
              if(data == '')
              {
               $('#users_list_message').html("");
               action = 'active';
              }
              else 
              {
               $('#users_list_message').html("<button class='btn btn-zung btn-block btn-sm more_post'>tap tap to load...</button>");
               action = 'inactive';
              }
            }
          })
        }
        if(action == 'inactive')
        {
          action = 'active';
          load_data(limit,start);

        }
        
         $(document).on('click','.more_post', function(){
            action = 'active';
            start = start + limit;
            limit2 = start+7;
            setTimeout(function(){
              load_data(limit,start);
            },1000); 
        });
        $(window).scroll(function(){
           if($(window).scrollTop() + $(window).height() > $("#friends_list").height() && action == 'inactive')
           {
            action = 'active';
            start = start + limit;
            limit2 = start+7;
            setTimeout(function(){
              load_data(limit,start);
            },1000);
           }
        });
        

        $(document).on('click', '.action_button', function(){
           var destinator_id = $(this).data('destinator_id');
           var action = $(this).data('action');
           $.ajax({
            url:'/action.php',
            method:"POST",
            data:{destinator_id:destinator_id, action:action},
                beforeSend: function(){
                   $("#sent"+destinator_id).hide();
                },
            success:function(data)
            {
             $("#success"+destinator_id).show();
            }
           })
        });

        $(document).on('click', '.join_button', function(){
           var forum_id = $(this).data('forum_id');
           $.ajax({
            url:'ajax/join_forum.php',
            method:"POST",
            data:{forum_id:forum_id},
            success:function(data)
            {
             $("#forum"+forum_id).hide();
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

</body>
