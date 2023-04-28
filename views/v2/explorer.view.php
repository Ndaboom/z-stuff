<!DOCTYPE html>
<html lang="en">
 <?php 
   
    $title = "Explorer";
    $page = "explorer";

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
                        <h2 class="text-2xl font-semibold"> <?= $long_text['explore'][$_SESSION['locale']] ?> </h2>
                        <nav class="responsive-nav border-b md:m-0 -mx-4">
                            <ul>
                                <li class="active"><a href="#" class="lg:px-2">   Suggestions </a></li>
                                <li><a href="#people" class="lg:px-2"> <?= $long_text['people'][$_SESSION['locale']] ?> </a></li>
                                <li><a href="#" class="lg:px-2"> <?= $long_text['places'][$_SESSION['locale']] ?> </a></li>
                            </ul>
                        </nav>
                    </div>
                    <a href="create-place.php" class="flex items-center justify-center h-9 lg:px-5 px-2 rounded-md bg-blue-600 text-white space-x-1.5 absolute right-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="md:block hidden"> <?= $long_text['create'][$_SESSION['locale']] ?> </span>
                    </a> 
                </div>
               
                <div class="relative" uk-slider="finite: true">
                
                    <div class="uk-slider-container px-1 py-3">
                        <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-grid-small uk-grid">
                         <?php foreach($places as $place): ?>
                            <li>
                                <div class="card"> 
                                    <div class="card-media h-28">
                                        <div class="card-media-overly"></div>
                                        <img src="/<?= $place->coverpic ? $place->coverpic : "images/cover.jpeg"?>" alt="" class="">
                                    </div>
                                    <div class="card-body">
                                        <a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>" class="font-semibold text-lg truncate"><?= $place->place_name ?></a>
                                        <div class="flex items-center flex-wrap space-x-1 text-sm text-gray-500 capitalize">
                                            <a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>"> <span> <?= records_count('places_followers', 'place_id', $place->id) ?> <?= $long_text['follower(s)'][$_SESSION['locale']] ?>  </span> </a>
                                            <a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>"> <span> <?= $place->category ?> </span> </a> - <?= unviewed_placepost($place->id, $_SESSION['user_id']); ?>
                                        </div>     
                                        <div class="flex mt-2 space-x-2" id="followers_box<?= $place->id ?>">
                                            <?= place_followers($place->id) ?>
                                        </div>
    
                                        <div class="flex mt-3 space-x-2 text-sm">
                                        <?php if(a_place_has_already_been_followed($place->id,get_session('user_id'))): ?>
                                            <a href="" class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow_place" data-place_id="<?= $place->id ?>" data-cr_i="<?= $place->creator_id ?>" data-place_name="<?= $place->place_name ?>" id="unfollow_place<?= $place->id ?>" data-action="unfollow"> 
                                            <?= $long_text['Following'][$_SESSION['locale']] ?>
                                            </a>
                                            <a href="" class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow_place" id="follow_place<?= $place->id ?>" data-cr_i="<?= $place->creator_id ?>" data-place_name="<?= $place->place_name ?>" data-place_id="<?= $place->id ?>" data-action="follow" style="display:none;"> 
                                            <?= $long_text['Follow'][$_SESSION['locale']] ?>
                                            </a>
                                        <?php else: ?>
                                            <a href="" class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow_place" id="follow_place<?= $place->id ?>" data-cr_i="<?= $place->creator_id ?>" data-place_name="<?= $place->place_name ?>" data-place_id="<?= $place->id ?>" data-action="follow"> 
                                            <?= $long_text['Follow'][$_SESSION['locale']] ?>
                                            </a>
                                             <a href="" class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow_place" data-cr_i="<?= $place->creator_id ?>" data-place_id="<?= $place->id ?>" data-place_name="<?= $place->place_name ?>" id="unfollow_place<?= $place->id ?>" data-action="unfollow" style="display:none;"> 
                                             <?= $long_text['Following'][$_SESSION['locale']] ?>
                                            </a>
                                        <?php endif; ?>
                                            <a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>" class="bg-gray-200 flex flex-1 h-8 items-center justify-center rounded-md capitalize"> 
                                            <?= $long_text['visit'][$_SESSION['locale']] ?>
                                            </a>
                                        </div>  
        
                                    </div>
                                </div>
                            </li>
                         <?php endforeach; ?>
                        </ul>

                        <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                        <a class="absolute bg-white bottom-1/2 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                    </div>
                </div>

                <div class="sm:my-6 my-3 flex items-center justify-between border-b pb-3">
                    <div>
                        <h2 class="text-xl font-semibold"> <?= $long_text['categories'][$_SESSION['locale']] ?> </h2>
                        <p class="font-medium text-gray-500 leading-6"> <?= $long_text['places_categories_desc'][$_SESSION['locale']] ?> </p>
                    </div>
                </div> 

                <div class="relative -mt-3" uk-slider="finite: true">
                
                    <div class="uk-slider-container px-1 py-3">
                        <ul class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">
                
                            <li><a href="place_category.php?keyword=sport">
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="/images/places/categories/zungvi-from-pexel-pixabay-270085.jpg" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Sport </div>
                                </div>
                                </a>
                            </li>
                            <li><a href="place_category.php?keyword=commercial">
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="/images/places/categories/zungvi-from-pexel-pixabay-264636.jpg" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Commercial </div>
                                </div></a>
                            </li>
                            <li><a href="place_category.php?keyword=artistic">
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="/images/places/categories/zungvi-from-pexel-julia-volk-7292893.jpg" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Artistic </div>
                                </div></a>
                            </li>
                            <li><a href="place_category.php?keyword=educational">
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="/images/places/categories/zungvi-from-pexel-monstera-6238120.jpg" class="absolute w-full h-full object-cover"
                                        alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Educational </div>
                                </div></a>
                            </li>
                            <li><a href="place_category.php?keyword=restaurant">
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="/images/places/categories/zungvi-from-pexel-rajesh-tp-1624487.jpg" class="absolute w-full h-full object-cover"
                                        alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Restaurant</div>
                                </div></a>
                            </li>
                            <li><a href="place_category.php?keyword=hotel">
                                <div class="rounded-md overflow-hidden relative w-full h-36">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="/images/places/categories/zungvi-pexels-pixabay-271624.jpg" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold text-lg"> Hotel </div>
                                </div></a>
                            </li>
                
                        </ul>
                    </div>
                    
                    <a class="absolute bg-white top-16 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                    <a class="absolute bg-white top-16 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                </div>

                <br>  
                
                <div class="lg:flex lg:space-x-12">

                    <div class="lg:w-3/4"> 


                        <h3 class="text-xl font-semibold" id="forums"> <?= $menu['forums'][$_SESSION['locale']] ?> </h3>
                        <nav class="responsive-nav border-b">
                            <ul>
                                <li <?= !isset($_GET['f']) ? 'class="active"' : '' ?>><a href="explorer.php#forums" class="lg:px-2"> <?= $long_text['all_forums'][$_SESSION['locale']] ?> <span> <?= $forums_nbre ?> </span> </a></li>
                                <li <?= isset($_GET['f']) ? 'class="active"' : '' ?> ><a href="explorer.php?f=recently_added#forums" class="lg:px-2"> <?= $long_text['recently_added'][$_SESSION['locale']] ?> </a></li>
                                <li><a href="forums.php?p=all_forums" class="lg:px-2"> <?= $long_text['more'][$_SESSION['locale']] ?> </a></li>
                            </ul>
                        </nav>


                        <div class="grid md:grid-cols-2 divide divide-gray-200 gap-x-4 mt-4">
                        <?php if(!isset($_GET['f'])): ?>
                        <?php foreach($forums as $forum): ?>
                            <div class="flex items-center space-x-4 py-3 hover:bg-gray-100 rounded-md -mx-2 px-2">
                                <div class="w-14 h-14 flex-shrink-0 rounded-md relative"> 
                                    <img src="<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>" class="absolute w-full h-full inset-0 rounded-md object-cover" alt="">
                                </div>
                                <div class="flex-1">
                                    <a href="forum_home.php?n=<?= $forum->forum_name ?>&fr_i=<?= $forum->id ?>"  class="text-lg font-semibold capitalize"><?= $forum->forum_name ?></a>
                                    <div class="text-sm text-gray-500 mt-0.5"> <?= forum_members_count($forum->id) ?> Member(s)</div>
                                </div>
                                <?php if(!forum_state_verification_v1(get_session('user_id'),'1',$forum->id) && !forum_state_verification_v1(get_session('user_id'),'0',$forum->id)): ?>
                                <a href="" class="flex items-center justify-center h-9 px-4 rounded-md bg-gray-200 font-semibold join_forum" data-fr_i="<?= $forum->id ?>" id="join_btn<?= $forum->id ?>"> 
                                    Join
                               </a>
                               <span style="display:none;" id="mforum<?= $forum->id ?>"> Request sent</span>
                               <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <?php foreach($recent_forums as $forum): ?>
                            <div class="flex items-center space-x-4 py-3 hover:bg-gray-100 rounded-md -mx-2 px-2">
                                <div class="w-14 h-14 flex-shrink-0 rounded-md relative"> 
                                    <img src="<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>" class="absolute w-full h-full inset-0 rounded-md object-cover" alt="">
                                </div>
                                <div class="flex-1">
                                    <a href="forum_home.php?n=<?= $forum->forum_name ?>&fr_i=<?= $forum->id ?>"  class="text-lg font-semibold capitalize"><?= $forum->forum_name ?></a>
                                    <div class="text-sm text-gray-500 mt-0.5"> <?= forum_members_count($forum->id) ?> Member(s)</div>
                                </div>
                                <?php if(!forum_state_verification_v1(get_session('user_id'),'1',$forum->id) && !forum_state_verification_v1(get_session('user_id'),'0',$forum->id)): ?>
                                <a href="" class="flex items-center justify-center h-9 px-4 rounded-md bg-gray-200 font-semibold join_forum" data-fr_i="<?= $forum->id ?>" id="join_btn<?= $forum->id ?>"> 
                                    Join
                               </a>
                               <span style="display:none;" id="mforum<?= $forum->id ?>"> Request sent</span>
                               <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <?php endif; ?>

                        </div> 
                    </div>
                    <div class="lg:w-1/4 flex-shrink-0 space-y-5"> 
                    
                        <h2 class="text-xl font-semibold mt-7"> <?= $long_text['popular_pages'][$_SESSION['locale']] ?> </h2>
                        <?php
                        //Popular events are set manually
                        $cbca_goma_ville = find_place_by_id(5); 
                        $gospel_talent_show = find_event_by_id(1);
                        
                         ?>
                        <div class="card">
                            <div class="card-media h-28">
                                <div class="card-media-overly"></div>
                                <img src="/<?= $cbca_goma_ville->coverpic ?>" alt="" class="">
                            </div>
                            <div class="card-body">
                                <a href="place_home.php?n=<?= $cbca_goma_ville->place_name ?>&pl_i=<?= $cbca_goma_ville->id ?>"  class="font-semibold text-lg truncate mb-1">   <?= $cbca_goma_ville->place_name ?> </a>
                                <div class="flex items-center space-x-1 text-sm text-gray-500 capitalize">
                                    <a href="#"> <span> <?= records_count('places_followers', 'place_id', $place->id) ?> followers </span> </a> -
                                    <a href="#"> <span> 1 post a week </span> </a>
                                </div>  
                                <div class="flex mt-3 space-x-2 text-sm">
                                    <a href="place_home.php?n=<?= $cbca_goma_ville->place_name ?>&pl_i=<?= $cbca_goma_ville->id ?>" class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize"> 
                                    <?= $long_text['visit'][$_SESSION['locale']] ?>
                                    </a>
                                </div>    
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-media h-28">
                                <div class="card-media-overly"></div>
                                <img src="/<?= $gospel_talent_show->profilepic ?>" alt="" class="">
                            </div>
                            <div class="card-body">
                                <a href="event_home.php?n=<?= $gospel_talent_show->event_name ?>&ev_i=<?= $gospel_talent_show->id ?>"  class="font-semibold text-lg truncate mb-1"> <?= $gospel_talent_show->event_name ?> </a>
                                <div class="flex items-center space-x-1 text-sm text-gray-500 capitalize">
                                    <a href="#"> <span> <?= event_followers_count($gospel_talent_show->id) ?> followers </span> - </a>
                                    <a href="#"> <span> 4 post a month </span> </a>
                                </div>  

                                <div class="flex mt-3 space-x-2 text-sm">
                                    <a href="event_home.php?n=<?= $gospel_talent_show->event_name ?>&ev_i=<?= $gospel_talent_show->id ?>" class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize"> 
                                    <?= $long_text['visit'][$_SESSION['locale']] ?>
                                    </a>
                                </div>    

                            </div>
                        </div>

                    </div>

                </div>

                <div class="my-6 flex items-center justify-between border-b pb-3" id="people">
                    <div>
                        <h2 class="text-xl font-semibold"> <?= $long_text['suggestions'][$_SESSION['locale']] ?>  </h2>
                        <p class="font-medium text-gray-500 leading-6"> <?= $long_text['friends_relatives_around'][$_SESSION['locale']] ?> </p>
                    </div>
                    <!-- <a href="#" class="text-blue-500 sm:block hidden"> See all </a> -->
                </div> 

                <div class="grid md:grid-cols-2 divide divide-gray-200 gap-x-6 gap-y-4" id="friends_suggestion">

                    

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
    <script src="js/v2/explorer.js"></script>
    <script src="js/v2/base.js"></script>

</body>
</html>
