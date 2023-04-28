
<?php $title="Reactions";?>

    <?php 
    require ('includes/functions.php');
    include('partials/_header.php');
    require('config/database.php');
    ?>

   
    <link rel="stylesheet" href="assets/css/reaction/style.css">
<body style="margin-top: 90px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                    <div class="d-flex">
                       <!-- <div>
                            <img class="rounded-circle" src="https://picsum.photos/80/80/?random?image=4" width="30" alt="">
                        </div> -->
                        <div class="ml-3 h7">
                          
                        </div>
                    </div>
                    
                     <div>
                      
                    </div>

                </div>
               
            </div>
            <div class="col-md-7 offset-md-3">
                <div class="row">
                    <div class="col">
                        <div class="card" style="width: 750px;">
                            <div class="card-header">
                          <i class="fas fa-brain"></i> <?= e($poster_data->subject)?> <?= e($poster_data->name) ?>
                            </div>
                            <div class="card-body text-center">
                           
                             <?php if(count($reactions) != 0): ?> 
                             <?php foreach ($reactions as $reaction): ?>
                         <?php $user_profile=place_followerspic_displayer($reaction->user_id);
                               $userfirstname=get_user_name($reaction->user_id);
                               $userlastname=get_user_second_name($reaction->user_id);
                         ?>
                     <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2" style="border-right: solid 1px #DDDDDD;">
                                  <img src="<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >  
                                </div>
                        <?php if($reaction->content_img): ?>
                                <div class="col-md-6 text-left" style="border-right: solid 1px #DDDDDD;">
                                    <a href=""><?= e($userfirstname->name) ?> <?= e($userlastname->nom2) ?></a>
                                   <p><?= $reaction->content_text ?></p>
                                   <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $reaction->created_at ?>"><?= $reaction->created_at ?></span>
                                </div>
                                <div class="col-md-3">
                                    <a href="imageViewer.php?picname=<?= $reaction->content_img ?>"> <img src="<?= $reaction->content_img ?>" width="150" height="80"></a><br>
                                    <a class="btn btn-default" href="<?= $reaction->content_img ?>" download>Download</a>
                                </div>
                        <?php else: ?>
                        <div class="col-md-10 text-left">
                                   <p><?= $reaction->content_text ?></p>
                                   <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $reaction->created_at ?>"><?= $reaction->created_at ?></span>
                        </div>
                        <?php endif; ?>
                            </div>
                          <?php if(!already_satisfied($reaction->id)):  ?>
                             <div class="row">
                                <div class="col-md-12 text-center">
                                   
                                       <button  class="btn btn-outline-primary btn-sm <?= already_validate($reaction->id) ? "active" : "" ?>" id="revalidate<?= $reaction->id?>" style="display: none;"> <i class="far fa-thumbs-up"></i> I valid</button>
                    
                                      <a href="" class="validate" id="validate<?= $reaction->id ?>" data-action="<?= $reaction->user_id ?>"><button href="validatereaction.php?re_id=<?= $reaction->id ?>" class="btn btn-outline-primary btn-sm <?= already_validate($reaction->id) ? "active" : "" ?>"> <i class="far fa-thumbs-up"></i> I valid</button> </a>
                                    
                                     
                                
                            <button  class="btn btn-outline-danger btn-sm <?= already_denied($reaction->id) ? "active" : "" ?>" id="redenied<?= $reaction->id?>" style="display: none;"> <i class="far fa-thumbs-down"></i> i deny</button>
                             
                            <a href="" class="denied" id="denied<?= $reaction->id ?>">
                                <button class="btn btn-outline-danger btn-sm <?= already_denied($reaction->id) ? "active" : "" ?>"><i class="far fa-thumbs-down"></i> i deny</button>    
                                </a>
 
                                <a href="" class="satisfied" id="satisfied<?= $reaction->id ?>">
                                 <button class="btn btn-outline-info btn-sm"><i class="far fa-smile"></i> satisfied</button>
                                </a>            
                            </div>
                        </div>
                            <?php endif; ?>
                          <div class="col-md-12 text-center" id="likers_<?= $reaction->id ?>">
                           
                             <?= display_validations($reaction->id)?>
                               
                            </div>
                        </div>
                         
                     </div>
                    <?php endforeach; ?>   
                    <?php else: ?>      
                     <p>Not reaction yet...</p>      
                    <?php endif; ?>
                    <div class="card">
                        <div class="card-body">
                            <form action="subjectreact.php?rid=<?= $_GET['rid'] ?>" method="post" enctype="multipart/form-data"> 
                    <div class="row">
                      <div class="col-lg-1">
                 <img src= "<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>" alt="image" class="rounded-circle" width="75" 
                                      style="height: 45px; width: 45px; border:1.5px solid #f5f6fa;"> 
                </div>
                <div class="col-lg-5" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; border-radius: 20px 20px 20px 20px;">
                     <textarea class="form-control border-0" name="content" id="content" rows="4" 
                     placeholder="Votre reaction...?" maxlength="250" required="required" style=" border-radius: 20px 20px 20px 20px; "></textarea><br>
                     <i class="far fa-image" style="padding-top: 1px;" ></i><input type="file" name="image"> 
                 </div>
                    <div class="col-lg-2 text-center">
                    <button type="submit" name="publish" class="btn btn-outline-primary" style="float: right;"> Post</button>
                    </div> 
                    <div class="col-lg-4">
                        
                    </div>   
                    </div>
                </form>    
                        </div>
                    </div>
                

                            </div>
                            <div class="card-footer text-center">
                                <div style="">Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                                All rights reserved |Zungvi<a href=""><h6>Conditions</h6>
                                    </a></div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-fixed f-right">
                <div class="side-right">
                    <div class="h7 text-center">Friends <i class="fas fa-users"></i> </div>
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
        fetch_incomming_msg();
        fetch_online_user()
        setInterval(function(){
           fetch_incomming_msg();
           fetch_online_user();
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

         $("a.validate").on("click", function(e){
            e.preventDefault();
            
            var url='ajax/validate_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("validate")[1];
            var action = $(this).data('action');
               if(reactionId != ""){
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
               }
        });


        $("a.denied").on("click", function(e){
            e.preventDefault();
            
            var url='ajax/denied_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("denied")[1];
             if(reactionId != ""){
                 
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
            
             }
            
               

        });
         

        $("a.satisfied").on("click", function(e){
            e.preventDefault();
            
            var url='ajax/satisfiedwith_reaction.php';
            var id= $(this).attr("id");
            var reactionId = id.split("satisfied")[1];
            if(reactionId != ""){
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
        }
            
               

        });



    });

    
    $(document).ready(function() {
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
        });
    
</script>
<!-- SCRIPT -->

</body>
    
    
    
