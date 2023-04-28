<!DOCTYPE html>
<html lang="en">
 <?php 
   
    $title = "Contact us";
    $page = "explorer";

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
            <div class="flex h-52 items-center justify-center lg:h-80 pb-10 relative w-full" style="background-image: url('assets/images/homebackground-min.jpg');background-size: cover;">
                <div class="text-center max-w-xl mx-auto z-10 relative px-5">
                    <div class="lg:text-4xl text-2xl text-white font-semibold mb-3"> Leave a message </div>
                    <div class="text-white text-lg font-medium text-opacity-90"> Contact us if you have any questions about our company   We will try to provide an answer </div>
                </div>
            </div>
            <div class="mcontainer">
                <div class="-mt-16 bg-white max-w-2xl mx-auto p-10 relative rounded-md shadow">
                    <div class="grid md:grid-cols-2 md:gap-y-7 md:gap-x-6 gap-6">
                        <input type="text" placeholder="Your Name" class="with-border">
                        <input type="text" placeholder="Email address" class="with-border">
                        <input type="text" placeholder="Company Name" class="with-border">
                        <input type="text" placeholder="Contact Number" class="with-border">
                        <textarea placeholder="How can we help?" rows="5" class="with-border md:col-span-2 p-5 px-7 resize-none h-72"></textarea>
                        <div class="md:col-span-2 md:flex items-center justify-between">
                            <div>
                                <div class="checkbox">
                                    <input type="checkbox" id="chekcbox2">
                                    <label for="chekcbox2">
                                        <span class="checkbox-icon"></span> <span class="font-medium text-gray-400">I agree to the <a href="terms.php">Terms</a> &amp; Conditions</span> 
                                    </label>
                                </div>
                            </div>
                            <button type="button" class="button bg-blue-700 w-full md:w-auto md:mt-0 mt-4"> Submit </button> 
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <!-- Main Contents -->  
    </div>

    <!-- Javascript
    ================================================== -->
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/uikit.js"></script>
    <script src="assets/js/simplebar.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="js/v2/explorer.js"></script>
    <script src="js/v2/base.js"></script>

</body>
</html>
