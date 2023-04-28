<?php $title="forums";?>

    <?php 
    require ('includes/functions.php');
    include('partials/_header.php');
    require('config/database.php');
    ?>

   
    <link rel="stylesheet" href="assets/css/Allplaces/style.css">
    

<body style="margin-top: 90px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                     <div>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                 <?php $thisForum=getUserForumsData(); ?>
                                 <?php if(count($thisForum)!= 0): ?>
                                <h6>Forums you are in</h6>
                                <div class="card">
                                    
                                       <div class="card-body">
                                        <?php foreach($thisForum as $tforum): ?>
                                        <div class="row">
                                         <div class="col-md-9">
                                            <img src= "<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="rounded-circle"style="width:30px; height:30px;" >
                                            <a href="homeforum.php?name=<?= $tforum->forum_name ?>" style="font-size: 10px; color: #44717C;">
                                           <?= $tforum->forum_name ?>  </a> 
                                         </div>
                                         <div class="col-md-2">
                                       <span class="badge" style="background-color: #F3BB00;"><?= unviewed_post($tforum->id,get_session('user_id'))?></span> 
                                         </div>
                                            
                                        </div>
                                         <?php endforeach; ?>
                                    </div>    
                                </div>
                            <?php endif; ?>

                            
                            </li>
                        </ul>
                        
                    </div>

                </div>
               
            </div>
            <div class="col-lg-7 offset-lg-3" style="margin-top: 0px;">
                <div class="row">
                    <div class="col-lg-8">
                      <div class="placeCard">
                                  <!-- Panneau d'affichage des forums -->
                       <div class="card">
          <div class="card-header">
            <h3>Find some interesting forums</h3>
          </div>
          <div class="card-body">
            <?php foreach ($forums as $forum): ?>
                <?php if(!is_already_in($forum->id)): ?>
                <?php include('partials/joinForumModal.php');
                      $subjects=forum_three_subject_getters($forum->id);
                      ?>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                        <div class="user-block">
              <img src= "<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="" width="290" >
              <a href="homeforum.php?name=<?= $forum->forum_name  ?>"><h3 class="user-block-username" style="font-style: italic;"><?= e($forum->forum_name)?></h3></a>
            <h6 style="font-style: italic;" class="text-primary"><i class="fas fa-users"> <?= forum_members_count($forum->id) ?></i>   <i class="fas fa-tasks">  <?= forum_subject_count($forum->id); ?></i></h6>
            <?php if(!if_already_sent($forum->id)): ?>
            <a href="" class="btn btn-outline-primary" style="width: 275px;
            font-style: italic;" data-toggle="modal" data-target="#reactionModal<?= e($forum->id) ?>">Join <i class="fas fa-users"> <?= forum_members_count($forum->id) ?> </i></a>
            <?php else: ?>
            <a href="" class="btn btn-outline-success" style="width: 275px;
            font-style: italic;" data-toggle="modal" data-target="#reactionModal<?= e($forum->id) ?>">Sent <i class="fas fa-users"> <?= forum_members_count($forum->id) ?></i></a>
            <?php endif; ?>
            </div>
                    </div>
                    <div class="col-md-6" style="border-left: solid 1px #DDDDDD;">
                        <?php if($forum->subjectsVisibility=="public" && count($subjects) !=0): ?>
                         <?php foreach ($subjects as $subject): ?>
                     <div class="row">
                     <!-- Affichage d'une question du forum -->
                    <div class="col-sm-2">
                        <h3 style="color: #44717C;"><i class="fas fa-brain"></i></h3> 
                    </div>
                    <div class="col-sm-7" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; ">
                        <h6 style="color: #44717C;"><?= $subject->subject ?></h6>
                        <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $subject->created_at ?>"><?= $subject->created_at ?></span>
                    </div>
                    <div class="col-sm-3 text-center">
                    <a><h4 style="font-style: italic;"><?= $subject->reaction ?></h4>
                        <h6 style="font-style: italic;"><?= $subject->reaction>1 ? 'reactions' : 'reaction'  ?></h6></a> 
                     </div>
                     <!-- Fin d'affichage question forum -->
                     
                     </div>
                 <?php endforeach; ?>
                 <?php elseif($forum->subjectsVisibility != "public" && count($subjects) !=0): ?>
                    <p>Only members of this forum can see the topics discussed in it.</p>
                 <?php else: ?>
                    <p>No subject has been discussed in this forum ...</p>
             <?php endif; ?>
                    </div>
                  </div>
                
                </div>  
              </div>
          <?php endif; ?>
        <?php endforeach ?>
          <div class="card">
                <div class="card-body text-center">
                    <a href=""><i class="fas fa-users"></i> Create a forum</a>
                </div>
                <div class="card-footer">
                            <form method="post" class ="well" autocomplete="off">
                                    <div class="">
                                        <input type="text" class="form-control" placeholder="Name of the forum" id="forum_name" name="forum_name"
      required="require"/>
                                    </div><br>
                                   <div class="form-group">
                                   <textarea name="description" id="description" cols="75" rows="03" class="form-control"
                                    placeholder="About the forum"></textarea>
                                   </div>
                                    <br>
                                    <div class="pull-right">
                                        <a><input type="submit" class="btn btn-primary" value="Create" name="insert"/></a>
                                    </div>
                                </form>
                            </div>
            </div>
          </div>
          
        </div>
                      </div>
                    </div>
                </div>
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
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.timeago.js"></script> 
<script src="assets/js/jquery.timeago.fr.js"></script>  


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
