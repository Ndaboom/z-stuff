<!DOCTYPE html>
<html lang="en">
 <?php 
  
   $title= "Settings";
   $page = "";

   require ('includes/functions.php');
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

                <div class="bg-white divide-x flex lg:shadow-md rounded-md shadow lg:rounded-xl overflow-hidden">
                    <div class="w-1/3">

                        <nav class="responsive-nav setting-nav setting-menu"
                            uk-sticky="top:30 ; offset:80 ; media:@m ;bottom:true; animation: uk-animation-slide-top">
                            <h4 class="mb-0 p-3 uk-visible@m hidden"> Setting Navigation </h4>
                            <ul>
                                <li><a href="#"> <i class="uil-cog"></i> General </a></li>
                                <li <?= $_GET['p'] == "" ? 'class="uk-active" ' : ''?>><a href="profile_settings.php?id=<?= $user->id ?>">
                                Profile
                                   </a></li>
                                <li <?= $_GET['p'] == "social_links" ? 'class="uk-active" ' : ''?>><a href="profile_settings.php?id=<?= $user->id ?>&p=social_links"> Social links</a></li>
                                <li <?= $_GET['p'] == "update_password" ? 'class="uk-active" ' : ''?>><a href="profile_settings.php?id=<?= $user->id ?>&p=update_password"> Password </a></li>
                                <li <?= $_GET['p'] == "privacy" ? 'class="uk-active" ' : ''?>><a href="profile_settings.php?id=<?= $user->id ?>&p=privacy"> <i class="uil-dollar-alt"></i> Privacy</a></li>
                                <!-- <li><a href="#"> <i class="uil-history"></i> Manage Sessions</a></li> -->
                                <li <?= $_GET['p'] == "delete_account" ? 'class="uk-active" ' : ''?>><a href="profile_settings.php?id=<?= $user->id ?>&p=delete_account"> <i class="uil-trash-alt"></i> Delete account</a></li> 
                            </ul>
                        </nav>
                </div>

                    <div class="w-2/3">
                        <?php if(!$_GET['p']): ?>
                        <div class="flex flex-col justify-between md:h-full">

                            <div class="p-5">
                                <h3 class="font-bold text-lg">Profile</h3>
                                <p class="text-sm"> Only your first name, your last name, your profession, your city, country and your bio will be displayed publicly. All other information will be kept private. </p>
                            </div>

                                <form method="post" autocomplete="off">
                                <div class="py-8 px-20 flex-1 space-y-4">

                                    <div class="line">
                                        <input class="line__input" id="firstname" autocomplete="off" name="firstname" type="text" onkeyup="this.setAttribute('value', this.value);" value="<?= $user->name ?>" required>
                                        <span for="firstname" class="line__placeholder"> First Name   </span>
                                    </div>
                                    <div class="line">
                                        <input class="line__input" id="lastname" autocomplete="off" name="lastname" type="text" onkeyup="this.setAttribute('value', this.value);" value="<?= $user->nom2 ?>" required>
                                        <span for="lastname" class="line__placeholder"> Last Name </span>
                                    </div>
                                    <div class="line">
                                        <input class="line__input" id="email" autocomplete="off" name="email" type="email" onkeyup="this.setAttribute('value', this.value);" value="<?= $user->email ?>" required>
                                        <span for="email" class="line__placeholder">Email </span>
                                    </div>
                                    
                                    <div class="line">
                                        <input class="line__input" id="profession" autocomplete="off" name="profession" type="text" onkeyup="this.setAttribute('value', this.value);" value="<?= $user->profession ?>">
                                        <span for="username" class="line__placeholder">Profession </span>
                                    </div>
                                    
                                    <div>
                                    <label for="relationship"> Relationship status </label>
                                    <select id="relationship" name="relationship"  class="shadow-none selectpicker with-border ">
                                        <option value="" <?= $user->relationshipStatus == "" ? "selected" : ""?>None</option>
                                        <option value="Single" <?= $user->relationshipStatus == "Single" ? "selected" : ""?>>
                                            Single
                                            </option >
                                            <option value="Married" <?= $user->relationshipStatus == "Married" ? "selected" : ""?>>
                                            Married
                                            </option >
                                            <option value="Engaged" <?= $user->relationshipStatus == "Engaged" ? "selected" : ""?>>
                                            Engaged
                                            </option >
                                            <option value="Its complicated" <?= $user->relationshipStatus == "Its complicated" ? "selected" : ""?>>
                                            Its complicated
                                            </option >
                                            <option value="In a relationship" <?= $user->relationshipStatus == "In a relationship" ? "selected" : ""?>>
                                            In a relationship
                                            </option >
                                            <option value="Widowed" <?= $user->relationshipStatus == "Widowed" ? "selected" : ""?>>
                                            Widowed
                                            </option >
                                            <option value="Divorced" <?= $user->relationshipStatus == "Divorced" ? "selected" : ""?>>
                                            Divorced
                                            </option >
                                    </select>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-3 lg">
                                    <div>
                                        <label for="city"> City</label>
                                        <input type="text" name="city" value="<?= get_input('city') ? get_input('city') : e($user->city)?>" placeholder="City" class="shadow-none with-border">
                                    </div>
                                    <div>
                                        <label for=""> Country</label>
                                        <input type="text" name="country" value="<?= get_input('country') ? get_input('country') : e($user->country)?>" placeholder="Country" class="shadow-none with-border">
                                    </div>
                                    </div>
                                
                                    <div class="grid grid-cols-2 gap-3 lg">
                                        <div>
                                            <label for="dbirth"> Birth date</label>
                                            <input type="date" name="dbirth" value="<?= get_input('dbirth') ? get_input('dbirth') : e($user->dbirth) ?>" placeholder="Birth date" class="shadow-none with-border">
                                        </div>
                                        <div>
                                            <label for="sex"> Gender</label>
                                            <select id="sex" name="sex"  class="shadow-none selectpicker with-border ">
                                                <option value="H" <?= $user->sex == "H" ? "selected" : ""?>>
                                                Man
                                                </option >
                                                <option value="F" <?= $user->sex == "F" ? "selected" : ""?>>
                                                Woman
                                                </option >
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="religion"> Religion</label>
                                        <select id="religion" name="religion"  class="shadow-none selectpicker with-border ">
                                            <option value="Christian" <?= $user->religion == "Christian" ? "selected" : ""?>>
                                            Christian
                                            </option >
                                            <option value="Muslim" <?= $user->religion == "Muslim" ? "selected" : ""?>>
                                            Muslim
                                            </option >
                                            <option value="Catholic" <?= $user->religion == "Catholic" ? "selected" : ""?>>
                                            Catholic
                                            </option >
                                        </select>
                                    </div>
                
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4> Available for job?</h4>
                                            <div> Check this box if you are available for a job </div>
                                        </div>
                                        <div class="switches-list -mt-8 is-large">
                                            <div class="switch-container">
                                                <label class="switch"><input type="checkbox" name="available_for_hiring"
                                        id="available_for_hiring" <?= $user->available_for_hiring ? "checked" : ""?>><span class="switch-button"></span> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="line h-32">
                                        <textarea class="line__input h-32"  autocomplete="off"  type="text" name="bio" id="bio" onkeyup="this.setAttribute('value', this.value);" value=""><?= get_input('bio') ? get_input('bio') :e($user->bio)?></textarea>
                                        <span for="biography" class="line__placeholder">Bio </span>
                                    </div> 

                                </div>

                                <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                                <a type="button" href="timeline.php?id=<?= $user->id ?>" class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </a>
                                    <button type="submit" class="button bg-blue-700" name="update_info"> Save </button>
                                </div>
                                </form>

                        </div>
                        <?php elseif($_GET['p'] == "social_links"): ?>
                            <div class="flex flex-col justify-between md:h-full">

                            <div class="p-5">
                                <h3 class="font-bold text-lg">Social links</h3>
                                <p class="text-sm"> Social links allow your zungvi account to be connected to your other social platforms </p>
                            </div>

                                <form method="post" autocomplete="off">
                                <div class="py-8 px-20 flex-1 space-y-4">

                                    <div class="line">
                                        <input class="line__input" id="instagram" autocomplete="off" name="instagram" type="text" onkeyup="this.setAttribute('value', this.value);" value="<?= $user->instagram ?>" required>
                                        <span for="instagram" class="line__placeholder"> Instagram   </span>
                                    </div>
                                    <div class="line">
                                        <input class="line__input" id="twitter" autocomplete="off" name="twitter" type="text" onkeyup="this.setAttribute('value', this.value);" value="<?= $user->twitter ?>" required>
                                        <span for="twitter" class="line__placeholder"> Twitter </span>
                                    </div>
                                    <div class="line">
                                        <input class="line__input" id="github" autocomplete="off" name="github" type="text" onkeyup="this.setAttribute('value', this.value);" value="<?= $user->github ?>" required>
                                        <span for="email" class="line__placeholder">Github </span>
                                    </div>
                                </div>

                                <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                                    <a type="button" href="timeline.php?id=<?= $user->id ?>" class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </a>
                                    <button type="submit" class="button bg-blue-700" name="update_social_links"> Save </button>
                                </div>
                                </form>

                            </div>
                        <?php elseif($_GET['p'] == "update_password"): ?>
                            <div class="flex flex-col justify-between md:h-full">
                            <div class="p-5">
                                <h3 class="font-bold text-lg">Password</h3>
                                <p class="text-sm"> Your password is valuable, so we make sure that you and only you have the right to know about it by encrypting it with one-way encryption </p>
                               <?php if(isset($errors)&& count($errors) !=0){
                                    if($error == "Password updated successfully"){
                                        echo '<span class="text-blue-600">
                                        ';
                                    } else{
                                        echo '<span class="text-red-600">
                                        '; 
                                    }
                                    foreach ($errors as $error){
                                    echo $error.' <br/>';
                                    }
                                    echo '</span>';
                                }
                                ?>
                            </div>

                                <form method="post" autocomplete="off">
                                <div class="py-8 px-20 flex-1 space-y-4">
                                    <div class="line">
                                        <input class="line__input" id="current_password" autocomplete="off" name="current_password" type="password" onkeyup="this.setAttribute('value', this.value);">
                                        <span for="current_password" class="line__placeholder"> Actual password </span>
                                    </div>
                                    <div class="line">
                                        <input class="line__input" id="new_password" autocomplete="off" name="new_password" type="password" onkeyup="this.setAttribute('value', this.value);" required>
                                        <span for="new_password" class="line__placeholder"> New password * </span>
                                    </div>
                                    <div class="line">
                                        <input class="line__input" id="password_confirmation" autocomplete="off" name="password_confirmation" type="password" onkeyup="this.setAttribute('value', this.value);" required>
                                        <span for="password_confirmation" class="line__placeholder"> Password confirmation * </span>
                                    </div>
                                </div>
                                <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                                    <a type="button" href="timeline.php?id=<?= $user->id ?>" class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </a>
                                    <button type="submit" class="button bg-blue-700" name="update_password"> Save </button>
                                </div>
                                </form>

                            </div>
                        <?php elseif($_GET['p'] == "privacy"): ?>
                            <div class="flex flex-col justify-between md:h-full">

                                <div class="p-5">
                                    <h3 class="font-bold text-lg">Privacy</h3>
                                    <p class="text-sm"> </p>
                                <?php if(isset($errors)&& count($errors) !=0){
                                        echo '<span class="text-red-600">
                                        '; 
                                        foreach ($errors as $error){
                                        echo $error.' <br/>';
                                        }
                                        echo '</span>';
                                    }
                                    ?>
                                </div>
                                <form method="post">
                                <div class="bg-white rounded-md lg:shadow-md shadow p-6">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4> Who can see my posts ?</h4>
                                            <div> If activated, only your friends can see your posts </div>
                                        </div>
                                        <div class="switches-list -mt-8 is-large">
                                            <div class="switch-container">
                                                <label class="switch"><input type="checkbox" name="posts_privacy" <?= $user->posts_privacy ? "checked" : ""?>><span class="switch-button"></span> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4> Who can see my friends list ?</h4>
                                            <div> If activated, only your friends can see your friends list </div>
                                        </div>
                                        <div class="switches-list -mt-8 is-large">
                                            <div class="switch-container">
                                                <label class="switch"><input type="checkbox" name="friends_privacy" <?= $user->friends_privacy ? "checked" : ""?>><span class="switch-button"></span> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h4> Disable Commenting </h4>
                                            <div> Disable comments on your posts </div>
                                        </div>
                                        <div class="switches-list -mt-8 is-large">
                                            <div class="switch-container">
                                                <label class="switch"><input type="checkbox" name="comments_privacy" <?= $user->comments_privacy ? "checked" : ""?>><span class="switch-button"></span> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                                    <a type="button" href="timeline.php?id=<?= $user->id ?>" class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </a>
                                    <button type="submit" class="button bg-blue-700" name="update_privacy"> Save </button>
                                    </div>
                                </div>
                                </form>
                              </div>
                            </div>
                        <?php elseif($_GET['p'] == "delete_account"): ?>
                            <div class="flex flex-col justify-between md:h-full">

                            <div class="p-5">
                                <h3 class="font-bold text-lg">Delete account</h3>
                                <p class="text-sm"> Please provide your password to proceed with your account deletion and all of your data on zungvi. </p>
                            </div>

                            <form method="post" autocomplete="off">
                            <div class="py-8 px-20 flex-1 space-y-4">
                                <div class="line">
                                    <input class="line__input" id="instagram" autocomplete="off" name="user_password" type="text" onkeyup="this.setAttribute('value', this.value);" required>
                                    <span for="user_password" class="line__placeholder"> Password   </span>
                                </div>
                            </div>
                            <div class="bg-gray-10 p-6 pt-0 flex justify-end space-x-3">
                                    <a type="button" href="timeline.php?id=<?= $user->id ?>" class="p-2 px-4 rounded bg-gray-50 text-red-500"> Cancel </a>
                                    <button type="submit" class="button bg-blue-700" name="delete_account"> Save </button>
                            </div>
                            </form>

                            </div>
                        <?php endif; ?>
                    </div>

                        <br>

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

</body>
</html>
