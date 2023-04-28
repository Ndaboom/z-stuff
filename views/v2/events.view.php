<!DOCTYPE html>
<html lang="en">
 <?php 
   
    $title = "Events";
    $page = "events_list";

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

        <!-- Main Contents -->
        <div class="main_content">
            <div class="mcontainer">

                <div class="flex justify-between relative md:mb-4 mb-3">
                    <div class="flex-1">
                        <h2 class="text-2xl font-semibold"> Events </h2>
                        <nav class="responsive-nav border-b md:m-0 -mx-4">
                            <ul>
                                <li <?= $_GET['p'] == "" ? 'class="active" ' : ''?> ><a href="events.php" class="lg:px-2">   Suggestions </a></li>
                                <li <?= $_GET['p'] == "interested" ? 'class="active" ' : ''?>><a href="events.php?p=interested" class="lg:px-2"> Interested </a></li>
                                <li <?= $_GET['p'] == "past" ? 'class="active" ' : ''?>><a href="events.php?p=past" class="lg:px-2"> Past </a></li>
                                <li <?= $_GET['p'] == "coming" ? 'class="active" ' : ''?> ><a href="events.php?p=coming" class="lg:px-2"> Coming </a></li>
                            </ul>
                        </nav>
                    </div>
                    <a href="create-event.php" class="flex items-center justify-center h-9 lg:px-5 px-2 rounded-md bg-blue-600 text-white space-x-1.5 absolute right-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="md:block hidden"> Create </span>
                    </a> 
                </div>
               
                <div class="relative" uk-slider="finite: true">
                
                    <div class="uk-slider-container px-1 py-3">
                        <ul class="uk-slider-items uk-child-width-1-4@m uk-child-width-1-3@s uk-grid-small uk-grid">

                            <?php if(!$_GET['p']): ?>
                            <?php foreach($all_events as $event): ?>
                            <li>
                                <div class="card">
                                    <div class="card-media h-32">
                                        <div class="card-media-overly"></div>
                                        <img src="/<?= $event->profilepic ? $event->profilepic : 'images/cover.jpeg' ?>" alt="" class="">
                                        <div
                                            class="absolute bg-blue-100 font-semibold px-2.5 py-1 rounded-full text-blue-500 text-xs top-2.5 left-2.5">
                                            Upcomming</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-xs uppercase text-blue-500 font-semibold"><?= $event->organization ?></div>
                                        <a href="event_home.php?ev_i=<?= $event->id ?>&n=<?= $event->event_name ?>" class="box-title  mb-1"> <?= $event->event_name ?> </a>
                                        <div class="text-sm font-medium"><?= $event->localization ?></div>
                    
                                        <div class="flex items-center space-x-2 text-sm text-gray-500 capitalize">
                                            <div> <?= event_followers_count($event->id) ?> intersted</div>
                                            <div>·</div>
                                            <div> <?= event_followers_count($event->id) ?> going </div>
                                        </div>
                    
                                        <div class="flex mt-2 space-x-2 text-sm">
                                        <?php if(an_event_has_already_been_followed($event->id,get_session('user_id'))): ?>
                                            <a href="#"
                                                class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow" data-action="unfollow" data-event_name="<?= $event->event_name ?>" data-cr_i="<?= $event->creator_id ?>" data-event_id="<?= $event->id ?>" id="unfollow_event<?= $event->id ?>" >
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    class="w-5 mr-1.5">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                You're Following
                                            </a>
                                            
                                             <a href="#"
                                                class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow" data-action="follow" data-cr_i="<?= $event->creator_id ?>" data-event_name="<?= $event->event_name ?>" data-event_id="<?= $event->id ?>" id="follow_event<?= $event->id ?>" style="display:none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    class="w-5 mr-1.5">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                               Follow
                                            </a>
                                         <?php else: ?>
                                         <a href="#"
                                                class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow" id="follow_event<?= $event->id ?>" data-cr_i="<?= $event->creator_id ?>" data-event_name="<?= $event->event_name ?>" data-action="follow" data-event_id="<?= $event->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    class="w-5 mr-1.5">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                Follow
                                            </a>
                                             <a href="#"
                                                class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow" style="display:none;" data-cr_i="<?= $event->creator_id ?>" id="unfollow_event<?= $event->id ?>" data-event_name="<?= $event->event_name ?>" data-action="unfollow" data-event_id="<?= $event->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    class="w-5 mr-1.5">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                You're Following
                                            </a>
                                         <?php endif; ?>
                                            <a class="bg-gray-200 flex h-8 items-center px-3 rounded-md share-btn" data-event_url="https://www.zungvi.com/event_home.php?n=<?= $event->event_name ?>&ev_i=<?= $event->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" class="w-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                            <?php elseif($_GET['p'] == "interested"): ?>
                            
                            <?php foreach($all_events as $event): ?>
                                <?php if(an_event_has_already_been_followed($event->id,get_session('user_id'))): ?>
                            <li>
                                <div class="card">
                                    <div class="card-media h-32">
                                        <div class="card-media-overly"></div>
                                        <img src="/<?= $event->profilepic ?>" alt="" class="">
                                        <div
                                            class="absolute bg-blue-100 font-semibold px-2.5 py-1 rounded-full text-blue-500 text-xs top-2.5 left-2.5">
                                            Upcomming</div>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-xs uppercase text-blue-500 font-semibold"><?= $event->organization ?></div>
                                        <a href="event_home.php?ev_i=<?= $event->id ?>&n=<?= $event->event_name ?>" class="box-title  mb-1"> <?= $event->event_name ?> </a>
                                        <div class="text-sm font-medium"><?= $event->localization ?></div>
                    
                                        <div class="flex items-center space-x-2 text-sm text-gray-500 capitalize">
                                            <div> <?= event_followers_count($event->id) ?> intersted</div>
                                            <div>·</div>
                                            <div> <?= event_followers_count($event->id) ?> going </div>
                                        </div>
                    
                                        <div class="flex mt-2 space-x-2 text-sm">
                                        <?php if(an_event_has_already_been_followed($event->id,get_session('user_id'))): ?>
                                            <a href="#"
                                                class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow" data-action="unfollow" data-event_name="<?= $event->event_name ?>" data-cr_i="<?= $event->creator_id ?>" data-event_id="<?= $event->id ?>" id="unfollow_event<?= $event->id ?>" >
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    class="w-5 mr-1.5">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                You're Following
                                            </a>
                                            
                                             <a href="#"
                                                class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow" data-action="follow" data-cr_i="<?= $event->creator_id ?>" data-event_name="<?= $event->event_name ?>" data-event_id="<?= $event->id ?>" id="follow_event<?= $event->id ?>" style="display:none;">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    class="w-5 mr-1.5">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                               Follow
                                            </a>
                                         <?php else: ?>
                                         <a href="#"
                                                class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow" id="follow_event<?= $event->id ?>" data-cr_i="<?= $event->creator_id ?>" data-event_name="<?= $event->event_name ?>" data-action="follow" data-event_id="<?= $event->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    class="w-5 mr-1.5">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                Follow
                                            </a>
                                             <a href="#"
                                                class="bg-blue-600 flex flex-1 h-8 items-center justify-center rounded-md text-white capitalize follow" style="display:none;" data-cr_i="<?= $event->creator_id ?>" id="unfollow_event<?= $event->id ?>" data-event_name="<?= $event->event_name ?>" data-action="unfollow" data-event_id="<?= $event->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                                    class="w-5 mr-1.5">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                    </path>
                                                </svg>
                                                You're Following
                                            </a>
                                         <?php endif; ?>
                                            <a class="bg-gray-200 flex h-8 items-center px-3 rounded-md share-btn" data-event_url="https://www.zungvi.com/event_home.php?n=<?= $event->event_name ?>&ev_i=<?= $event->id ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" class="w-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                             <?php endif; ?>
                            <?php endforeach; ?>
                            
                            <?php endif; ?>
                        </ul>

                        <a class="absolute bg-white top-16 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                        <a class="absolute bg-white top-16 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white" href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>

                    </div>
                </div>
            
                <br>
            
                <div class="my-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold"> Places </h2>
                    </div>
                    <a href="explorer.php" class="text-blue-500"> See all </a>
                </div>
            
                <div class="relative" uk-slider="finite: true">
                
                    <div class="uk-slider-container px-1 py-3">
                
                        <ul class="uk-slider-items uk-child-width-1-5@m uk-child-width-1-4@s uk-child-width-1-2 uk-grid-small uk-grid">
                        <?php foreach($places as $place): ?>
                            <li>
                                <div class="rounded-xl overflow-hidden relative w-full h-44 cursor-pointer transform hover:scale-105 duration-300 hover:shadow-md">
                                    <div class="absolute w-full h-3/4 -bottom-12 bg-gradient-to-b from-transparent to-gray-800 z-10">
                                    </div>
                                    <img src="<?= $place->coverpic ? $place->coverpic : 'images/cover.jpeg' ?>" class="absolute w-full h-full object-cover" alt="">
                                    <div class="absolute bottom-0 w-full p-3 text-white z-20 font-semibold">
                                        <div class="text-sm"> <?= $place->place_name ?></div>
                                        <div class="text-xl"> <?= $place->category ?> </div>
                                    </div>
                                </div>
                            </li>
                         <?php endforeach; ?>
                  
                        </ul>
                        <a class="absolute bg-white top-20 -mt-2 flex items-center justify-center p-2 -left-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                            href="#" uk-slider-item="previous"> <i class="icon-feather-chevron-left"></i></a>
                        <a class="absolute bg-white top-20 -mt-2 flex items-center justify-center p-2 -right-4 rounded-full shadow-md text-xl w-9 z-10 dark:bg-gray-800 dark:text-white"
                            href="#" uk-slider-item="next"> <i class="icon-feather-chevron-right"></i></a>
                    </div>
                </div>

                <br>
        
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

</body>
</html>
