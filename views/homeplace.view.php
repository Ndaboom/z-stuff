<?php $title="$place->place_name";?>

    <?php 
    require ('includes/functions.php');
    include('partials/_header.php');
    require('config/database.php');
    ?>

   
    <link rel="stylesheet" href="assets/css/place/style.css">

<?php $_SESSION['pl_i']=$place->id;
      $_SESSION['cr_i']=$place->creator_id;
      $_SESSION['pl_n']=$place->place_name;
        ?>
<body style="margin-top: 60px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                   <div class="card">
                       <div class="card-body">
                        <h6 class="text-primary"><i class="fas fa-circle"></i> Intro :</h6><br>
                        <p>
                            <?= nl2br(replace_links(e($place->description))) ?>      
                        </p>
                       </div>
                   </div>
                    <div class="card">
                       <div class="card-body">
                        <h6 class="text-primary"><i class="fas fa-circle"></i> Contact :</h6>
                        
                         <p>
                         Tel : <?= e($place->place_contacts)  ?><br>
                         email: <a href="mailto:<?= e($place->email) ?>"><?= nl2br(replace_links(e($place->email))) ?></a><br>
                         website: <?= nl2br(replace_links(e($place->website))) ?>
                        </p>
                        <div class="text-center">
                            <button class="btn btn-outline-primary btn-sm">see more</button>  
                        </div>
                         
                       </div>
                       <?php if(get_session('user_id')== get_session('cr_i')): ?>
                       <div class="card-footer text-center">
                        <?php if(place_notifications_count() > 0): ?>
                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#monModal"><i class="fas fa-users-cog"></i> Dashbard <i class="fas fa-bell"></i> <?= place_notifications_count() ?></button>
                        <?php else: ?>
                            <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#monModal"><i class="fas fa-users-cog"></i> Dashboard </button> 
                        <?php endif; ?>     
                       </div>
                        <?php endif; ?>
                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#orderModal"><i class="fas fa-shopping-basket"></i> Your shopping cart <span class="badge" style="background-color: #0F9FEA; color:white;"><?= orders_count(get_session('user_id'),get_session('pl_i')) ?></span></button>
                   </div>
                </div>
               
            </div>
            <?php
            if(get_session('user_id') == get_session('cr_i')){
               include('partials/place_dashboard.php');  
            }
                  include('partials/order_modal.php');
                  include('partials/sharingModal.php');?> 
            <div class="col-lg-7 offset-lg-3">
                <div class="row">
                    <div class="col-lg-8"> 
                            <div class="coverPic">
                             <img src="<?= e($src =($place->coverpic != null) ? $place->coverpic : 'images/place_cover.jpg') ?>" data-toggle="modal" data-target="#monModalCover">
                            </div>

                            <div class="postCard">
                              
                               <div class="card" id="buttonsBox">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                        <h3><?= (e($place->place_name)) ?></h3>
                               <a href="">
                                 <h6 class="text-primary"><i class="fas fa-users"></i> <?= followers_count()?> person<?= followers_count() ==1 ? '' : 's'?> <?= followers_count() == 1 ? 'follows' : 'are following' ?> this place
                                </h6></a>
                                        </div>
                                        <div class="col-md-6 text-right">
                                 <?php if(a_place_has_already_been_followed(get_session('pl_i'),get_session('user_id'))): ?>
                                 <a href="unfollow_place.php" class="btn btn-outline-primary active"><i class="fas fa-thumbs-up"></i> following</a>
                                 <?php else: ?>
                                 <a href="follow_place.php" class="btn btn-outline-primary">follow</a>
                                 <?php endif; ?>   
                                 <a class="btn btn-outline-primary" data-toggle="modal" data-target="#sharingModal"><i class="fas fa-share-alt"></i> Share</a> 
                                 </div>
                                        
                                    </div>
                            <?php 
                                   include('partials/_flash.php');
                                   include('partials/place_cover_uploader.php');
                                  include('partials/coverPlaceVisualizerModal.php');      
                                   ?>   
                                 <!--- Pour verifier si c'est l'admin de la place qui est connecte --->
                            <?php if(get_session('user_id')== get_session('cr_i')): ?>
                                    <div class="card-body py-2">
                                    <div class="d-flex">
                                    <div>
                                        <img src= "<?= e($src =($user2->profilepic != null) ? $user2->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="rounded-circle" width="75" >
                                    </div>
                                    <div class="col">
                                        <form action="placeposts.php" method="post">
                             <div class="form-group mb-0">
                                                <div class="row">
                                     <div class="col-md-11">
                                       <label class="sr-only" for="content">Add a post</label>
                                        <textarea class="form-control border-0" name="content" id="content" rows="2" 
                                        placeholder="Hey <?= $user->name ?>,what'up?" maxlength="300" required="required"></textarea> 
                                     </div>
                                      <div class="col-md-1">
                                      <i class="fas fa-upload" data-toggle="modal" data-target="#monModal3"></i>   
                                      </div>
                                   </div>
                               </div>
                               <div class="form-group mb-0 status-post-submit">
                                   <button type="submit" name="publish" class="btn btn-default" style="float: right;"><i class="far fa-paper-plane"></i> Share</button>
                               </div>
                                        </form>
                            <?php include('partials/modal_place_post_view.php');  ?>
                                    </div>
                                </div>
                            </div> 
                             <?php endif; ?>       
                                </div>
                                
                            </div> 

                            <div class="galleryCard">
                                <div class="card">
                                    <div class="card-body">

                                    <a href="imageViewer.php?picname=<?= $place->image ?>"><img src="<?= e($src =($place->image != null) ? $place->image : 'images/place_cover.jpg') ?>" width="250" style="margin-top: 0px; width: 250px; height: 150px;" class="img-thumbnail"></a>
                                <a href="imageViewer.php?picname=<?= $place->image1 ?>"><img src="<?= e($src =($place->image1 != null) ? $place->image1 : 'images/place_cover.jpg') ?>" width="250" style="margin-top: 0px; width: 250px; height: 150px;" class="img-thumbnail"></a> 
                                   <a href="placegallery.php?pl_i=<?= $place->id ?>"><button class="btn btn-outline-primary" width="250" >+</button></a>
                                    <!-- Avis des followers -->

                                       <div class="cotationDiv">
                                           <h6 class="text-primary"> How do you find this place?</h6><small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                                       </div>
                                       <!-- End avis -->
                                    </div>
                                </div>
                                
                            </div>
                         
                        <?php if(a_marketplace_has_already_been_created()):  ?>
                            <div class="marketCard">
                                <!-- Market palce Items-->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                              <h6 class="text-primary"> Marketplace </h6>  
                                            </div>
                                            <div class="col-md-6 text-right">
                                          <a class="btn btn-outline-primary" data-toggle="modal" data-target="#orderModal"><i class="fas fa-shopping-basket"></i> Your shopping cart <span class="badge" style="background-color: #0F9FEA; color:white;"><?= orders_count(get_session('user_id'),get_session('pl_i')) ?></span></a>  
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="card-body">
                                       <div class="row">
                                          <!-- Affichage des produits -->
                        <?php if(count($homeproducts) !=0): ?>
                            <?php foreach ($homeproducts as $homeproduct): ?>
          <div class="col-md-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="about_product.php?pr_i=<?= $homeproduct->id ?>"><img class="card-img-top" src="<?= e($src =($homeproduct->object_view1 != null) ? $homeproduct->object_view1 : 'http://placehold.it/700x400') ?>" alt="" width="600" height="250"></a>
              <div class="card-body text-center">
                <h4 class="card-title">
                  <a href="about_product.php?pr_i=<?= $homeproduct->id ?>"><?= $homeproduct->object_name ?></a>
                </h4>
               
              </div>
              <div class="card-footer text-center">
                <?php if($product->object_interaction =="Aucune"): ?>
                <a href="about_product.php?pr_i=<?= $homeproduct->id ?>" class="btn btn-outline-primary">Voir</a>
                <?php elseif(get_session('user_id')== get_session('cr_i')): ?>
                <a href="about_product.php?pr_i=<?= $homeproduct->id ?>" class="btn btn-outline-primary disabled" ><?= $homeproduct->object_interaction?> <?= $homeproduct->object_price ?></a>
                <?php else: ?>
                <a href="about_product.php?pr_i=<?= $homeproduct->id ?>" class="btn btn-outline-primary order" data-pr_i="<?= $homeproduct->id  ?>" data-action="<?= $homeproduct->object_interaction ?>" data-designation="<?= $homeproduct->object_name ?>" data-object_price="<?= $homeproduct->object_price ?>" 
                  data-image="<?=$homeproduct->object_view1?>"><?= $homeproduct->object_interaction?> <?= $homeproduct->object_price ?></a>
                <small class="text-success" id="orderer<?= $homeproduct->id ?>" style="display:none;">added <i class="fas fa-shopping-basket"></i></small>
                <?php endif; ?>
              </div>
            </div>
          </div>
           <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No items available for the moment</p>
                      <?php endif; ?>
          <!-- Fin du chargement du marketplace -->
                                    </div>
                                    <div class="card-footer text-center">
                                        <a href="" class="btn btn-outline-primary" data-toggle="modal" data-target="#monModal1"> Open the marketPlace </a> 
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                      <?php endif; ?>

                             <?php include('partials/market_place_modal.php'); ?> 
                            <div class="pubCard" id="all_post">
                              <!-- Affichage des posts -->
                        <?php if(count($placeposts) !=0 || count($pictureposted) !=0): ?>
                            <?php foreach ($placeposts as $placepost): ?>
                              <?php include('partials/place_comment_modal.php'); ?>
                                  <div class="card my-3" id="card<?= $placepost->id ?>">
                                      <div class="card-header border-0 py-2">
                                          <div class="d-flex justify-content-between">
                                              <div class="d-flex justify-content-between">
                                                <a href="#">
                                            <img class="rounded-circle" src="<?= e($src =($place->coverpic != null) ? $place->coverpic : 'images/place_cover.jpg') ?>" style="width: 45px;height: 45px; border:1.5px solid #f5f6fa;" alt="" />
                                        </a>
                                        <div class="ml-3">
                                            <div class="h6 m-0">
                                                <a href="#"><?= e($placepost->place_name) ?></a>
                                                <?php if($placepost->type == 'a ajoute une nouvelle photo'): ?>
                                                <span style="color: black;">added a status </span>
                                                <?php elseif($placepost->type == 'une grande nouvelle'): ?>
                                                <span style="color: black;">announced a big news </span>
                                                <?php elseif($placepost->type == 'un nouveaute dans son marketplace'): ?>
                                                <span style="color: black;">a novelty in the marketplace </span> 
                                                <?php elseif($placepost->type == 'Put up for sale'): ?>
                                                <span style="color: black;">announced the sale of the place </span>  
                                              <?php endif; ?>
                                            </div>
                                            <div class="text-muted h8" style="word-break: break-all;">
                                            <span class="timeago" title="<?= $placepost->created_at ?>"><?= $micropost->created_at ?></span>
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

                            <div class="card-body pt-0 pb-2">
                                <?= nl2br(replace_links(e($placepost->legend))) ?>
                            </div>
                            <img class="card-img-top rounded-0 img-thumbnail" src="<?= $placepost->urlMedia ?>" alt="Card image cap">
                            <?php if($placepost->type=="un nouveaute dans son marketplace"): ?>
        <a href="" class="btn btn-outline-primary" data-toggle="modal" data-target="#monModal1"> Open the marketplace </a> 
                            <?php endif; ?>
                            <div class="card-footer border-0 p-0">
                                <div class="d-flex justify-content-between align-items-center py-2 mx-3 border-bottom">
                                    <div>

                                    </div>
                                    <div id="likers_<?= $placepost->id ?>">
                                        <?= pdisplay_likers($placepost->id)?>
                                    </div>
                                </div>
                               <div class="d-flex justify-content-between align-items-center my-1">
                                    <div class="col">
                                  <?php if(user_has_already_liked_the_placepost($placepost->id)): ?>
                                    <a id="unlike<?= $placepost->id ?>" data-action="unlike" class="like"><button type="button" class="btn btn-zung btn-block btn-sm"><i class="far fa-heart" aria-hidden="true"></i> unlike</button></a>
                                  <?php else: ?>
                                    <a id="like<?= $placepost->id ?>" data-action="like" class="like"><button type="button" class="btn btn-zung btn-block btn-sm"><i class="far fa-heart" aria-hidden="true"></i> like</button></a>
                                  <?php endif; ?>
                                    </div>
                                    <div class="col">
                                      <button type="button" class="btn btn-zung btn-block btn-sm" data-toggle="modal" data-target="#commentModal<?= $placepost->id ?>"><i class="far fa-comment" aria-hidden="true" ></i> <?= place_comment_count($placepost->id) ?> Comment</button>
                                    </div>
                                    <div class="col">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                            <?php endforeach; ?>
                         <?php endif; ?>

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
    <script src="script.js"></script>
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
         fetch_orders();

        setInterval(function(){
           update_last_activity();
           fetch_online_user();
           fetch_incomming_msg();
           fetch_orders();
        },5000);
        
        function fetch_orders()
        {
          $.ajax({
            url:"ajax/fetch_user_order.php",
            method:"POST",
            beforeSend: function(){
                $("#orders_spinner").show();
                $("#refreshing_message_msg").show();
            },
            success:function(data){
              $("#orders_spinner").hide();
              $("#refreshing_message_msg").hide();
              $('#order_displayer').html(data);
            }
          })
        }
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

         
        $("a.like").on("click", function(e){
            e.preventDefault();

        var id= $(this).attr("id");
        var url='ajax/placepost_like.php';
        var action = $(this).data('action');
        var placepostId = id.split("like")[1];

            $.ajax({
                type:'POST',
                url:url,
                data: {
                       placepost_id: placepostId,
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
                   $("#likers_"+ placepostId).html(likers);
                }

            });
        });
        
        $("a.order").on("click", function(e){
            e.preventDefault();
            var pr_i= $(this).data("pr_i");
            var action= $(this).data("action");
            var object_price= $(this).data("object_price");
            var designation= $(this).data("designation");
            var image= $(this).data("image");
            var url='ajax/input_order.php';
            $.ajax({
                type:'POST',
                url:url,
                data: {
                       pr_i: pr_i,
                       action: action,
                       object_price:object_price,
                       designation:designation,
                       image:image
                      },
                 beforeSend: function(){
                    $("#orderer"+pr_i).show();
                    $("#ordererm"+pr_i).show();
                },
                success: function(data){
                  
                }
            });
            
        });

        $("a.comment").on("click", function(e){
            e.preventDefault();
            
            var url='ajax/comment_place.php';
            var id= $(this).attr("id");
            var post_id = id.split("comment")[1];
            var messageVar= "msg"+post_id;
            var message = $('textarea#'+messageVar).val();

            if (message.length > 0) {
             $.ajax({
                type:'POST',
                url:url,
                data: {
                       postId: post_id,
                       message: message
                      },
                success: function(response){
                   $("#comment_displayer"+post_id).html(response);
                }

            });
           }

            
            
               

        });

        });

   
    
</script>
<!-- SCRIPT -->

</body>
    
    
    
