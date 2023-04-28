<!DOCTYPE html>
<html lang="en">
 <?php 
    $title= "articles";
    $page = "event_home"; 
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
                <div class="lg:flex  lg:space-x-12">
                    <div class="lg:w-3/4">  
                        <div class="flex justify-between items-center relative md:mb-4 mb-3">
                            <div class="flex-1">
                                <h2 class="text-2xl font-semibold"> Blog </h2>
                                <nav class="responsive-nav border-b md:m-0 -mx-4">
                                    <ul>
                                        <li <?= $_GET['p'] == "" ? 'class="active" ' : ''?>><a href="articles.php" class="lg:px-2">   All articles </a></li>
                                        <li <?= $_GET['p'] == "m_articles" ? 'class="active" ' : ''?>><a href="articles.php?p=m_articles" class="lg:px-2"> Your acticles </a></li>
                                    </ul>
                                </nav>
                            </div>
                            <a href="create-article.php" class="flex items-center justify-center h-10 w-10 z-10 rounded-full bg-blue-600 text-white absolute right-0"
                            data-tippy-placement="left" title="Create New Article">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            </a>
                        </div>
                        <div class="card divide-y px-4" id="articles_box">


                        </div>
                    </div>
                    <div class="lg:w-1/4 w-full flex-shrink-0">
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
                        <h4 class="text-lg font-semibold mb-3"> Categories </h4>
                        <div class="flex flex-wrap gap-2">
                            <a href="articles.php?category=Tutorials" class="bg-gray-100 py-1.5 px-4 rounded-full"> Tutorials</a>
                            <a href="articles.php?category=Q&A" class="bg-gray-100 py-1.5 px-4 rounded-full"> Q&A</a>
                            <a href="articles.php?category=News/Actualités" class="bg-gray-100 py-1.5 px-4 rounded-full"> News/Actualités</a>
                            <a href="articles.php?category=Personnalstory" class="bg-gray-100 py-1.5 px-4 rounded-full"> Personnal story</a>
                            <a href="articles.php?category=Technolgy" class="bg-gray-100 py-1.5 px-4 rounded-full"> Technolgy</a>
                            <a href="articles.php?category=Music" class="bg-gray-100 py-1.5 px-4 rounded-full"> Music</a> 
                            <a href="articles.php?category=Feedbackorsynthesis" class="bg-gray-100 py-1.5 px-4 rounded-full">Feedback or synthesis</a>
                            <a href="articles.php?category=Research" class="bg-gray-100 py-1.5 px-4 rounded-full"> Research</a> 
                            <a href="articles.php?category=Interviewtranscripts" class="bg-gray-100 py-1.5 px-4 rounded-full"> Interview transcripts</a>
                            <a href="articles.php?category=Classics" class="bg-gray-100 py-1.5 px-4 rounded-full"> Classics</a>
                            <a href="articles.php?category=Thelexicons" class="bg-gray-100 py-1.5 px-4 rounded-full"> The lexicons</a>
                            <a href="articles.php?category=Thelinkbait" class="bg-gray-100 py-1.5 px-4 rounded-full"> The link bait</a>
                            <a href="articles.php?category=Reviews/testimonials" class="bg-gray-100 py-1.5 px-4 rounded-full"> Reviews/testimonials</a>
                            <a href="articles.php?category=cinema" class="bg-gray-100 py-1.5 px-4 rounded-full"> Cinema</a>
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
    <script src="/js/v2/home_event.js"></script>
    <script src="/js/v2/base.js"></script>
    <script src="/script.js"></script>
    <script>
    $(document).ready(function(){
     
     var limit = 7;
     var start = 0;
     var limit2 = 7;
     var action = 'inactive';
    
    <?php if($_GET['p'] == ""): ?> 
    function retrieve_articles(limit,start){
       
       $.ajax({
            url:"/ajax/v2/fetch_articles.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            beforeSend: function(){
                    $("#loader").show();
            },
            success:function(data)
            {
              $('#articles_box').html(data);
            }
          })
    }
    <?php elseif($_GET['p'] == "m_articles"): ?>
        function retrieve_articles(limit,start){
       
       $.ajax({
            url:"/ajax/v2/someone_articles.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            beforeSend: function(){
                    $("#loader").show();
            },
            success:function(data)
            {
              $('#articles_box').html(data);
            }
          })
    }   
    <?php endif; ?>

    if(action == 'inactive')
    {
        action = 'active';
        retrieve_articles(limit,start);

    }
    
    $(window).scroll(function(){
        if($(window).scrollTop() + $(window).height() > $("#articles_box").height() && action == 'inactive')
        {
        action = 'active';
        start = start + limit;
        limit2 = start+7;
        setTimeout(function(){
            retrieve_articles(limit,start);
        },1000);
        }
    });
    
    });
    
    </script>

</body>
</html>
