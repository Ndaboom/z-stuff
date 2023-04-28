<!DOCTYPE html>
<html lang="en">
 <?php 
   
    $title = "Explorer";
    $page = "explorer";

   require('includes/functions.php');
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

        <!-- Main content here -->
        <div class="main_content">
            <div class="mcontainer">

                <div class="lg:flex lg:space-x-10">

                    <div class="lg:w-2/3">
                        <div class="flex justify-between items-center relative md:mb-4 mb-3">
                            <div class="flex-1">
                                <h2 class="text-2xl font-semibold"> <?= $page_title ?></h2>
                                <nav class="responsive-nav border-b md:m-0 -mx-4">
                                    <ul>
                                        <li <?= !isset($_GET['page']) ? 'class="active"' : ''?>><a href="place_category.php?keyword=<?= $_GET['keyword'] ?>" class="lg:px-2">   Suggestions </a></li>
                                        <li <?= $_GET['page'] == "following" ? 'class="active"' : '' ?> ><a href="place_category.php?keyword=<?= $_GET['keyword'] ?>&page=following" class="lg:px-2"> Following</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <a href="create-place.php" class="flex items-center justify-center h-10 w-10 z-10 rounded-full bg-blue-600 text-white absolute right-0"
                            data-tippy-placement="left" title="Create New Page">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                            </a>
                        </div>

                        <div class="relative" uk-slider="finite: true">
                            <div class="uk-slider-container px-1 py-3">
                                <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                                <?php if($_GET['page'] == "following"): ?>     
                                    <?php foreach($result as $row): ?>
                                        <?php $place_displayer=selectPlaceDataById($row->place_id);  ?>
                                            <?php if(count($place_displayer) !=0): ?>
                                                <?php foreach ($place_displayer as $display): ?>
                                                <li>
                                                    <a href="place_home.php?n=<?= $display->place_name ?>&pl_i=<?= $display->id ?>" class="uk-link-reset">
                                                    <div class="card">
                                                        <img src="/<?= $display->coverpic ? $display->coverpic : "images/cover.jpeg"?>" class="h-44 object-cover rounded-t-md shadow-sm w-full">
                                                        <div class="p-3">
                                                        <h4 class="text-base font-semibold mb-0.5"> <?= $display->place_name ?>  </h4>
                                                        <p class="font-medium text-sm"><?= followers_count2($display->id)?> Following</p>
                                                        </div>
                                                    </div>
                                                </a>
                                                </li>
                                                <?php endforeach; ?> 
                                            <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <?php foreach($result as $row): ?>
                                    <li>
                                        <a href="place_home.php?n=<?= $row->place_name ?>&pl_i=<?= $row->id ?>" class="uk-link-reset">
                                          <div class="card">
                                            <img src="/<?= $row->coverpic ? $row->coverpic : "images/cover.jpeg"?>" class="h-44 object-cover rounded-t-md shadow-sm w-full">
                                            <div class="p-3">
                                               <h4 class="text-base font-semibold mb-0.5"> <?= $row->place_name ?>  </h4>
                                               <p class="font-medium text-sm"><?= followers_count2($row->id)?> Following</p>
                                            </div>
                                          </div>
                                       </a>
                                    </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            
                                </ul>

                                <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                                    href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                                <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                                    href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                            </div>
                        </div>

                        <br>

                        <div class="my-2 flex items-center justify-between pb-3">
                           <div>
                               <h2 class="text-xl font-semibold"> Sponsored </h2>
                           </div>
                           <!-- <a href="#" class="text-blue-500"> See all </a> -->
                        </div>

                        <div class="relative" uk-slider="finite: true">
                            <div class="uk-slider-container px-1 py-3">
                                <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                                    <!-- <li>
                                        <a href="timeline-page.html" class="uk-link-reset">
                                          <div class="card">
                                            <img src="assets/images/avatars/avatar-6.jpg" class="h-44 object-cover rounded-t-md shadow-sm w-full">
                                            <div class="p-3">
                                               <h4 class="text-base font-semibold mb-0.5"> James Lewis  </h4>
                                               <p class="font-medium text-sm">843K Following
                                            </p></div>
                                          </div>
                                       </a>
                                    </li> -->
                                </ul>

                                <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                                    href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                                <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                                    href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                            </div>
                        </div>


                    </div>

                    <!-- Sidebar -->
                    <div class="lg:w-1/3 w-full">
                        <div uk-sticky="media @m ; offset:80 ; bottom : true" class="card">
                        
                        
                            <div class="border-b flex items-center justify-between  p-4">
                                <div>
                                    <h2 class="text-lg font-semibold">Most visited</h2>
                                </div>
                                <!-- <a href="#" class="text-blue-500"> See all </a> -->
                            </div>
                        
                            <div class="p-3">
                            <?php foreach($top6Places as $place): ?>
                                <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                                    <a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>" class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="/<?= $place->coverpic ?>" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>" class="text-base font-semibold capitalize "> <?= $place->place_name ?> </a>
                                        <div class="text-sm text-gray-500 mt-0.5"><?= followers_count2($place->id)?> Following</div>
                                    </div>
                                    <?php if(a_place_has_already_been_followed($place->id,get_session('user_id'))): ?>
                                    <a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>"
                                        class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold follow_place" data-place_id="<?= $place->id ?>" data-action="unfollow" data-place_name="<?= $place->place_name ?>" data-cr_i="<?= $place->creator_id ?>" id="follow_place<?= $place->id ?>">
                                        Following
                                    </a>
                                    <?php else: ?>
                                    <a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>"
                                        class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold follow_place" data-place_id="<?= $place->id ?>" data-action="follow" data-place_name="<?= $place->place_name ?>" data-cr_i="<?= $place->creator_id ?>" id="follow_place<?= $place->id ?>">
                                        Follow
                                    </a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                            </div>
                        
                        </div>
                    </div>

                </div>


            </div>
        </div>
        <!-- End Main content -->
        
    </div>

    <!-- Javascript
    ================================================== -->
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="js/v2/place_category.js"></script>
    <script src="js/v2/base.js"></script>

</body>
</html>
