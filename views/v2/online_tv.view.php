<!DOCTYPE html>
<html lang="en">
 <?php 
   
    $title = "Tv";
    $page = "pages";

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
                <div class="flex justify-between relative md:mb-4 mb-3">
                    <div class="flex-1">
                        <h2 class="text-2xl font-semibold"> Tv </h2>
                        <nav class="responsive-nav border-b md:m-0 -mx-4">
                            <ul>
                                <li class="active"><a href="#" class="lg:px-2">   Suggestions </a></li>
                                <li><a href="#" class="lg:px-2"> Newest </a></li>
                                <li><a href="#" class="lg:px-2"> Favorites </a></li>
                            </ul>
                        </nav>
                    </div>
                    <a href="create-stream.php" uk-toggle class="flex items-center justify-center h-9 lg:px-5 px-2 rounded-md bg-blue-600 text-white space-x-1.5 absolute right-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="md:block hidden"> Add Stream </span>
                    </a> 
                </div>

                <!-- Vide slider -->

                <div class="relative" uk-slider="finite: true">
                    
                    <div class="uk-slider-container px-1 py-3">
                        <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                            <?php foreach($tvs as $tv): ?>
                           <li>
                                <a href="channel.php?cn=<?= $tv->id ?>" class="w-full md:h-36 h-28 overflow-hidden rounded-lg relative block">
                                    <img src="/<?= $tv->channel_image ?>" alt="" class="w-full h-full absolute inset-0 object-cover">
                                    <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> -:-</span>
                                    <img src="/images/icons/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                </a>
                                <div class="pt-3">
                                    <a href="channel.php?cn=<?= $tv->id ?>" class="font-semibold line-clamp-2"> <?= $tv->channel_name ?> </a>
                                    <div class="pt-2">
                                        <a href="#" href="channel.php?cn=<?= $tv->id ?>" class="text-sm">  <?= $tv->channel_description ?>  </a>
                                        <div class="flex space-x-2 items-center text-xs">
                                            <div> <?= zungvi_time_ago($tv->created_at) ?></div>
                                            <div class="md:block hidden">·</div>
                                            <div> <?= $tv->views ?> views</div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>

                        <a class="absolute bg-white top-16 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                        <a class="absolute bg-white top-16 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                    </div>
                </div>

                <br>  

                <div class="md:mb-4 mb-3">
                    <h2 class="text-2xl font-semibold"> Your videos </h2>
                    <nav class="responsive-nav border-b md:m-0 -mx-4">
                        <ul>
                            <li class="active"><a href="#" class="lg:px-2">   Suggestions </a></li>
                            <li><a href="#" class="lg:px-2"> Newest </a></li>
                            <li><a href="#" class="lg:px-2"> My videos </a></li>
                        </ul>
                    </nav>
                </div>

                <!--  videos  list -->

                <div class="divide-y">

                    <!-- <div class="flex md:space-x-6 space-x-4 md:py-5 py-3 relative">
                        <a href="" class="md:w-64 md:h-40 w-36 h-24 overflow-hidden rounded-lg relative shadow-sm"> 
                            <img src="assets/images/video/img-3.png" alt="" class="w-full h-full absolute inset-0 object-cover">
                            <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                            <img src="assets/images/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                        </a>
                        <div class="flex-1 space-y-2"> 
                            
                            <a href="" class="md:text-xl font-semibold line-clamp-2">   Exploring an Abandoned Water Park in China  </a>
                            <p class="leading-6 pr-4 line-clamp-2 md:block hidden"> Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna . </p>
                            <a href="#" class="font-semibold block text-sm"> Stalla Johani</a>
                        
                        <div class="flex items-center justify-between">
                                <div class="flex space-x-3 items-center text-sm md:pt-3">
                                    <div> 27 weeks ago</div>
                                    <div class="md:block hidden">·</div>
                                    <div> 156.9K views</div>
                                </div>
                                <a href="#" class="md:flex items-center justify-center h-9 px-8 rounded-md border hidden"> Add favorites </a>
                            </div>

                            <div class="absolute top-1 right-0 md:inline hidden">
                                <a href="#" class="hover:bg-gray-200 p-1.5 inline-block rounded-full" aria-expanded="false"> 
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                                </svg>
                                </a>
                                <div class="bg-white w-56 shadow-md mx-auto p-2 mt-12 rounded-md text-gray-500 hidden text-base border border-gray-100 dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700 uk-drop uk-drop-bottom-right" uk-drop="mode: hover;pos: top-right" style="left: -188px; top: -12px;">
                        
                                    <ul class="space-y-1">
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                        <i class="uil-share-alt mr-1"></i> Share
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                        <i class="uil-edit-alt mr-1"></i>  Edit Post 
                                        </a> 
                                    </li>
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                        <i class="uil-comment-slash mr-1"></i>   Disable comments
                                        </a> 
                                    </li> 
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 hover:bg-gray-200 hover:text-gray-800 rounded-md dark:hover:bg-gray-800">
                                        <i class="uil-favorite mr-1"></i>  Add favorites 
                                        </a> 
                                    </li>
                                    <li>
                                        <hr class="-mx-2 my-2 dark:border-gray-800">
                                    </li>
                                    <li> 
                                        <a href="#" class="flex items-center px-3 py-2 text-red-500 hover:bg-red-100 hover:text-red-500 rounded-md dark:hover:bg-red-600">
                                        <i class="uil-trash-alt mr-1"></i>  Delete
                                        </a> 
                                    </li>
                                    </ul>
                                
                                </div>
                            </div>

                        </div>
                    </div>  -->
                 

                </div> 

                </div>
        </div>
        
    </div>

    <!-- Javascript
    ================================================== -->
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="js/v2/events.js"></script>
    <script src="js/v2/base.js"></script>

</body>
</html>
