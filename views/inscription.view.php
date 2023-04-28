<?php $title="Inscription";?>
<!DOCTYPE html>
<html lang="en" class="bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link href="assets/images/favicon.png" rel="icon" type="image/png">

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
                    <form class="lg:p-10 p-6 space-y-3 relative bg-white shadow-xl rounded-md" method="post">
                        <h1 class="lg:text-2xl text-xl font-semibold mb-6"> Create an account </h1>
						<?php include('partials/_error.php');?>
                        <div class="grid lg:grid-cols-2 gap-3">
                            <div>
                                <label class="mb-0" for="name"><?= $long_text['first_name'][$_SESSION['locale']] ?> </label>
                                <input type="text" name="name" placeholder="Your Name" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" value="<?= $_SESSION['name'] ?>" required>
                            </div>
                            <div>
                                <label class="mb-0" for="nom2"> <?= $long_text['last_name'][$_SESSION['locale']] ?> </label>
                                <input type="text" placeholder="Last  Name" name="nom2" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" value="<?= $_SESSION['nom2'] ?>" required>
                            </div>
                        </div>
                        <div>
                            <label class="mb-0" for="email"> <?= $long_text['email_address'][$_SESSION['locale']] ?> </label>
                            <input type="email" name="email" placeholder="Info@example.com" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" value="<?= $_SESSION['email'] ?>" required>
                        </div>
                        <div>
                            <label class="mb-0" for="password"> <?= $long_text['password'][$_SESSION['locale']] ?> </label>
                            <input type="password" name="password" placeholder="******" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full" required>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-3">
                            <div>
                                <label class="mb-0"> <?= $long_text['gender'][$_SESSION['locale']] ?> </label>
                                <select name="gender" class="selectpicker mt-2" required>
                                    <option value="H">Male</option>
                                    <option value="F">Female</option>
                                </select>
                            </div>
                            <div>
                                <label class="mb-0" for="phone_number"> Phone: optional  </label>
                                <input type="text" name="phone_number" value="<?= $_SESSION['phone_number'] ?>" placeholder="+243 899 480 913" class="bg-gray-100 h-12 mt-2 px-3 rounded-md w-full">
                            </div>
                        </div>

                        <div class="checkbox">
                            <input type="checkbox" id="chekcbox1" checked="" required>
                            <label for="chekcbox1"><span class="checkbox-icon"></span> I agree to the <a href="terms.php" target="_blank" class="uk-text-bold uk-text-small uk-link-reset"> Terms and Conditions </a>
                            </label>
                        </div>

                        <div>
                            <button type="submit" name="register" class="bg-blue-600 font-semibold p-2 mt-5 rounded-md text-center text-white w-full">
                                Get Started</button>
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
                    <a href="#"> Terms</a>
                    <a href="#"> Privacy</a>
                </div>
                <p class="capitalize"> © copyright 2022 - Zungvi</p>
            </div>
        </div>

    </div>

    

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
	

