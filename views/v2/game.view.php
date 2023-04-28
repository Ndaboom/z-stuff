<!DOCTYPE html>
<html lang="en">
 <?php  
   $page = "games";
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
         <!-- Main Contents -->
         <div class="main_content">
            <div class="mcontainer">
                <div class="lg:flex lg:space-x-10">   
                    <div class="lg:w-3/4">   
                        <div class="embed-video rounded">
                            <?= $game->game_embed ?>
                        </div>
                        <div class="py-5 space-y-4">
                            <div>
                                <h1 class="text-2xl font-semibold line-clamp-1"> <?= $game->game_name ?> </h1>
                                <div class="row">
                                    <div class="col-md-6">
                                    <p> <?= $game->plays ?> plays </p>
                                    </div>
                                    <div class="col-md-6">
                                    <a href="#url" onclick="setFullScreen()" style="float: right;">Full screen</a>
                                    </div>
                                </div>   
                            </div>
                            <div class="text-lg font-semibold pt-2"> Description </div>
                            <p> <?= $game->game_description ?></p>
                            <hr>
                            <h3 class="mb-8 mt-20 font-semibold text-xl"> Add your comment </h3>
                            <form method="post" enctype="multipart/form-data" id="upload_form">
                            <div class="flex space-x-4 mb-5 relative w-full">
                                <img src="/<?= $user2->profilepic ?>" alt="" class="rounded-full shadow w-12 h-12">
                                <div class="flex-1">
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div class="col-span-2">
                                            <input type="text" placeholder="user_name" id="comment_owner" value="<?= $user->name ?>.<?= $user->nom2 ?>" class="bg-gradient-to-b from-gray-100 to-gray-100">
                                        </div>
                                        <div class="col-span-2">
                                            <textarea name="comment_content" id="comment_content" cols="30" rows="3"  class="bg-gradient-to-b from-gray-100 to-gray-100"></textarea>
                                            <a class="relative">
                                            <img id="image_box" style="width:100px;height:100px;display:none;" />
                                            </a>
                                        </div>
                                        <div class="col-span-2 flex justify-between py-4">
                                            <input type="file" id="image" name="image" class="m-0 text-gray-600" onchange="displayImage(this)" style="display: none;"/>
                                            <svg class="bg-blue-100 h-9 p-1.5 rounded-full text-blue-600 w-9 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" onclick="photoTrigger()" id="image_trigger">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <input type="submit" class="upload_comment" value="Post">
                                        </div>
                                        <!-- Progression bar -->
                                        <progress id="progressBar" value="0" max="100" style="display:none;"></progress>
                                        <h5 id="status" style="display:none;"></h5>
                                        <p id="loaded_n_total" style="display:none;"></p>
                                        <!-- Progression bar -->
                                    </div>
                                </div>
                            </div>
                            </form>
                            <div class="text-lg font-semibold pt-2"> Comments ( <?= count($comments) ?> )</div>
                            <div class="my-5" id="comments_box">
                                 <!-- Add comment -->
                                
                            </div>
                        </div>
                    </div>
                    <!-- sidebar -->
                    <div class="lg:w-1/4 w-full"> 
                       <h3 class="text-xl font-bold mb-2"> Related Games </h3>
                       <div>
                            <?php foreach($games as $row): ?>
                                <div class="py-2 relative">
                                    <a href="game.php?g_i=<?= $row->id ?>" class="w-full h-32 overflow-hidden rounded-lg relative shadow-sm flex-shrink-0 block"> 
                                        <video src="/<?= $row->game_cover ?>" alt="" class="w-full h-full absolute inset-0 object-cover">
                                        <img src="/images/icons/icon-play.svg" class="w-12 h-12 uk-position-center" alt="">
                                        <span class="absolute bg-black bg-opacity-60 bottom-1 font-semibold px-1.5 py-0.5 right-1 rounded text-white text-xs"> -:-</span>
                                    </a>
                                    <div class="flex-1 pt-3 relative"> 
                                        <a href="game.php?g_i=<?= $row->id ?>" class="line-clamp-2 font-semibold"> <?= $row->game_name ?>   </a>
                                        <div class="flex space-x-2 items-center text-sm pt-1">
                                            <div><?= zungvi_time_ago($row->created_at) ?></div>
                                            <div>·</div>
                                            <div> <?= $row->plays ?> plays</div>
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
    <script src="js/v2/game.js"></script>
    <script src="js/v2/base.js"></script>

    <script>
        function photoTrigger(){
            document.querySelector('#image').click();
        }

        function displayImage(e){
            if(e.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    document.querySelector('#image_box').setAttribute('src', e.target.result);
                    $("#image_box").show();
                }
                reader.readAsDataURL(e.files[0]);
            }
        }

        function setFullScreen(e){
            if (
                document.fullscreenElement ||
                document.webkitFullscreenElement ||
                document.mozFullScreenElement ||
                document.msFullscreenElement
            ) {
                if (document.exitFullscreen) {
                document.exitFullscreen();
                } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
                } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
                }
            } else {
                element = $('#game_screen').get(0);
                if (element.requestFullscreen) {
                element.requestFullscreen();
                } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
                } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen();
                }
            }
        }
    </script>

</body>
</html>
