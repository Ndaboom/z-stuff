<!DOCTYPE html>
<html lang="en">
 <?php 
   
    $title = "Forums";
    $page = "forums_list";

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

                <div class="flex space-x-12">
                    
                    <div class="w-2/3 flex-shirink-0">
                    
                        <div class="flex justify-between relative md:mb-4 mb-3">
                            <div class="flex-1">
                                <h2 class="text-3xl font-semibold"> Forums </h2>
                                <nav class="cd-secondary-nav border-b md:m-0 -mx-4">
                                    <ul>
                                    <li <?= $_GET['p'] == "" ? 'class="active" ' : ''?>><a href="forums.php?p=all_forums" class="lg:px-2"> All forums  </a></li>
                                    <li <?= $_GET['p'] == "im_forums" ? 'class="active" ' : ''?>><a href="forums.php?p=im_forums" class="lg:px-2"> Forums you are in </a></li>
                                    <li <?= $_GET['p'] == "i_forums" ? 'class="active" ' : ''?>><a href="forums.php?p=i_forums" class="lg:px-2"> Your forums </a></li>
                                    </ul>
                                </nav>
                            </div>
                             <a href="create-forum.php" class="flex items-center justify-center h-9 lg:px-5 px-2 rounded-md bg-blue-600 text-white space-x-1.5 absolute right-0">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="md:block hidden"> Create </span>
                        </a>
                        </div>
                        <?php if($_GET['p'] == "" || $_GET['p'] == "im_forums"): ?>
                        <?php $thisForum = getUserForumsData(); 
                             if(count($thisForum)!= 0): ?>
                            <ul class="space-y-6">
                                        <?php foreach($thisForum as $tforum): ?>
                                <li>
                                    <a href="forum_home.php?n=<?= $tforum->forum_name ?>&fr_i=<?= $tforum->id ?>">
                                        <div class="flex items-start pl-3 space-x-4">
                                            <img src="/<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>" alt="" class="w-16 h-16 rounded-full">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold line-clamp-1"><?= $tforum->forum_name ?></h3>
                                                <p class="text-sm text-gray-400 mb-2"> Member(s): <span data-href="%40tag-dev.html"><?= forum_members_count($tforum->id) ?></span> - Created <?= zungvi_time_ago($tforum->created_at) ?></span> </p>
                                                <p class="leading-6 line-clamp-2"><?= substr($tforum->description, 0, 143) ?></p>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <ion-icon name="chatbubbles" class="text-3xl"></ion-icon>
                                                <span class="text-xl"> <?= forum_subject_count($tforum->id); ?> </span>
                                            </div>
                                        </div>
                                    </a>
                                </li>  
                                        <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php elseif($_GET['p'] == "i_forums"): ?>
                          <?php if(count($iamadmin) != 0): ?>
                            <ul class="space-y-6">
                            <?php foreach($iamadmin as $tforum): ?>
                                <li>
                                    <a href="forum_home.php?n=<?= $tforum->forum_name ?>&fr_i=<?= $tforum->id ?>">
                                        <div class="flex items-start pl-3 space-x-4">
                                            <img src="/<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>" alt="" class="w-16 h-16 rounded-full">
                                            <div class="flex-1">
                                                <h3 class="text-lg font-semibold line-clamp-1"><?= $tforum->forum_name ?></h3>
                                                <p class="text-sm text-gray-400 mb-2"> Member(s): <span data-href="%40tag-dev.html"><?= forum_members_count($tforum->id) ?></span> - Created <?= zungvi_time_ago($tforum->created_at) ?></span> </p>
                                                <p class="leading-6 line-clamp-2"><?= substr($tforum->description, 0, 143) ?></p>
                                            </div>
                                            <div class="flex items-center space-x-4">
                                                <ion-icon name="chatbubbles" class="text-3xl"></ion-icon>
                                                <span class="text-xl"> <?= forum_subject_count($tforum->id); ?> </span>
                                            </div>
                                        </div>
                                    </a>
                                </li>  
                            <?php endforeach; ?>
                            </ul>
                          <?php endif; ?>
                          <?php elseif($_GET['p'] == "all_forums"): ?>
                          <?php if(count($forums) != 0): ?>
                            <div class="widget border-t pt-4">
                            <?php foreach($forums as $tforum): ?>
                            <div>
                              <div class="flex items-center space-x-4 hover:bg-gray-100 rounded-md -mx-2 p-2">
                                  <div class="w-14 h-14 flex-shrink-0 rounded-md relative"> 
                                      <img src="<?= $tforum->forum_pic != '' ? $tforum->forum_pic : 'images/portada_7.png' ?>" class="absolute w-full h-full inset-0 rounded-md" alt="">
                                  </div>
                                  <div class="flex-1">
                                      <h3 class="text-lg font-semibold capitalize"> <?= $tforum->forum_name ?> </h3>
                                      <div class="text-sm text-gray-500 -mt-0.5"> <?= forum_members_count($tforum->id) ?> Member<?= forum_members_count($tforum->id) > 1 ? 's' : '' ?></div>
                                  </div>
                                  <a href="forum_home.php?n=<?= $tforum->forum_name ?>&fr_i=<?= $tforum->id ?>" class="flex items-center justify-center h-9 px-4 rounded-md bg-gray-200 font-semibold">  Join </a>
                                  <small class="text-blue-600" style="display:none;" id="confirmation_btn<?= $forum->id ?>"> Request sent</small>
                              </div>
                          </div> 
                            <?php endforeach; ?>
                            </div>
                          <?php endif; ?>
                        <?php endif; ?>       
  
                      <br> <br>
                      <hr>
                      <br>
  
                      <br>
                      <br> <br> <br> <br>
                    </div>
  
                    <div class="w-1/3 pt-5">
  
                        <div uk-sticky="offset:100">
  
                          <h2 class="text-2xl font-semibold mb-2"> Top Contributors </h2>
                          <p> People who started the most discussions on Talks. </p>
                          <br>
  
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
    <script src="js/v2/timeline.js"></script>
    <script src="js/v2/base.js"></script>

</body>
</html>
