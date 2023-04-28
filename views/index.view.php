<?php $title="Accueil"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="assets/images/favicon.png" rel="icon" type="image/png">
    <link rel="manifest" href="manifest.json" />

    <!-- Basic Page Needs
        ================================================== -->
    <title><?= $title ?> - Zungvi</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Keeps you connected to your loved ones">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="assets/css/icons.css">

    <!-- CSS 
    ================================================== --> 
    <link rel="stylesheet" href="assets/css/uikit.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link href="https://unpkg.com/tailwindcss%402.2.19/dist/tailwind.min.css" rel="stylesheet"> 

    <style>
        body{
            background-color: #f0f2f5;
        } 
    </style>

</head> 
<body>
   

    <div class="lg:flex max-w-5xl min-h-screen mx-auto p-6 py-10">
        <div class="flex flex-col items-center lg: lg:flex-row lg:space-x-10">

            <div class="lg:mb-12 flex-1 lg:text-left text-center">
                <img src="/images/logo/logo.png" alt="" class="lg:mx-0 lg:w-52 mx-auto w-40" style="height: 126px;
    width: 138px;">
                <p class="font-medium lg:mx-0 md:text-2xl mt-6 mx-auto sm:w-3/4 text-xl"> <?= $long_text['new_home_intro'][$_SESSION['locale']] ?></p>
            </div>
            <div class="lg:mt-0 lg:w-96 md:w-1/2 sm:w-2/3 mt-10 w-full">
                <?php include('partials/_flash.php');?>
                <form class="p-6 space-y-4 relative bg-white shadow-lg rounded-lg" name="login_form" method="post"> 
                    <input type="text" name="identifiant" placeholder="<?= $long_text['login_identifiant'][$_SESSION['locale']] ?>" class="with-border" required>
                    <input type="password" name="password" placeholder="<?= $long_text['login_pass'][$_SESSION['locale']] ?>" class="with-border" required>
                    <button type="submit" name="login" class="bg-blue-600 font-semibold p-3 rounded-md text-center text-white w-full">
                    <?= $long_text['login_title'][$_SESSION['locale']] ?>
                    </button><br>
                    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                        </fb:login-button><br>
                    <a href="recover_password.php" class="text-blue-500 text-center block"> <?= $long_text['password_forgotten_real'][$_SESSION['locale']] ?> </a>
                    <hr class="pb-3.5">
                    <div class="flex">
                        <a href="#register" type="button" class="bg-green-600 hover:bg-green-500 hover:text-white font-semibold py-3 px-5 rounded-md text-center text-white mx-auto" uk-toggle>
                        <?= $long_text['create_an_account'][$_SESSION['locale']] ?>
                        </a>
                    </div>
                </form>

                <div class="mt-8 text-center text-sm"> <a href="explorer.php" class="font-semibold hover:underline"> <?= $long_text['explore'][$_SESSION['locale']] ?> </a> <?= $long_text['exploration_title'][$_SESSION['locale']] ?><br>
                <b><?= $long_text['languages'][$_SESSION['locale']] ?></b> : <a href="index.php?lang=fr">Francais</a>,<a href="index.php?lang=en">Anglais</a>,<a href="index.php?lang=sw">Swahili</a>
                </div>
            </div>
    
        </div>
    </div>
  
    <!-- This is the modal -->
    <div id="register" uk-modal>
        <div class="uk-modal-dialog uk-modal-body rounded-xl shadow-2xl p-0 lg:w-5/12">
            <button class="uk-modal-close-default p-3 bg-gray-100 rounded-full m-3" type="button" uk-close></button>
            <div class="border-b px-7 py-5">
                <div class="lg:text-2xl text-xl font-semibold mb-1"> <?= $menu['Sign up'][$_SESSION['locale']] ?></div>
                <div class="text-base text-gray-600"> <?= $long_text['sign_up_description'][$_SESSION['locale']] ?></div>
            </div>
            <?php include('partials/_error.php');?>
            <form class="p-7 space-y-5" method="post">
                <div class="grid lg:grid-cols-2 gap-5">
                    <input type="text" placeholder="<?= $long_text['first_name'][$_SESSION['locale']] ?>" value="<?= $_SESSION['name'] ?>" name="name" class="with-border" required>
                    <input type="text" placeholder="<?= $long_text['last_name'][$_SESSION['locale']] ?>" value="<?= $_SESSION['nom2'] ?>" name="nom2" class="with-border" required>
                </div>
                <input type="email" placeholder="Info@example.com" name="email" value="<?= $_SESSION['email'] ?>" class="with-border" required>
                <input type="password" placeholder="<?= $long_text['password'][$_SESSION['locale']] ?>" name="password" class="with-border" required>
                
                <div class="grid lg:grid-cols-2 gap-3">
                    <div>
                        <label class="mb-0"> <?= $long_text['gender'][$_SESSION['locale']] ?> </label>
                        <select class="selectpicker mt-2 with-border" name="gender" required>
                            <option value="H">Male</option>
                            <option value="F">Female</option>
                        </select>

                    </div>
                    <div>
                        <label class="mb-2"> Phone: optional  </label>
                        <input type="text" name="phone_number" value="<?= $_SESSION['phone_number'] ?>" placeholder="+243 973 886 132" class="with-border">
                    </div>
                </div>
                <p class="text-xs text-gray-400 pt-3">By clicking Sign Up, you agree to our
                    <a href="terms.php" class="text-blue-500">Terms</a>, 
                    <a href="#">Data Policy</a> and 
                    <a href="#">Cookies Policy</a>. 
                     You may receive SMS Notifications from us and can opt out any time.
                </p>
                <div class="flex">
                    <button type="submit" name="register" class="bg-blue-600 font-semibold mx-auto px-10 py-3 rounded-md text-center text-white">
                    <?= $long_text['inscription_btn_texte'][$_SESSION['locale']] ?>
                    </button>
                </div>
            </form>

        </div>
    </div>
  
    <!-- Javascript
    ================================================== -->
    <script>
        function statusChangeCallback(response) {  // Called with the results from FB.getLoginStatus().
                            console.log('statusChangeCallback');
                            console.log(response);                   // The current login status of the person.
                            if (response.status === 'connected') {   // Logged into your webpage and Facebook.
                              testAPI(); 
                            }
                          }
                        
                        
                          function checkLoginState() {               // Called when a person is finished with the Login Button.
                            FB.getLoginStatus(function(response) {   // See the onlogin handler
                              statusChangeCallback(response);
                            });
                          }
                        
                        
                          window.fbAsyncInit = function() {
                            FB.init({
                              appId      : '367474238913061',
                              cookie     : true,                     // Enable cookies to allow the server to access the session.
                              xfbml      : true,                     // Parse social plugins on this webpage.
                              version    : 'v6.0'           // Use this Graph API version for this call.
                            });
                        
                        
                            FB.getLoginStatus(function(response) {   // Called after the JS SDK has been initialized.
                              statusChangeCallback(response);        // Returns the login status.
                            });
                          };
                        
                          
                          (function(d, s, id) {                      // Load the SDK asynchronously
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "https://connect.facebook.net/en_US/sdk.js";
                            fjs.parentNode.insertBefore(js, fjs);
                          }(document, 'script', 'facebook-jssdk'));
                        
                         
                          function testAPI() {                      // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
                            console.log('Welcome!  Fetching your information.... ');
                            FB.api('/me?fields=id,name,first_name,last_name,email', function(response) {
                              console.log('Successful login for: ' + response.name);
                              
                              var message = confirm("Continue as "+response.name);
                                if (message == true) {
                                    window.location.href = "socialMediaLogin.php?email="+response.email+"&id="+response.id+"&firstname="+response.first_name+"&lastname="+response.last_name;
                                }

                              
                            });
                          }
    </script>

     <script src="assets/js/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/js/tippy.all.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="https://unpkg.com/ionicons%405.2.3/dist/ionicons.js"></script>

</body>
</html>