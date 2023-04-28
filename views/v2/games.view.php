<!DOCTYPE html>
<html lang="en">
 <?php 
   
    $title = "Games";
    $page = "games";
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

                <div class="lg:flex lg:space-x-10">

                    <div class="lg:w-2/3">
                        <div class="md:mb-4 mb-3">
                            <h2 class="text-2xl font-semibold"> Games </h2>
                            <nav class="responsive-nav border-b md:m-0 -mx-4">
                                <ul>
                                    <li <?= !isset($_GET['g_i']) ? 'class="active"' : '' ?>><a href="games.php" class="lg:px-2"> Suggestions </a></li>
                                    <?php foreach($categories as $category): ?>
                                    <li <?= isset($_GET['category']) && $_GET['category'] == $category->designation ? 'class="active"' : ''?>><a href="games.php?category=<?= $category->designation ?>&g_i=<?= $category->id ?>" class="lg:px-2"> <?= $category->designation ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </nav>
                        </div>
    
                        <!-- Game slider -->
                        <div class="relative" uk-slider="finite: true">
                            <div class="uk-slider-container px-1 py-3">
                                <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                                    <?php foreach($all_games as $game): ?>
                                    <li>
                                        <div class="card">
                                            <a href="game.php?g_i=<?= $game->id ?>">
                                                <video src="<?= $game->game_cover ?>" class="h-44 object-cover rounded-t-md shadow-sm w-full" loop="true" autoplay>
                                            </a>
                                            <div class="p-3">
                                                <h4 class="text-base font-semibold mb-0.5"> <?= substr($game->game_name, 0, 15) ?> </h4>
                                                <p class="font-medium text-sm"><?= $game->plays ?> Plays </p>
                                                <a href="game.php?g_i=<?= $game->id ?>" class="block py-1.5 mt-2 text-sm font-semibold text-center bg-gray-200 rounded-md">Play  now</a>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>

                                <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                                    href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                                <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                                    href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                            </div>
                        </div>
    
                        <br>
                        
                        <!-- Clips -->
    
                        <!-- <div class="my-5 flex justify-between pb-3">
                            <h2 class="text-2xl font-semibold"> Top Clips </h2>
                            <a href="#" class="text-blue-500"> See all </a>
                        </div>
    
                        <div class="divide-y -mt-3 card px-5 py-2 ">
    
                            <div class="flex lg:flex-row flex-col lg:space-x-4 py-4 relative w-full">
                                <div class="lg:w-56 w-full h-32 overflow-hidden rounded-lg relative shadow-sm flex-shrink-0"> 
                                     <img src="assets/images/games/img-lg-1.jpg" alt="" class="w-full h-full absolute inset-0 object-cover">
                                     <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                </div>
                                <div class="flex-1 relative"> 
                                    <h2 class="text-xl font-semibold leading-6 lg:mt-0 mt-4">Strike Force Heroes 2</h2>
                                    <p class="leading-6 line-clamp-2 mt-2"> consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                    <div class="font-semibold mt-2"> Johnson Smath </div>
                                    <div class="flex space-x-2 items-center text-sm pt-1 text-sm">
                                        <div> 27 weeks ago</div>
                                        <div>·</div>
                                        <div> 156.9K views</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-4 py-4 relative w-full">
                                <div class="w-56 h-32 overflow-hidden rounded-lg relative shadow-sm flex-shrink-0"> 
                                     <img src="assets/images/games/img-lg-2.jpg" alt="" class="w-full h-full absolute inset-0 object-cover">
                                     <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                </div>
                                <div class="flex-1 relative"> 
                                    <h2 class="text-xl font-semibold leading-6">Free Fire - Battlegrounds</h2>
                                    <p class="leading-6 line-clamp-2 mt-2"> consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                    <div class="font-semibold mt-2"> Johnson Smath </div>
                                    <div class="flex space-x-2 items-center text-sm pt-1 text-sm">
                                        <div> 27 weeks ago</div>
                                        <div>·</div>
                                        <div> 156.9K views</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-4 py-4 relative w-full">
                                <div class="w-56 h-32 overflow-hidden rounded-lg relative shadow-sm flex-shrink-0"> 
                                     <img src="assets/images/games/img-lg-3.jpg" alt="" class="w-full h-full absolute inset-0 object-cover">
                                     <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> 12:21</span>
                                </div>
                                <div class="flex-1 relative"> 
                                    <h2 class="text-xl font-semibold leading-6">Clip Of Wolv Gamers Playing</h2>
                                  <p class="leading-6 line-clamp-2 mt-2"> consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam,</p>
                                    <div class="font-semibold mt-2"> Johnson Smath </div>
                                    <div class="flex space-x-2 items-center text-sm pt-1 text-sm">
                                        <div> 27 weeks ago</div>
                                        <div>·</div>
                                        <div> 156.9K views</div>
                                    </div>
                                </div>
                            </div>
                            
                        </div> -->
                    
                    </div> 

                     <!-- Sidebar -->
                     <div class="lg:w-1/3 w-full">
                        <div uk-sticky="media @m ; offset:80 ; bottom : true" class="card">
                        
                        
                            <div class="border-b flex items-center justify-between  p-4">
                                <div>
                                    <h2 class="text-lg font-semibold">Top Games</h2>
                                </div>
                                <!-- <a href="#" class="text-blue-500"> See all </a> -->
                            </div>
                        
                            <div class="p-3">
                                <?php foreach($top_games as $game): ?>
                                <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                                    <a href="game.php?g_i=<?= $game->id ?>" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <video src="<?= $game->game_cover ?>" class="absolute w-full h-full inset-0 " alt="" loop autoplay>
                                    </a>
                                    <div class="flex-1">
                                        <a href="game.php?g_i=<?= $game->id ?>" class="text-base font-semibold capitalize"> <?= $game->game_name ?> </a>
                                        <div class="text-sm text-gray-500 mt-0.5"> <?= $game->plays ?> Plays</div>
                                    </div>
                                    <a href="game.php?g_i=<?= $game->id ?>"
                                        class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold">
                                        Play
                                    </a>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        
                            <!-- <a href="#" class="border-t block text-center py-2"> See all </a> -->
                        
                        </div>
                    </div>
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
    <script src="js/v2/games.js"></script>
    <script src="js/v2/base.js"></script>

</body>
</html>
