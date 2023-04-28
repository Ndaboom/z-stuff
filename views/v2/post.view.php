<!DOCTYPE html>
<html lang="en">
 <?php 

   $title= "Post";
   $page = "single_post";

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
        <!--  Feeds  -->
        <div class="lg:flex lg:space-x-10">
          <div class="lg:w-3/4 lg:px-20 space-y-7">
              <div id="post_box">



              </div>
          </div>

          <div class="lg:w-72 w-full">
              <h3 class="text-xl font-semibold mb-2"> Birthdays </h3>
              <a href="#" class="uk-link-reset mb-2">
                  <div class="flex py-2 pl-2 mb-2 rounded-md hover:bg-gray-200">
                      <img src="/icons/gift-icon.png" class="w-9 h-9 mr-3" alt="">
                      <p class="line-clamp-2"> <strong> Jessica Erica </strong> and <strong> two others </strong>
                          have a birthdays to day .
                      </p>
                  </div>
              </a>
              <h3 class="text-xl font-semibold"> Contacts </h3>
              <div class="" uk-sticky="offset:80">
                  <nav class="cd-secondary-nav border-b extanded mb-2">
                      <ul uk-switcher="connect: #group-details; animation: uk-animation-fade">
                          <li class="uk-active"><a class="active" href="#0">  Friends  <span> <?= friends_count(get_session('user_id')) ?> </span> </a></li>
                      </ul>
                  </nav>
                  <div class="contact-list" id="user_details">

      
                  </div>
              </div>
          </div>
        </div>
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
    <script src="/js/v2/post.js"></script>
    <script src="/script.js"></script>
    <script>
        $(document).ready(function() {
            var post_id = <?= $_GET['id'] ?>;
            fetch_post(post_id);

            function fetch_post(post_id)
                {
                $.ajax({
                    url:"/ajax/v2/fetch_post.php",
                    method:"POST",
                    data:{post_id:post_id},
                    success:function(data){
                    $('#post_box').html(data);
                    }
                })
                }

                $(document).on('click', '.post_comment', function(e){
                    e.preventDefault();

                    var id= $(this).attr("id");
                    var postId = id.split("cbtn")[1];
                    var content = $("#comment_box"+postId).val();
                    var url='/ajax/v2/post_comment.php';
                    var user_profile = "images/default.png";
                    var poster = $(this).data('poster');
                    
                    if (content.length > 0) {
                    $.ajax({
                        type:'POST',
                        url:url,
                        data: {
                            postId: postId,
                            content: content,
                            poster: poster
                            },
                        beforeSend: function(){
                        $("#comment_box"+postId).val('');
                        },
                        success:function(response){
                            fetch_post(post_id);
                        }
                    });
                }
                });

                $(document).on('click', '.delete_comment', function(e){
                    e.preventDefault();
                    
                    var url='/ajax/v2/delete_comment.php'; 
                    var poster_id = $(this).data('poster_id');
                    var commentid = $(this).data('commentid');

                    $.ajax({
                        type:'POST',
                        url:url,
                        data: {
                            commentid: commentid,
                            poster_id: poster_id
                            },
                        beforeSend: function(){
                        $("#dcomment_id"+commentid).slideToggle();  
                        },
                        success: function(){
                        fetch_post(post_id);
                        }
                    })
                });

                $(document).on('click', '.like_comment', function(e){
                    e.preventDefault();
                    
                    var poster_id = $(this).data('poster_id');
                    var comment = $(this).data('comment');
                    var post = $(this).data('post');
                    var commentid = $(this).data('commentid');
                    var action= 'like_comment';
                    $.ajax({
                        url:"/action.php",
                        method:"POST",
                        data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
                        success:function(data)
                        {
                        fetch_post(post_id);
                        audioElement.play();
                        }
                    })  
                });
        });
    </script>


</body>
</html>
