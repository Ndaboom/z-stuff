<!DOCTYPE html>

<html lang="en">

 <?php 

   

    $title= $notifications_nbr." Forum -".$_GET['n'];

    $page = "forum_home";

    $_SESSION['fr_i'] = $_GET['fr_i'];

    $_SESSION['fr_n'] = $_GET['n'];

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
                <div class="profile is_group">
                    <div class="profiles_banner">
                        <img src="<?= $forum->forum_pic != '' ? $forum->forum_pic : 'images/portada_7.png' ?>" alt="">
                    </div>
                    <div class="profiles_content">
                        <div class="profile_info">
                            <h1> <?= $forum->forum_name ?> </h1>
                            <p> <?= $forum->subjectsVisibility ?> forum ·  <?= forum_members_count($forum->id) ?> Member<?= forum_members_count($forum->id) > 1 ? 's' : '' ?></p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <?= forum_followers_displayer($forum->id); ?>
                        </div>
                        <?php if(get_session('user_id') == $forum->creator_id): ?>
                            <a href="" class="flex items-center justify-center h-9 px-5 rounded-md bg-blue-600 text-white  space-x-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span uk-toggle="target: #invite-friends-modal"> Invite </span>
                            </a>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="md:flex md:space-x-6 lg:mx-16">
                    <div class="space-y-5 flex-shrink-0 md:w-7/12">
                        <div class="card lg:mx-0 p-4" uk-toggle="target: #create-post-modal">
                            <div class="flex space-x-3">
                                <img src="<?= $user->profilepic ?>" class="w-10 h-10 rounded-full">
                                <input placeholder="What's Your Mind ? <?= $user->name ?>!" class="bg-gray-100 hover:bg-gray-200 flex-1 h-10 px-6 rounded-full"> 
                            </div>
                            <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 font-semibold text-sm">
                                <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                  <svg class="bg-blue-100 h-9 mr-2 p-1.5 rounded-full text-blue-600 w-9 -my-0.5 hidden lg:block" data-tippy-placement="top" title="Tooltip" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                  Photo 
                                </div>
                            </div> 
                        </div>
                        <!--  Post content here -->
                      <div id="post_list">

                      </div>
                      <!-- Post content here -->
                        <div class="flex justify-center mt-6">
                            <a href="#" class="bg-white dark:bg-gray-900 font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">
                                Loading ..</a>
                        </div>
                    </div>
                    <div class="w-full flex-shirink-0">
                        <div class="card p-4 mb-5">
                            <h1 class="block text-lg font-bold"> About  </h1>
                            <div class="space-y-4 mt-3">
                                <div class="flex items-center space-x-3">
                                    <ion-icon name="people" class="bg-gray-100 p-2 rounded-full text-2xl" role="img" aria-label="people"></ion-icon>
                                    <div class="flex-1">
                                        <div class="font-semibold">  <?= $forum->description ?> </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <ion-icon name="people" class="bg-gray-100 p-2 rounded-full text-2xl" role="img" aria-label="people"></ion-icon>
                                    <div class="flex-1">
                                        <div class="font-semibold">  <?= forum_members_count($forum->id) ?> Member<?= forum_members_count($forum->id) > 1 ? 's' : '' ?> </div>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <ion-icon name="globe-outline" class="bg-gray-100 p-2 rounded-full text-2xl" role="img" aria-label="people"></ion-icon>
                                    <div class="flex-1">
                                        <div class="font-bold"> <?= $forum->subjectsVisibility ?> </div>
                                        <?php if($forum->subjectsVisibility == "public"): ?>
                                        <div> Anyone can see who's in the group and what they post. </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- open chat box -->
    <!-- <div uk-toggle="target: #offcanvas-chat" class="start-chat">
        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
        </svg>
    </div> -->
    <!-- Create post modal -->
    <div id="create-post-modal" class="create-post" uk-modal>
        <div
            class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> Create Post </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
             <form action="forumposts.php" method="post" enctype="multipart/form-data">
            <div class="flex flex-1 items-start space-x-4 p-5">
                <img src="<?= $user->profilepic ?>"
                    class="bg-gray-200 border border-white rounded-full w-11 h-11">
                <div class="flex-1 pt-2">
                    <textarea class="uk-textare text-black shadow-none focus:shadow-none text-xl font-medium resize-none" rows="5"
                        placeholder="What's Your Mind ? <?= $user->name ?>!" name="content" id="content" required></textarea>
                    <div id="Imagepreview">
                    <img id="profileDisplay" class="border"/>   
                    </div> 
                </div>
            </div>
            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-3 shadow-sm items-center">
                    <div class="lg:block hidden"> Add to your post </div>
                    <!-- INPUTS -->
                    <input type="file" name="image" id="image" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImage(this)"/>
                    <!-- INPUTS -->
                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">
                        <svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" onclick="triggerClick()">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>
            <div class="flex items-center w-full justify-between p-3 border-t">
                <div class="flex space-x-2">
                    <a href="#" class="bg-red-100 flex font-medium h-9 items-center justify-center px-5 rounded-md text-red-600 text-sm">
                        <svg class="h-5 pr-1 rounded-full text-red-500 w-6 fill-current" id="veiw-more" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false" style=""> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Live </a>
                    <button href="#" type="submit" name="publish" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium">
                      Share </button>    
                </div>
                <a href="#" hidden
                    class="bg-blue-600 flex h-9 items-center justify-center rounded-lg text-white px-12 font-semibold">
                    Share </a>
            </div>
        </form>
        </div>
    </div>
    <!-- Create post modal -->

    <!-- Invite friends modal -->
    <div id="invite-friends-modal" class="invite-friends" uk-modal>
        <div
            class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> Invite friends </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            <!-- Content -->
            <input type="text" class="uk-input search_friends" placeholder="Search...">
            <div class="p-3" id="relativesList">

            </div>
            <!-- End Content -->
        </div>
    </div>

    <!-- Invite friends modal -->

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
    <script src="/js/v2/home_forum.js"></script>
    <script src="/script.js"></script>
    <script src="/js/v2/base.js"></script>



</body>

</html>

