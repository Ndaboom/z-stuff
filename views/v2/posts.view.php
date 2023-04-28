<!DOCTYPE html>
<html lang="en">
 <?php 

   $title= $user->name."'s photos";
   $page = "article";

   require ('includes/functions.php');
   require('includes/adds_functions.php');
   include('partials/header1.php');
 ?>
<body>
    <div id="wrapper">     
         <?php include('partials/_menu1.php'); ?>  
        <!-- sidebar -->
        <div class="sidebar">
            <div class="sidebar_header"> 
                <img src="assets/images/logo.png" alt="">
                <img src="assets/images/logo-icon.html" class="logo-icon" alt="">
                <span class="btn-mobile" uk-toggle="target: #wrapper ; cls: is-collapse is-active"></span>
            </div>
             <?php  
                include('partials/v2/side_bar.php');
             ?>
        </div> 
        <!-- Main Contents -->
        <div class="main_content">
            <div class="mcontainer">
                <div class="flex justify-between items-center relative md:mb-4 mb-3">
                    <div class="flex-1">
                        <h2 class="text-2xl font-semibold"> <?= $current_user->name ?> Posts </h2>
                        <nav class="responsive-nav border-b md:m-0 -mx-4">
                            <ul>
                                <li <?= !$_GET['categorie'] ? "class='active'" : "" ?>><a href="posts.php?id=<?= $_GET['id'] ?>" class="lg:px-2">  All  <span> <?= $posts ?></span> </a></li>
                                <li <?= $_GET['categorie'] == "profile_pictures" ? "class='active'" : "" ?> ><a href="posts.php?id=<?= $_GET['id'] ?>&categorie=profile_pictures" class="lg:px-2"> Profile pictures </a></li>
                                <li <?= $_GET['categorie'] == "videos" ? "class='active'" : "" ?> ><a href="posts.php?id=<?= $_GET['id'] ?>&categorie=videos" class="lg:px-2"> Videos </a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="grid md:grid-cols-4 grid-cols-2 gap-3 mt-5" id="photos_gallery">
             
                </div>
            </div>   
    </div>
    <!-- For Night mode -->
    <script>
        (function (window, document, undefined) {
            'use strict';
            if (!('localStorage' in window)) return;
            var nightMode = localStorage.getItem('gmtNightMode');
            if (nightMode) {
                document.documentElement.className += ' night-mode';
            }
        })(window, document);
    
        (function (window, document, undefined) {
    
            'use strict';
    
            // Feature test
            if (!('localStorage' in window)) return;
    
            // Get our newly insert toggle
            var nightMode = document.querySelector('#night-mode');
            if (!nightMode) return;
    
            // When clicked, toggle night mode on or off
            nightMode.addEventListener('click', function (event) {
                event.preventDefault();
                document.documentElement.classList.toggle('dark');
                if (document.documentElement.classList.contains('dark')) {
                    localStorage.setItem('gmtNightMode', true);
                    return;
                }
                localStorage.removeItem('gmtNightMode');
            }, false);
    
        })(window, document);
    </script>
  
    <!-- Javascript
    ================================================== -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="/js/v2/base.js"></script>
    <script src="/script.js"></script>
    
    <script>
        $(document).ready(function() {
        
        <?php if(relation_link_to_display($_GET['id']) == "delete_relation_link" || $user->posts_privacy == 0 || $_SESSION['user_id'] == $_GET['id']): ?>

            let start = 0;
            let limit = 16;
            <?php if(!empty($_GET['id'])): ?>
            let user_id = <?= $_GET['id'] ?>;
            <?php else: ?>
            let user_id = <?= $_SESSION['user_id'] ?>;
            <?php endif; ?>
            
            <?php if(!$_GET['categorie']): ?>
            fetch_gallery(user_id, start, limit);
            
            function fetch_gallery(user_id, start, limit){
            
            let url='/ajax/v2/fetch_gallery.php';
                //Ajax request
            $.ajax({
                type:'POST',
                url:url,
                data: {
                       user_id: user_id,
                       start: start,
                       limit: limit
                      },
                 beforeSend: function(){
                 $("#loading_box").slideToggle('slow');
                },
                success: function(data){
                 $("#photos_gallery").html(data);
                }

            });
    //End Request
            }
            
          <?php elseif(isset($_GET['categorie']) && $_GET['categorie'] == "profile_pictures"): ?>
          
          fetch_gallery(user_id, start, limit);
            
            function fetch_gallery(user_id, start, limit){
            
            let url='/ajax/v2/fetch_profile_pictures.php';
                //Ajax request
                $.ajax({
                type:'POST',
                url:url,
                data: {
                       user_id: user_id,
                       start: start,
                       limit: limit
                      },
                 beforeSend: function(){
                 $("#loading_box").slideToggle('slow');
                },
                success: function(data){
                 $("#photos_gallery").html(data);
                }

                });
    //End Request
            }
          <?php elseif(isset($_GET['categorie']) && $_GET['categorie'] == "videos"): ?>
          
          fetch_gallery(user_id, start, limit);
            
            function fetch_gallery(user_id, start, limit){
            
            let url='/ajax/v2/fetch_videos.php';
                //Ajax request
            $.ajax({
                        type:'POST',
                        url:url,
                        data: {
                            user_id: user_id,
                            start: start,
                            limit: limit
                            },
                        beforeSend: function(){
                        $("#loading_box").slideToggle('slow');
                        },
                        success: function(data){
                        $("#photos_gallery").html(data);
                        }

            });
    //End Request
            }
          
          <?php endif; ?>
        
        <?php else: ?> 
            $('#photos_gallery').html('<div class="bg-whit border-t-4 border-red-600 p-5 shadow-lg relative rounded-md uk-alert" uk-alert=""><h3 class="text-lg font-semibold mt-1">Private Account </h3><p>You must be friends with this user to see these posts.</p><div class="flex space-x-2 items-center justify-end mt-2"></div></div>');
        <?php endif; ?>
     
        });
    </script>

</body>
</html>
