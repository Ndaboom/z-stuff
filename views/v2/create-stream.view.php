<!DOCTYPE html>
<html lang="en">
 <?php 
    
    $title = "Create Stream";
    $page = "pages";

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

                <!--  breadcrumb -->
                <div class="breadcrumb-area py-0">
                    <div class="breadcrumb">
                        <ul class="m-0">
                            <li>
                                <a href="online_tv.php">TV</a>
                            </li>
                            <li class="active">
                                <a href="#">Add Stream </a>
                            </li>
                        </ul>
                    </div>
                </div>


                <!-- create page-->
                <div class="max-w-2xl m-auto shadow-md rounded-md bg-white lg:mt-20">  
 
                    <!-- form header -->
                    <div class="text-center border-b border-gray-100 py-6">
                        <h3 class="font-bold text-xl"> Add new stream </h3>
                        <?php include('partials/_error.php');?>
                    </div>

                    <!-- form body -->
                <form method="post">
                    <div class="p-10 space-y-7">

                        <div class="line">
                            <input class="line__input" id="" name="channel_name" type="text" onkeyup="this.setAttribute('value', this.value);" value="" autocomplete="off">
                            <span for="channel_name" class="line__placeholder"> Stream name </span>
                        </div>
                        <div class="flex items-center">
                            <div class="-mr-1 bg-gray-100 border px-3 py-3 rounded-l-md">https://www.youtube.com/</div>
                            <input type="text" name="channel_key" class="with-border" placeholder="Stream key e.g: watch?v=HIPNVm6lNfM">
                        </div>
                        <div class="line h-32"> 
                            <textarea class="line__input h-32"  id="" name="channel_description" type="text" onkeyup="this.setAttribute('value', this.value);" value="" autocomplete="off"></textarea>
                            <span for="channel_description" class="line__placeholder"> Page description </span> 
                        </div>
                        
                    </div>

                    <!-- form footer -->
                    <div class="border-t flex justify-between lg:space-x-10 p-7 bg-gray-50 rounded-b-md">
                        <p class="text-sm leading-6"> You can add images and other details after you create the stream. </p>
                        <button type="submit" name="insert-stream" class="button lg:w-1/2">
                            Create Now
                        </button>
                    </div> 
                </form>
                    
                </div>

        
            </div>
        </div>
        
    </div>
    
    <div id="offcanvas-chat" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar bg-white p-0 w-full lg:w-80">
    
    
            <div class="relative pt-5 px-4">
    
                <h3 class="text-2xl font-bold mb-2"> Chats </h3>
    
                <div class="absolute right-3 top-4 flex items-center">
    
                    <button class="uk-offcanvas-close  px-2 -mt-1 relative rounded-full inset-0 lg:hidden blcok"
                        type="button" uk-close></button>
    
                    <a href="#" uk-toggle="target: #search;animation: uk-animation-slide-top-small">
                        <ion-icon name="search" class="text-2xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
                    <a href="#">
                        <ion-icon name="cog" class="text-2xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
                    <a href="#">
                        <ion-icon name="ellipsis-vertical" class="text-2xl hover:bg-gray-100 p-1 rounded-full"></ion-icon>
                    </a>
    
                </div>
    
    
            </div>
    
            <div class="absolute bg-white z-10 w-full -mt-5 lg:mt-0 transform translate-y-1.5 py-2 border-b items-center flex"
                id="search" hidden>
                <input type="text" placeholder="Search.." class="flex-1">
                <ion-icon name="close-outline" class="text-2xl hover:bg-gray-100 p-1 rounded-full mr-4 cursor-pointer"
                    uk-toggle="target: #search;animation: uk-animation-slide-top-small"></ion-icon>
            </div>
    
            <nav class="cd-secondary-nav border-b extanded mb-2">
                <ul uk-switcher="connect: #chats-tab; animation: uk-animation-fade">
                    <li class="uk-active"><a class="active" href="#0"> Friends </a></li>
                    <li><a href="#0">Groups <span> 10 </span> </a></li>
                </ul>
            </nav>
    
            <div class="contact-list px-2 uk-switcher" id="chats-tab">
    
                <div>
    
                    <a href="timeline.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-1.jpg" alt="">
                            <span class="user_status status_online"></span>
                        </div>
                        <div class="contact-username"> Dennis Han</div>
                    </a>
                    <a href="timeline.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-2.jpg" alt="">
                            <span class="user_status"></span>
                        </div>
                        <div class="contact-username"> Erica Jones</div>
                    </a>
                    <a href="timeline.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-3.jpg" alt="">
    
                        </div>
                        <div class="contact-username">Stella Johnson</div>
                    </a>
                    <a href="timeline.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-4.jpg" alt="">
    
                        </div>
                        <div class="contact-username"> Alex Dolgove</div>
                    </a>
    
                </div>
                <div>
    
                    <a href="timeline.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-1.jpg" alt="">
                            <span class="user_status status_online"></span>
                        </div>
                        <div class="contact-username"> Dennis Han</div>
                    </a>
                    <a href="timeline.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-2.jpg" alt="">
                            <span class="user_status"></span>
                        </div>
                        <div class="contact-username"> Erica Jones</div>
                    </a>
                    <a href="timeline.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-3.jpg" alt="">
    
                        </div>
                        <div class="contact-username">Stella Johnson</div>
                    </a>
                    <a href="timeline.html">
                        <div class="contact-avatar">
                            <img src="assets/images/avatars/avatar-4.jpg" alt="">
    
                        </div>
                        <div class="contact-username"> Alex Dolgove</div>
                    </a>
    
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

</body>
</html>
