<!DOCTYPE html>
<html lang="en">
 <?php 
    if($notifications_count > 0)
    {
      $notifications_nbr = "(".$notifications_count.")";
      $notifs_number = $notifications_nbr;
    }else{
      $notifications_nbr = "";
    }
    $title= $notifications_nbr." News feed";
    $page = "feed";

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
                <img src="assets/images/logo.png" class="logo-icon" alt="">
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
                      <div class="bg-white shadow border border-gray-100 rounded-lg dark:bg-gray-900 lg:mx-0 p-4">
                          <div class="flex space-x-3" uk-toggle="target: #create-post-modal">
                              <img src="/<?= $user2->profilepic ?>" class="w-10 h-10 rounded-full">
                              <input placeholder="<?= $long_text['whats_up'][$_SESSION['locale']] ?> ? <?= $user2->name ?> 😊!" class="bg-gray-100 hover:bg-gray-200 flex-1 h-10 px-6 rounded-full"> 
                          </div>
                          <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 font-semibold text-sm">
                              <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer" uk-toggle="target: #create-post-modal"> 
                                <svg class="h-5 pr-1 rounded-full text-blue-500 w-6 fill-current" data-tippy-placement="top" title="Tooltip" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Photo/Video 
                              </div>
                              <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer" uk-toggle="target: #create-product-modal">                                                <svg  class="h-5 pr-1 rounded-full text-blue-500 w-6 fill-current" data-tippy-placement="top" title="Share a product" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                              Products
                              </div>
                              <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                              <svg class="h-5 pr-1 rounded-full text-red-500 w-6 fill-current" id="veiw-more" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false" style=""> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                              Live
                              </div>
                          </div> 
                      </div>
                      <?php if(friends_count(get_session('user_id')) != 0): ?>
                      <div id="post_list" uk-scrollspy="cls: uk-animation-slide-bottom; target: .post_box; delay: 500; repeat: false;">
                          
                      </div>
                      <div class="flex justify-center mt-6">
                          <a href="#" class="bg-white dark:bg-gray-900 font-semibold my-3 px-6 py-2 rounded-full shadow-md dark:bg-gray-800 dark:text-white">Load more ..</a>
                      </div>
                      <?php else: ?>
                        <div class="my-2 flex items-center justify-between pb-3">
                           <div>
                               <h2 class="text-xl font-semibold"> People around you</h2>
                           </div>
                           <a href="explorer.php" class="text-blue-500"> Explore </a>
                        </div>
                        <!--  Relatives list ---> 
                        <div class="relative" uk-slider="finite: true" id="relatives_list">
                            
                                         
                        </div>
                        <!-- Relatives list  --->
                      <?php endif; ?>
                  </div>
                  <div class="lg:w-72 w-full">
                      <h3 class="text-xl font-semibold mb-2"> <?= $long_text['birthdays'][$_SESSION['locale']] ?> </h3>
                      <a href="#" class="uk-link-reset mb-2">
                          <div class="flex py-2 pl-2 mb-2 rounded-md hover:bg-gray-200">
                              <img src="/icons/gift-icon.png" class="w-9 h-9 mr-3" alt="">
                              <p class="line-clamp-2"> 
                                  
                              </p>
                          </div>
                      </a>
                      <h3 class="text-xl font-semibold"> Contacts </h3>
                      <div class="" uk-sticky="offset:80">
                          <nav class="cd-secondary-nav border-b extanded mb-2">
                              <ul uk-switcher="connect: #group-details; animation: uk-animation-fade">
                                  <li class="uk-active"><a class="active" href="#0">  <?= $long_text['friends'][$_SESSION['locale']] ?>  <span> <?= friends_count(get_session('user_id')) ?> </span> </a></li>
                              </ul>
                          </nav>
                          <div class="contact-list" id="user_details" style="overflow-x: hidden;">

              
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- story-preview -->
    <div class="story-prev">
        <div class="story-sidebar uk-animation-slide-left-medium">
            <div class="md:flex justify-between items-center py-2 hidden">
                <h3 class="text-2xl font-semibold"> All Moments </h3>
                <a href="#" class="text-blue-600"> Setting</a>
            </div>
            <div class="story-sidebar-scrollbar" data-simplebar>
                <h3 class="text-lg font-medium"> Your Moments </h3>
                <a class="flex space-x-4 items-center hover:bg-gray-100 md:my-2 py-2 rounded-lg hover:text-gray-700" href="#">
                    <svg class="w-12 h-12 p-3 bg-gray-200 rounded-full text-blue-500 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <div class="flex-1">
                        <div class="text-lg font-semibold" uk-toggle="target: #create-moment-modal" > Create a moment </div>
                        <div class="text-sm -mt-0.5"> Share a photo or write something. </div>
                    </div>
                </a>
                <h3 class="text-lg font-medium lg:mt-3 mt-1"> Friends Moment </h3>
                <div class="story-users-list"  uk-switcher="connect: #story_slider ; toggle: > * ; animation: uk-animation-slide-right-medium, uk-animation-slide-left-medium ">
                <?php if(!empty($stories_posters)): ?>
                    <?php foreach($stories_posters as $story): ?>
                        <?php $poster = find_user_by_id($story->user_id); ?>
                    <a href="" class="toggleStories" data-user_id="<?= $story->user_id ?>">
                        <div class="story-media">
                            <img src="/<?= $poster->profilepic ?>" alt="<?= $poster->name ?> profile picture">
                        </div>
                        <div class="story-text">
                            <div class="story-username"> <?= $poster->name ?> <?= $poster->nom2 ?></div>
                            <p> <span class="story-count"><?= $story->moments_nbr ?> moments </span> <span class="story-time"> <?= zungvi_time_ago($story->posted_at);  ?></span> </p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    No moment yet...
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="story-content">
            <ul class="uk-switcher uk-animation-scale-up" id="story_slider" >
            </ul>
        </div>
        <!-- story colose button-->
        <span class="story-btn-close" uk-toggle="target: body ; cls: story-active" uk-tooltip="title:Close story ; pos: left">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </span>
    </div> 
    <!-- Create Product modal -->
     <div id="create-product-modal" class="create-post" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-overflow-auto rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> Product Informations </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            <!-- Modal content -->
            </div>
            <div class="card lg:mx-0 uk-animation-slide-bottom-small">
            <!-- post header-->
            <div class="flex justify-between items-center lg:p-4 p-2.5">
                <div class="flex flex-1 items-center space-x-4">
                    <a href="#">
                        <img src="/<?= $user->profilepic ?>" class="bg-gray-200 border border-white rounded-full w-10 h-10">
                    </a>
                    <div class="flex-1 font-semibold capitalize">
                        <a href="#" class="text-black"> <?= $user->name ?> <?= $user->nom2 ?> </a>
                        <div class="text-green-500 flex items-center space-x-2"> on it...  <ion-icon name="people"></ion-icon></div>
                    </div>
                </div>
            <div>
                <a href="#"> <i class="icon-feather-more-horizontal text-2xl hover:bg-gray-200 rounded-full p-2 transition -mr-1 dark:hover:bg-gray-700"></i> </a>
                <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700" 
                uk-drop="mode: click;pos: bottom-right;animation: uk-animation-slide-bottom-small">
            
                    <!-- <ul class="space-y-1">
                    
                    </ul> -->
                
                </div>
            </div>
            </div>
            <div>  
            <img src="/images/pexels/pexels-lorenzo-242236.jpg" id="product_preview" onclick="triggerProduct()" alt="" class="max-h-96 w-full object-cover">
    </div>

    <div class="p-4 space-y-3 relative"> 
        <form method="post" enctype="multipart/form-data" action="/add_product.php">
        <input type="file" name="image" id="product_image" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayProduct(this)"/>
        <input class="text-2xl font-semibold pt-2" type="text" name="product_designation" placeholder="product designation" required/>
        <textarea name="product_description" placeholder="short description" required></textarea>
        <div class="flex space-x-3 items-center text-sm md:pt-3">
            <div> Status</div>
            <div class="md:block hidden">·</div>
            <div class="font-semibold text-yellow-500"> Instock</div>
            <div class="flex"> <input name="product_price" type="number" placeholder="product price" class="font-semibold text-yellow-500" required/> </div>
        </div>
        <hr>
        <div class="grid grid-cols-2 gap-4 mb-5">
            <a href="#" class="bg-gray-200 flex flex-1 font-semibold h-10 items-center justify-center px-4 rounded-md" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7">
                Close 
                </a>
            <input name="add_product" type="submit" value="Share" class="bg-blue-600 flex flex-1 font-semibold h-10 items-center justify-center px-4 rounded-md text-white"/>
        </div>
        </form>
    </div>
    </div>
            </div>
            <!-- Modal content end -->
        </div>
    <!-- Create Product modal -->
    <!-- Create post modal -->
    <div id="create-post-modal" class="create-post" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-overflow-auto rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> <?= $long_text['create_post'][$_SESSION['locale']] ?> </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            <form method="post" id="upload_form" action="/add_post.php" enctype="multipart/form-data">
            <div class="flex flex-1 items-start space-x-4 p-5">
                <img src="/<?= $user2->profilepic ?>"
                    class="bg-gray-200 border border-white rounded-full w-11 h-11">
                <div class="flex-1 pt-0">
                    <textarea class="uk-textare text-black shadow-none focus:shadow-none resize-none" rows="2" placeholder="<?= $long_text['whats_up'][$_SESSION['locale']] ?> <?= $user2->name ?> 😊?" name="content" id="content" required></textarea>
                </div>
            </div>
            <!-- Images preview -->
            <div class="grid grid-cols-2 gap-2 p-2">
                <a class="col-span-2">  
                    <img src="" alt="" class="rounded-md w-full lg:h-76 object-cover" onclick="triggerClick()" id="pimage1" style="max-height:300px;display:none;">
                </a>
                <a > 
                    <img src="" alt="" class="rounded-md w-full h-full" onclick="trigger('image1')" id="pimage2" style="max-height: 200px;display:none;">
                </a>
                <a class="relative">
                    <img src="" alt="" class="rounded-md w-full h-full" onclick="trigger('image2')" id="pimage3" style="max-height: 200px;display:none;">
                </a>
            </div>
            <!-- Images preview -->

            <!-- Videos preview -->
            <div class="grid grid-cols-2 gap-2 p-2">
             <a class="col-span-2"> 
              <video controls class="rounded-md w-full lg:h-76 object-cover" preload="meta-data" loop poster="" onclick="videoTrigger();" id="video_player" style="max-height:300px;display:none;">
                <source src=""></source>
             </video> 
             </a>
            <progress id="progressBar" value="0" max="100" style="display:none;"></progress>
            <h5 id="status" style="display:none;"></h5>
            <p id="loaded_n_total" style="display:none;"></p>
            </div>
            <!-- Videos preview -->
            
            <!-- INPUTS  -->
                <input type="file" name="image1" id="image" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImages(this,1)"/> 
                <input type="file" name="image2" id="image1" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImages(this,2)"/>
                <input type="file" name="image3" id="image2" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImages(this,3)"/>
                <input type="file" name="file1" id="file1" accept=".mp4,.avi, .wav" style="display:none;" onchange="displayVideo(this)"/>
            <!-- INPUTS  -->

            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-3 shadow-sm items-center">
                    <div class="lg:block hidden"> <?= $long_text['add_to_post'][$_SESSION['locale']] ?> </div>
                    <div class="flex flex-1 items-center lg:justify-end justify-center space-x-2">
                        <svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" onclick="customTrigger()" id="images_trigger">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <svg class="text-red-600 h-9 p-1.5 rounded-full bg-red-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" onclick="videoTrigger()" > <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"> </path></svg>
                        <svg class="text-green-600 h-9 p-1.5 rounded-full bg-green-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"> </path></svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"> </path></svg>
                        <svg class="text-pink-600 h-9 p-1.5 rounded-full bg-pink-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        <svg class="text-purple-600 h-9 p-1.5 rounded-full bg-purple-100 w-9 cursor-pointer" id="veiw-more" hidden fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path> </svg>
                        <!-- view more -->
                        <svg class="hover:bg-gray-200 h-9 p-1.5 rounded-full w-9 cursor-pointer" id="veiw-more" uk-toggle="target: #veiw-more; animation: uk-animation-fade" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"> </path></svg>
                    </div>
                </div>
            </div>
            <div class="flex items-center w-full justify-between p-3 border-t">
                <div class="flex space-x-2">
                    <a href="#" class="bg-red-100 flex font-medium h-9 items-center justify-center px-5 rounded-md text-red-600 text-sm" style="padding: 7px;">
                        <svg class="h-5 pr-1 rounded-full text-red-500 w-6 fill-current" id="veiw-more" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false" style=""> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Live </a>
                    <input type="submit" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium" value="Share" style="padding: 7px;" name="add_post" id="post_sharing_btn"/> 
                    <input type="button" class="bg-blue-600 flex h-9 items-center justify-center rounded-md text-white px-5 font-medium upload_video" value="Share" style="padding: 7px;" name="upload_video" id="video_sharing_btn"/>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ======================== Javascript ========================== -->

    <script src="/moment_sharing.js" ></script>
    <script src="/script.js"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="js/v2/feed.js"></script>
    <script src="js/v2/base.js"></script>
    
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
</body>

</html>