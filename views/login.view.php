<?php $title="Connection"; ?>
<!DOCTYPE html>
<html lang="en" class="bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="assets/images/favicon.png" rel="icon" type="image/png">

    <!-- Basic Page Needs
        ================================================== -->
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Keeps you connected to your loved ones">

    <!-- icons
    ================================================== -->
    <link rel="stylesheet" href="assets/css/icons.css">

    <!-- CSS 
    ================================================== --> 
    <link rel="stylesheet" href="assets/css/uikit.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/tailwind.css">  
 
    <style>
        input , .bootstrap-select.btn-group button{
            background-color: #f3f4f6  !important;
            height: 44px  !important;
            box-shadow: none  !important; 
        }
    </style>
</head> 
<body>

<body class="bg-gray-100">


    <div id="wrapper" class="flex flex-col justify-between h-screen">

        <!-- header-->
        <div class="bg-white py-4 shadow dark:bg-gray-800">
            <div class="max-w-6xl mx-auto">


                <div class="flex items-center lg:justify-between justify-around">

                    <a href="index.php">
                        <img src="/images/logo/logo.png" alt="" style="height: 42px;
    width: 42px;">
                    </a>

                    <div class="capitalize flex font-semibold hidden lg:block my-2 space-x-3 text-center text-sm">
                        <a href="login.php" class="py-3 px-4">Login</a>
                        <a href="inscription.php" class="bg-blue-500 purple-500 px-6 py-3 rounded-md shadow text-white">Register</a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Content-->
        <div>
            <div class="lg:p-12 max-w-xl lg:my-0 my-12 mx-auto p-6 space-y-">
                <?php include('partials/_flash.php');?>
                <form class="lg:p-10 p-6 space-y-3 relative bg-white shadow-xl rounded-md" method="post" autocomplete="off">
                    <h1 class="lg:text-2xl text-xl font-semibold mb-6"> Login </h1>

                    <div>
                        <label class="mb-0"> Username </label>
                        <input type="text" placeholder="<?= $long_text['login_identifiant'][$_SESSION['locale']] ?>" name="identifiant" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required>
                    </div>
                    <div>
                        <label class="mb-0"> Password </label>
                        <input type="password" name="password" placeholder="******" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required>
                    </div>
                    <div class="checkbox">
                            <input type="checkbox" id="chekcbox1" name="remember_me" checked>
                            <label for="chekcbox1"><span class="checkbox-icon"></span> Remember me</label>
                    </div>

                    <div>
                        <button type="submit" name="login" class="bg-blue-600 font-semibold p-2 mt-5 rounded-md text-center text-white w-full">
                            Log In</button><br><br>
                    <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                    </fb:login-button><br>
                    <a href="recover_password.php" class="text-blue-500 text-center mt-4 block"> Forgot Password? </a>
                    </div>
                </form>


            </div>
        </div>
        
        <!-- Footer -->

        <div class="lg:mb-5 py-3 uk-link-reset">
            <div class="flex flex-col items-center justify-between lg:flex-row max-w-6xl mx-auto lg:space-y-0 space-y-3">
                <div class="flex space-x-2 text-gray-700 uppercase">
                    <a href="#"> About</a>
                    <a href="#"> Help</a>
                    <a href="terms.php"> Terms & Privacy</a>
                </div>
                <p class="capitalize"> © copyright 2022 - Zungvi</p>
            </div>
        </div>

    </div>

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

<!-- Javascript
================================================== -->
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/uikit.js"></script>
<script src="assets/js/simplebar.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/ionicons%405.2.3/dist/ionicons.js"></script>

</body>
</html>