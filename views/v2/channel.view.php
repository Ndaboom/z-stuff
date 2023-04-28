<!DOCTYPE html>
<html lang="en">
 <?php 
    
   $page = "pages";

   require('includes/functions.php');
   require('includes/adds_functions.php');
   include('partials/header1.php');

   $_SESSION['channel_id'] = $tv->id;
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
         <!-- Main Contents -->
         <div class="main_content">
            <div class="mcontainer">

                <div class="lg:flex lg:space-x-10">
                      
                    <div class="lg:w-3/4"> 
                       
                        <div class="embed-video rounded">
                            <iframe src="https://www.youtube.com/embed/<?= $tv->channel_key ?>?&autoplay=1" title="YouTube video player"
                                    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>

                        <div class="py-5 space-y-4">

                            <div>
                                <h1 class="text-2xl font-semibold line-clamp-1"> <?= $tv->channel_name ?> </h1>
                                <p> <?= $tv->views ?> views </p>
                            </div>
                            
                            <div class="md:flex items-center justify-between">
                                <a href="#" class="flex items-center space-x-3">
                                    <img src="assets/images/avatars/avatar-2.jpg" alt="" class="w-10 rounded-full">
                                    <div class="">
                                        <div class="text-base font-semibold">  </div>
                                        <div class="text-xs"> Published <?= zungvi_time_ago($tv->created_at) ?> </div>
                                    </div>
                                </a>
                                <div class="flex items-center space-x-3 md:pt-0 pt-2" id="likes_box">
                                    <div class="like-btn" data-action="like" data-channel_id="<?= $tv->id ?>" uk-tooltip="Like it">
                                        <i class="far fa-thumbs-up"></i>
                                        <span class="likes"><?= count_channel_likes($tv->id) ?></span>
                                    </div>
                                    <div class="flex h-2 w-36 bg-gray-200 rounded-lg overflow-hidden">
                                        <div class="w-2/3 bg-gradient-to-br from-purple-400 to-blue-400 h-4"></div>
                                    </div>
                                    <div class="like-btn" data-action="unlike" data-channel_id="<?= $tv->id ?>" uk-tooltip="I Unlike it">
                                        <i class="far fa-thumbs-down"></i>
                                        <span class="likes"><?= count_channel_unlikes($tv->id) ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-lg font-semibold pt-2"> Description </div>
                            <p> <?= $tv->channel_description ?></p>
                            
                            <!-- <hr>
                            <div class="text-lg font-semibold pt-2"> Comments ( 5210 )</div>


                            <div class="my-5">

                                <div class="flex gap-x-4 mb-5 relative">
                                    <img src="assets/images/avatars/avatar-4.jpg" alt="" class="rounded-full shadow w-12 h-12">
                                    <div>
                                        <h4 class="text-base m-0 font-semibold"> Stella Johnson</h4>
                                        <span class="text-gray-700 text-sm"> Student </span>
                                        <p class="mt-3">
                                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore
                                            magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                            ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex gap-x-4 mb-5 relative">
                                    <img src="assets/images/avatars/avatar-1.jpg" alt="" class="rounded-full shadow w-12 h-12">
                                    <div>
                                        <h4 class="text-base m-0 font-semibold"> Stella Johnson</h4>
                                        <span class="text-gray-700 text-sm"> Student </span>
                                        <p class="mt-3">
                                             elit, sed diam ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim ipsum dolor sit amet, consectetuer adipiscing elit, sed diam ut laoreet dolore
                                           </p>
                                    </div>
                                </div>  
                            </div> -->

                        </div>


                    </div>

                    <!-- sidebar -->
                    <div class="lg:w-1/4 w-full"> 
   
                       <h3 class="text-xl font-bold mb-2"> Related Videos </h3>

                       <div>
                            <?php foreach($tvs as $row): ?>
                                <div class="py-2 relative">
                                    <a href="channel.php?cn=<?= $row->id ?>" class="w-full h-32 overflow-hidden rounded-lg relative shadow-sm flex-shrink-0 block"> 
                                        <img src="/<?= $row->channel_image ?>" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <img src="/images/icons/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> -:-</span>
                                    </a>
                                    <div class="flex-1 pt-3 relative"> 
                                        <a href="channel.php?cn=<?= $row->id ?>" class="line-clamp-2 font-semibold"> <?= $row->channel_name ?>   </a>
                                        <div class="flex space-x-2 items-center text-sm pt-1">
                                            <div><?= zungvi_time_ago($row->created_at) ?></div>
                                            <div>·</div>
                                            <div> <?= $row->views ?> views</div>
                                        </div>
                                    </div>
                                </div> 
                            <?php endforeach; ?>
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
    <script src="js/v2/channel.js"></script>
    <script src="js/v2/base.js"></script>

</body>
</html>