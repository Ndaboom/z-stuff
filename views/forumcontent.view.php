<?php $title="Forum";?>

	<?php 
	require "includes/functions.php";
	include('partials/_header.php');?>
	
     <link rel="stylesheet" href="assets/css/gallery/style.css">
    
<!------ Include the above in HEAD tag ---------->



<body style="margin-top: 60px;">
    <div class="container">
        <div class="row">
          <div class="col-md-1">
            
          </div>
         <div class="col-md-8">
        <div class="coverPic">
                             
                             <?php if(get_session('user_id')== get_session('cr_i')): ?>
                             <img src="<?= e($src =($cover->coverpic != null) ? $cover->coverpic : 'images/portada_7.png') ?>" width="800px;" height="400" data-toggle="modal" data-target="#monModalCover">
                             <?php else: ?>
                              <img src="<?= e($src =($cover->coverpic != null) ? $cover->coverpic : 'images/portada_7.png') ?>" width="800px;" height="300"
                             data-toggle="modal" data-target="#monModalCoverVisualizer">
                             <?php endif; ?>
                            </div>
         <div class="card" style="width: 800px; margin-left: 100px;">   
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
               <h3 style="color: #44717C;"><i class="far fa-images"></i> Contenu du forum <a href="homeforum.php?name=<?= get_session('fr_n') ?>"><?= $_SESSION['fr_n'] ?></a></h3> 
            </div>
            <div class="col-md-6 text-right">
                <!-- <a href="" class="btn btn-outline-primary"> <i class="fas fa-users-cog"></i> Gerer les membres</a> -->
            </div>
            
        </div>  
    </div>
     <div class="card-body" style="background-color:#e9ebee;">
        <h5 style="color: black;">Images</h5>
       <!--- Affichage de phto de la galerie--->
            <?php if(count($placegallery) !=0): ?>       
                    <?php foreach (array_chunk($placegallery, 4) as  $image_set): ?> 
          <div class="row">
        <?php foreach ($image_set as $placepicture): ?> 
             <div class="col-md-3">
                   <a href="imageViewer.php?picname=<?= $placepicture->urlimage ?>"><img src="<?= $placepicture->urlimage ?>" style="width:400px; height:200px; padding: 4px;"
                   class="img-thumbnail" ></a><br>
             </div>
       <?php endforeach ?>
         </div>
        <?php endforeach ?>
         <?php else: ?>
                    <p class="text-center">Aucune image n'a ete ajouté jusque la</p>
                      <?php endif; ?>
         <div class="text-center">
           <div id="pagination"><?= $pagination ?></div>
        </div>
        <h5 style="color: black;">Photos de couverture</h5>
         <!--- Affichage des photos de couverture--->
            <?php if(count($pictureposted) !=0): ?>       
                    <?php foreach (array_chunk($pictureposted, 4) as  $coverimg_set): ?> 
          <div class="row">
        <?php foreach ($coverimg_set as $coverpicture): ?> 
             <div class="col-md-3">
                   <a href="imageViewer.php?picname=<?= $coverpicture->urlimage ?>"><img src="<?= $coverpicture->urlimage ?>" style="width:400px; height:200px; padding: 4px;"
                   class="img-thumbnail" ></a><br>
             </div>
       <?php endforeach ?>
         </div>
        <?php endforeach ?>
         <?php else: ?>
                    <p class="text-center">Aucune image de couverture n'a ete ajouté jusque la</p>
                      <?php endif; ?>
         <div class="text-center">
           <div id="pagination"><?= $pagination1 ?></div>
        </div>


         <?php if(get_session('user_id')== get_session('cr_i')): ?>
        <div class="card">
            <div class="card-body">
             <h5 style="color: #44717C;">Ajouter une image a la galerie:</h5>
        <form action="AddPlaceImageGallery.php" method="post" enctype="multipart/form-data"> 
                      <div class="row">
                          <div class="col-md-6">
                          <input type="file" name="image" required="required">  
                          </div>
                          <div class="col-md-6">
                          <div class="form-group mb-0 status-post-submit">
                           <button type="submit" name="imageUploader" class="btn btn-outline-primary btn-xs"><i class="fas fa-upload"></i> Ajouter</button> 
                            </div>
                          </div>
                           <div class="form-group mb-0 status-post-submit"> 
                          <div class="col-md-6">
                              <!-- Field pour la description -->
                                   <textarea name="description" id="description" cols="75" rows="02" class="form-control"
                                   placeholder="une petite description ou un lien"></textarea>
                                   
                                </div>
                          </div>
                        </div>
                       </form>   
            </div>
            
        </div>
      <?php endif; ?>
         <div class="card">
              <div class="card-body">
                <?php if(get_session('user_id')== get_session('cr_i')): ?>
                <h6 style="color: #44717C;">Personnaliser les trois premieres images:</h6>
                <div class="row">
                  <div class="col-md-4">
                     <a data-toggle="modal" data-target="#placeImageUpdaterModal1">
              <img src= "<?= e($src =($places->image != null) ? $places->image : 'images/place_cover.jpg') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="img-thumbnail" style="width: 250px; height: 150px;" >
              </a>
              <a data-toggle="modal" data-target="#placeImageUpdaterModal2">
              <img src= "<?= e($src =($places->image1 != null) ? $places->image1 : 'images/place_cover.jpg') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="img-thumbnail" style="width: 250px; height: 150px;" >
              </a>
                  </div>
                   <div class="col-md-8">
              <a data-toggle="modal" data-target="#placeImageUpdaterModal3">
              <img src= "<?= e($src =($places->image2 != null) ? $places->image2 : 'images/place_cover.jpg') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="img-thumbnail" style="width: 450px; height: 295px;">
              </a>
           </div> 
                </div>
              <?php else: ?>
                 <div class="row">
                  <div class="col-md-4">
                     <a href="">
              <img src= "<?= e($src =($places->image != null) ? $places->image : 'images/place_cover.jpg') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="img-thumbnail" style="width: 250px; height: 150px;" >
              </a>
              <a href="">
              <img src= "<?= e($src =($places->image1 != null) ? $places->image1 : 'images/place_cover.jpg') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="img-thumbnail" style="width: 250px; height: 150px;" >
              </a>
                  </div>
                   <div class="col-md-8">
              <a href="">
              <img src= "<?= e($src =($places->image2 != null) ? $places->image2 : 'images/place_cover.jpg') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="img-thumbnail" style="width: 450px; height: 295px;">
              </a>
           </div> 
                </div>
              <?php endif; ?>
              </div>
            </div>
            
        
                     
                      <!-- Fin de l'affichage -->  
     </div>
     <?php include('partials/confModal.php');
           include('partials/updaterModal1.php');
           include('partials/updaterModal2.php');
           include('partials/updaterModal3.php');
           ?> 
      <div class="card-footer text-center">
                        <div id="Copyright">Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved |Zungvi <i class="fa fa-heart-o" aria-hidden="true"></i><a href="" target="_blank"></a></div>
                    </div>
                    
        </div>    
         </div>   
        </div>
        </div>
         <!-- Online col-->
         
            <div class="col-lg-2 offset-fixed f-right">
                <div class="side-right">
                    <div class="h7 text-center">  Amis </div>
                    <div id="user_details">
                     
                   </div>
                </div>
                <form action="#">
                    <div class="form-group mt-2">
                        <label class="sr-only" for="wzer"></label>
                        <input type="search" class="form-control" name="wzer" id="wzer" placeholder="Rechercher">
                    </div>
                </form>
            </div>
         <!-- end --> 
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
