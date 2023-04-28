<!DOCTYPE html>
<html lang="en">
 <?php 

    $title= $_GET['n'];
    $page = "pages";
   
    $_SESSION['cr_i'] = $place->creator_id;
    $_SESSION['pl_i'] = $place->id;
    $_SESSION['pl_n'] = $place->place_name;

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
                <div class="profile is_page">
                    <div class="profiles_banner">
                        <img src="/<?= $place->coverpic ? $place->coverpic : "images/cover.jpeg"?>" alt="">
                    </div>
                    <div class="profiles_content">
                        <div class="profile_avatar">
                            <div class="profile_avatar_holder"> 
                                <img src="/<?= $place->image ? $place->image : "images/cover.jpeg"?>" alt="">
                            </div>
                            <div class="icon_change_photo" hidden> <ion-icon name="camera" class="text-xl"></ion-icon> </div>
                        </div>
                        <div class="profile_info">
                            <h1> <?= $place->place_name ?> </h1>
                            <p> <?= $place->category ?> ·  <span id="followers"><?= followers_count() ?></span> follower(s)</p>
                        </div>
                        <div class="flex items-center space-x-4">
                        <?= place_followers_2($place->id) ?>
                        </div>
                        <?php if(a_place_has_already_been_followed(get_session('pl_i'),get_session('user_id'))): ?>
                        <a href="#" class="flex items-center justify-center h-9 px-5 rounded-md bg-blue-600 text-white  space-x-1.5 follow" id="uninterested_btn" data-action="unfollow" data-place_id="<?= $place->id ?>" data-place_name="<?= $place->place_name ?>">
                            <ion-icon name="theventumbs-down"></ion-icon>
                            <span> You are following <i class="far fa-check-circle"></i></span>
                        </a>
                        <a href="#" class="flex items-center justify-center h-9 px-5 rounded-md bg-blue-600 text-white  space-x-1.5 follow" id="interested_btn" data-action="follow" data-place_id="<?= $place->id ?>" data-place_name="<?= $place->place_name ?>" style="display:none;color:white;">
                                <ion-icon name="thumbs-down"></ion-icon>
                                <span> Follow </span>
                        </a>
                        <?php else: ?>
                        <a href="#" class="flex items-center justify-center h-9 px-5 rounded-md bg-blue-600 text-white  space-x-1.5 follow" id="interested_btn" data-action="follow" data-place_id="<?= $place->id ?>" data-place_name="<?= $place->place_name ?>">
                                <ion-icon name="thumbs-up"></ion-icon>
                                <span> Follow </span>
                        </a>
                        <a href="#" class="flex items-center justify-center h-9 px-5 rounded-md bg-blue-600 text-white  space-x-1.5 follow" id="uninterested_btn" data-action="unfollow" data-place_id="<?= $place->id ?>" data-place_name="<?= $place->place_name ?>" style="display:none;">
                                <ion-icon name="thumbs-down"></ion-icon>
                                <span> You are following <i class="far fa-check-circle"></i></span>
                            </a>
                        <?php endif; ?>
                        </div>
                    </div>
                    <nav class="responsive-nav border-t -mb-0.5 lg:pl-2">
                        <ul>
                            <li <?= $_GET['p'] == "" ? 'class="active" ' : ''?>><a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>"> Home</a></li>
                            <li <?= $_GET['p'] == "posts" ? 'class="active" ' : ''?> ><a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>&p=posts">Posts</a></li>
                            <li <?= $_GET['p'] == "reviews" ? 'class="active" ' : ''?>><a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>&p=reviews">Reviews</a></li>
                            <?php if($place->creator_id == $_SESSION['user_id']): ?>
                            <li <?= $_GET['p'] == "settings" ? 'class="active" ' : ''?>><a href="place_home.php?n=<?= $place->place_name ?>&pl_i=<?= $place->id ?>&p=settings">Settings</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>    
               <!-- Content here --> 
               <?php if($_GET['p'] == "settings"): ?>
                        <?php if(get_session('user_id') == $place->creator_id): ?>
                            <div class="bg-white divide-x flex lg:shadow-md rounded-md shadow lg:rounded-xl overflow-hidden">
                                <div class="w-1/3">
                                        <nav class="responsive-nav setting-nav setting-menu"
                                            uk-sticky="top:30 ; offset:80 ; media:@m ;bottom:true; animation: uk-animation-slide-top">
                                            <h4 class="mb-0 p-3 uk-visible@m hidden"> Setting Navigation </h4>
                                            <ul>
                                                <li <?= $_GET['sp'] == "general" ? 'class="uk-active" ' : ''?>><a href="place_home.php?pl_i=<?= $place->id ?>&n=<?= $place->place_name ?>&p=settings&sp=general">
                                    General
                                    </a></li>
                                            </ul>
                                        </nav>
                                </div>
                                <div class="w-2/3">
                                <div class="profile is_page">

                                    <div class="profiles_banner">
                                        <img src="/<?= $place->coverpic ? $place->coverpic : "images/cover.jpeg"?>" id="coverDisplay" onclick="coverTrigger()" alt="">
                                    </div>
                                    <div class="profiles_content">
                                        <div class="profile_avatar">
                                            <div class="profile_avatar_holder"> 
                                                <img src="/<?= $place->image ? $place->image : "images/cover.jpeg"?>" id="profileDisplay" onclick="profileTrigger()" alt="">
                                            </div>
                                        </div>
                                        <div class="profile_info">
                                            <h1> <?= $place->place_name ?> </h1>
                                            <p> <?= $place->category ?> ·  <?= followers_count() ?> follower(s)</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-between md:h-full">

                                    <div class="p-5">
                                        <h3 class="font-bold text-lg">General</h3>
                                        <p class="text-sm"> General settings for your page. </p>
                                    </div>

                                        <form method="post" autocomplete="off" enctype="multipart/form-data">
                                        <div class="py-8 px-20 flex-1 space-y-4">

                                            <div class="line">
                                                <input class="line__input" id="place_name" autocomplete="off" name="place_name" type="text" onkeyup="this.setAttribute('value', this.value);" value="<?= $place->place_name ?>" required>
                                                <span for="place_name" class="line__placeholder"> Place Name   </span>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3 lg">
                                                <div>
                                                    <label for="city"> City</label>
                                                    <input type="text" name="city" value="<?= get_input('city') ? get_input('city') : e($place->city)?>" placeholder="City" class="shadow-none with-border">
                                                </div>
                                                <div>
                                                    <label for=""> Country</label>
                                                    <input type="text" name="country" value="<?= get_input('country') ? get_input('country') : e($place->country)?>" placeholder="Country" class="shadow-none with-border">
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3 lg">
                                                <div>
                                                    <label for="email"> Email</label>
                                                    <input type="text" name="email" value="<?= get_input('email') ? get_input('email') : e($place->email)?>" placeholder="Email" class="shadow-none with-border">
                                                </div>
                                                <div>
                                                    <label for="number"> Phone number</label>
                                                    <input type="text" name="number" value="<?= get_input('place_contacts') ? get_input('place_contacts') : e($place->place_contacts)?>" placeholder="Phone number" class="shadow-none with-border">
                                                </div>
                                            </div>

                                            <div class="line">
                                                <input class="line__input" id="website" autocomplete="off" name="website" type="text" onkeyup="this.setAttribute('value', this.value);" value="<?= $place->website ?>">
                                                <span for="website" class="line__placeholder">Website </span>
                                            </div>

                                            <div class="grid grid-cols-2 gap-3 lg" style="display:none;">
                                                <div>
                                                <input type="file" name="profile_pic" id="profile_pic" onchange="displayPlaceProfile(this)">
                                                </div>
                                                <div>
                                                <input type="file" name="cover_pic" id="cover_pic" onchange="displayPlaceCover(this)">
                                                </div>
                                            </div>

                                            <div>
                                                <label for="category"> Category </label>
                                                <select id="caategory" name="category"  class="shadow-none selectpicker with-border ">
                                                    <option value="Residence" <?= $place->category == "Residence" ? "selected" : ""?>>
                                                    Residential place
                                                    </option >
                                                    <option value="commercial" <?= $place->category == "commercial" ? "selected" : ""?>>
                                                    Commercial place
                                                    </option >
                                                    <option value="sport" <?= $place->category == "sport" ? "selected" : ""?>>
                                                    Sportive place
                                                    </option >
                                                    <option value="touristic" <?= $place->category == "touristic" ? "selected" : ""?>>
                                                    Touristic place
                                                    </option >
                                                    <option value="educative" <?= $place->category == "educative" ? "selected" : ""?>>
                                                    Educative place
                                                    </option >
                                                    <option value="Hotel" <?= $place->category == "Hotel" ? "selected" : ""?>>
                                                    Place, Hotel
                                                    </option >
                                                    <option value="Restaurant" <?= $place->category == "Restaurant" ? "selected" : ""?>>
                                                    Place, Restaurant
                                                    </option >
                                                    <option value="Commercial,Industrial" <?= $place->category == "Commercial,Industrial" ? "selected" : ""?>>
                                                    Place, Commercial & Industrial
                                                    </option>
                                                    <option value="Social" <?= $place->category == "Social" ? "selected" : ""?>>
                                                    Social place
                                                    </option>
                                                    <option value="Others" <?= $place->category == "Others" ? "selected" : ""?>>
                                                    Others
                                                    </option >
                                                </select>
                                            </div>

                                            <div class="line h-32">
                                                <textarea class="line__input h-32"  autocomplete="off"  type="text" name="description" id="description" onkeyup="this.setAttribute('value', this.value);" value=""><?= get_input('description') ? get_input('description') :e($place->description)?></textarea>
                                                <span for="description" class="line__placeholder">Short description </span>
                                            </div> 

                                        </div>

                                        <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                                        <a type="button" href="" class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </a>
                                            <button type="submit" class="button bg-blue-700" name="update_info"> Save </button>
                                        </div>
                                        </form>

                                    </div>

                                </div>
                                </div>
                                <script>
                                    function triggerClick(){
                                        document.querySelector('#profile_pic').click();
                                    }

                                    function displayImage(e){
                                        if(e.files[0]){
                                            var reader = new FileReader();
                                            reader.onload = function(e){
                                                document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
                                            }
                                            reader.readAsDataURL(e.files[0]);
                                        }
                                    }

                                    function triggerClick1(){
                                        document.querySelector('#cover_pic').click();
                                    }

                                    function displayImage1(e){
                                        if(e.files[0]){
                                            var reader = new FileReader();
                                            reader.onload = function(e){
                                                document.querySelector('#coverDisplay').setAttribute('src', e.target.result);
                                            }
                                            reader.readAsDataURL(e.files[0]);
                                        }
                                    }
                                </script>
                            </div>
                        <?php endif; ?>
                       
                <?php elseif($_GET['p'] == "" || $_GET['p'] == "home"): ?>
                <div class="md:flex  md:space-x-8 lg:mx-14">
                    <div class="space-y-5 flex-shrink-0 md:w-7/12">
                        <div class="card p-5">

                            <h1 class="block text-lg font-bold"> Details  </h1>

                            <div class="space-y-4 mt-3">
                                
                                <div class="line-clamp-3" id="more-text">
                                    <?= replace_links(e($place->description)) ?> 
                                </div>
                                <a href="#" id="more-text" uk-toggle="target: #more-text ; cls: line-clamp-3"> See more </a> 
                                <?php if(a_place_has_already_been_followed($place->id,get_session('user_id'))): ?>
                                <div class="flex items-center space-x-3">
                                    <ion-icon name="people" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                                    <div class="flex-1">
                                        <?php if(is_him_going($event->id, get_session('user_id'), $event->start_date)): ?>
                                        <div class="font-semibold"> You and <?= followers_count($place->id) ?> other(s) </div>
                                        <?php else: ?>
                                        <div class="font-semibold"> <?= followers_count($place->id) ?> are following </div>
                                        <?php endif; ?>
                                    </div>
                                </div> 
                                <?php endif; ?>
                                <?php if($place->website != ""): ?>
                                <div class="flex items-center space-x-3">
                                    <ion-icon name="globe" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                                    <div class="flex-1">
                                        <div> Web Site: <a href="#" class="text-blue-500"> <?= $place->website ?> </a> </div> 
                                    </div>
                                </div>
                                <?php endif; ?>
            
                                <div class="flex items-center space-x-3">
                                    <ion-icon name="mail-open" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                                    <div class="flex-1">
                                        <div> Public  · Anyone on or off Zungvi </div> 
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <ion-icon name="albums" class="bg-gray-100 p-1.5 rounded-full text-xl"></ion-icon>
                                    <div class="flex-1">
                                        <div>  <a href="#" class="text-blue-500"> <?= $place->category ?> </a> </div> 
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php elseif($_GET['p'] == "posts"): ?>
            <?php if(!$_GET['p_i']): ?>
                <div class="md:flex  md:space-x-8 lg:mx-14">
                    <div class="space-y-5 flex-shrink-0 md:w-7/12">
                        <?php if(get_session('user_id') == $place->creator_id): ?>
                        <!-- Modal launcher --> 
                        <div class="card lg:mx-0 p-4" uk-toggle="target: #create-post-modal">
                            <div class="flex space-x-3">
                                <img src="<?= $place->image ? $place->image : "image/cover.jpeg" ?>" class="w-10 h-10 rounded-full">
                                <input placeholder="New stuff here? <?= $place->place_name ?>!" class="bg-gray-100 hover:bg-gray-200 flex-1 h-10 px-6 rounded-full"> 
                            </div>
                            <div class="grid grid-flow-col pt-3 -mx-1 -mb-1 font-semibold text-sm">
                                <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                <svg class="h-5 pr-1 rounded-full text-blue-500 w-6 fill-current" data-tippy-placement="top" title="Tooltip" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Photo/Video 
                                </div>
                                <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer" uk-toggle="target: #create-product-modal">                                                        
                                <svg  class="h-5 pr-1 rounded-full text-blue-500 w-6 fill-current" data-tippy-placement="top" title="Share a product" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                Products
                                </div>
                                <div class="hover:bg-gray-100 flex items-center p-1.5 rounded-md cursor-pointer"> 
                                <svg class="h-5 pr-1 rounded-full text-red-500 w-6 fill-current" id="veiw-more" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="false" style=""> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Live
                                </div>
                            </div> 
                        </div>
                        <!-- End Modal launcher -->
                        <?php endif; ?>
                        <div id="post_list">
    
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="md:flex  md:space-x-8 lg:mx-14">
                    <div class="space-y-5 flex-shrink-0 md:w-7/12">
                        <div id="selected_post">

                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php endif; ?>
                                    
                                </div>
               
               <!-- Content here -->

            </div>
        </div>
        
    </div>
    
    <?php if(get_session('user_id') == $place->creator_id): ?>
     <!-- Create post modal -->
     <div id="create-post-modal" class="create-post" uk-modal>
        <div
            class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical uk-overflow-auto rounded-lg p-0 lg:w-5/12 relative shadow-2xl uk-animation-slide-bottom-small">
    
            <div class="text-center py-4 border-b">
                <h3 class="text-lg font-semibold"> Create Post </h3>
                <button class="uk-modal-close-default bg-gray-100 rounded-full p-2.5 m-1 right-2" type="button" uk-close uk-tooltip="title: Close ; pos: bottom ;offset:7"></button>
            </div>
            
            <form method="post" id="upload_form" action="/add_placepost.php" enctype="multipart/form-data">
            <div class="flex flex-1 items-start space-x-4 p-5">
                <img src="/<?= $place->image ? $place->image : "image/cover.jpeg" ?>"
                    class="bg-gray-200 border border-white rounded-full w-11 h-11">
                <div class="flex-1 pt-0">
                    <textarea class="uk-textare text-black shadow-none focus:shadow-none resize-none" rows="2"

                        placeholder="What's up <?= $place->place_name ?>?" name="content" id="content" required></textarea>
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

            <div class="bsolute bottom-0 p-4 space-x-4 w-full">
                <div class="flex bg-gray-50 border border-purple-100 rounded-2xl p-3 shadow-sm items-center">
                    <div class="lg:block hidden"> Add to your post </div>
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
        <?php endif; ?>
    </div>
    <!-- Javascript
    ================================================== -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="/script.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/messenger/js/clipboard.min.js"></script>
    <script src="/js/v2/home_place.js"></script>
    <script src="/js/v2/base.js"></script>
    <!-- For Night mode -->
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

        var post_id = <?= $_GET['p_i'] ?>;
        fetch_post(post_id);
        function fetch_post(post_id)
        {
        $.ajax({
            url:"/ajax/v2/fetch_place_post.php",
            method:"POST",
            data:{post_id:post_id},
            success:function(data){
            $('#selected_post').html(data);
            }
        })
        }
    </script>

</body>
</html>
