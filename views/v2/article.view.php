<!DOCTYPE html>
<html lang="en">
 <?php 

   $title= $article->title;
   $page = "article";

   require ('includes/functions.php');
   require('includes/adds_functions.php');
   include('partials/header1.php');
 ?>
<body>
    <div id="wrapper"> 
         <?php include('partials/_menu1.php');
               $poster = find_user_by_id($article->user_id);
               $related_articles = find_article_by_author($article->user_id);
               $articles = fetch_all_articles(5,0);
               $all_comments = fetch_article_comments(2000,0,$_GET['a_i']);
               $comments = fetch_article_comments(5,0,$_GET['a_i']);
          ?>
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
                <div class="lg:flex lg:space-x-10">     
                    <div class="lg:w-3/4 space-y-5">   
                        <div class="card">
                            <div class="h-44 mb-4 md:h-72 overflow-hidden relative rounded-t-lg w-full">
                                <img src="/<?= $article->image ?>" alt="Article image" class="w-full h-full absolute inset-0 object-cover">
                            </div>
                            <div class="p-4">

                                <h1 class="lg:text-3xl text-2xl font-semibold mb-6"> <?= $article->title ?> </h1>
        
                                <div class="flex items-center space-x-3 my-3 pb-4 border-b">
                                    <img src="/<?= $poster->profilepic ?>" alt="" class="w-10 rounded-full">
                                    <div>
                                        <div class="text-base font-semibold"> <?= $poster->name ?> <?= $poster->nom2 ?> </div>
                                        <div class="text-xs"> Published on <?= $article->posted_at ?> 
                                        <?php if($_SESSION['user_id'] == $article->user_id): ?>
                                        <a href="create-article.php?a_i=<?= $article->id ?>" class="text-blue-600">Update</a>
                                        <a href="#" class="text-red-600 remove_article" data-a_i="<?= $article->id ?>" data-o_i="<?= $article->user_id ?>">Remove</a>
                                        <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                   <?= $article->body ?>
                                </div>
                            </div>
                        </div>
                        <?php if(count($comments) != 0): ?>
                        <div class="card p-6" id="comments_box">
                            <?= display_article_comments($_GET['a_i']) ?>
                        </div>
                        <?php else: ?>
                          <div class="card p-6" id="comments_box">
                          </div>
                        <?php endif; ?>
                        <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t">
                                  <input placeholder="Add your Comment..." class="comment_box bg-transparent max-h-10 shadow-none px-5" id="comment_box">
                                  <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">
                                      <a href="" class="py-3 px-4 post_comment" data-article_id="<?= $_GET['a_i'] ?>" id="cbtn" style="display:none; font-size:15px;">Post</a>
                                  </div>
                       </div>
                       <?php if(count($related_articles) != 0): ?>
                        <!-- related articles -->
                        <div class="card p-6 relative">
                            <h1 class="block text-lg font-semibold"> Related Articales </h1>
                              <div class="relative" uk-slider="finite: true">
                                  <div class="uk-slider-container px-1 py-3">
                                      <ul class="uk-slider-items uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                                        <?php foreach($related_articles as $article): ?>
                                        <li>
                                            <div>
                                                <a href="article.php?n=<?= $article->title ?>&a_i=<?= $article->id ?>" class="w-full md:h-32 h-28 overflow-hidden rounded-lg relative block">
                                                    <img src="/<?= $article->image ?>" alt="" class="w-full h-full absolute inset-0 object-cover">
                                                </a>
                                                <div class="pt-3">
                                                    <a href="blog-read.html" class="font-semibold line-clamp-2"> <?= $article->title ?> </a>
                                                    <div class="flex space-x-2 items-center text-xs pt-2">
                                                        <div>  <?= $article->posted_at ?> </div>
                                                        <div class="md:block hidden">·</div>
                                                        <div class="flex items-center"> <ion-icon name="chatbox-ellipses-outline" class="text-base leading-0 mr-2"></ion-icon>  12 </div>
                                                    </div>
                                                </div>
                                            </div>
                                          </li> 
                                          <?php endforeach; ?>
                                      </ul>
                                      <a class="absolute bg-white top-16 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous">  <ion-icon name="chevron-back-outline"></ion-icon></ion-icon> </a>
                                      <a class="absolute bg-white top-16 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <ion-icon name="chevron-forward-outline"></ion-icon></a>
                                  </div>
                              </div>   
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="lg:w-1/4 w-full"> 
                        <div uk-sticky="offset:100" class="uk-sticky">
                        <?php if(count($articles) != 0): ?>
                            <h2 class="text-lg font-semibold mb-3"> Recently Posted </h2>
                            <ul> 
                                <?php foreach($articles as $article): ?>
                                <li>
                                    <a href="article.php?n=<?= $article->title ?>&a_i=<?= $article->id ?>" class="hover:bg-gray-100 rounded-md p-2 -mx-2 block">
                                        <h3 class="font-medium line-clamp-2"> <?= $article->title ?> </h3>
                                        <div class="flex items-center my-auto text-xs space-x-1.5">
                                          <div> <?= $article->posted_at ?></div> <div class="pb-1"> . </div> 
                                          <ion-icon name="chatbox-ellipses-outline"></ion-icon> <div> <?= $article->views ?></div>
                                       </div> 
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                            <br>   
                            <h4 class="text-lg font-semibold mb-3">Categories</h4>
                          <div class="flex flex-wrap gap-2">
                            <a href="articles.php?categorie=computers" class="bg-gray-100 py-1.5 px-4 rounded-full"> Computers</a> 
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Tutorials</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Q&A</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> News/Actualities</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Personnal story</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Technolgy</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Music</a> 
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Feedback or synthesis</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Research</a> 
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Interview transcripts</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Classics</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> The lexicons</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> The link bait</a>
                            <a href="#" class="bg-gray-100 py-1.5 px-4 rounded-full"> Reviews/testimonials</a>
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
    <script src="/js/v2/article.js"></script>
    <script src="/js/v2/base.js"></script>
    <script src="/script.js"></script>

</body>
</html>
