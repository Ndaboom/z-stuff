
<?php

 $title= $_GET['tag']." Explore";

 require ('includes/functions.php');
 require('includes/adds_functions.php');
 include('partials/_header.php');
 ?>

    <link rel="stylesheet" href="assets/css/channel/style.css">

<body style="margin-top: 60px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                    <div id="best_of_user">

                    </div>
                    <h5 class="text-center"></h5>



                </div>
            </div>
            <div class="col-lg-7 offset-lg-3">
                <div class="row">
                    <div class="col-lg-8">
                       <!--   Affichage des posts -->
                       <?php if(isset($_GET['tag'])): ?>
                       <div style="border-bottom: solid 1px #DDDDDD; padding-bottom:20px;">
                       <h5 style="padding-top: 40px;"><i class="fas fa-hashtag"></i> <?php echo($_GET['tag'])  ?></h5>
                       </div>
                       <?php else: ?>
                        <h5 style="padding-top: 40px;">Explorer les publications avec des hashtags</h5>
                       <?php endif; ?>
                        <div id="post_list" style="margin-top:20px;">


                        </div>
                        <div id="post_list_message">

                        </div>
                        <div class="d-flex justify-content-center" style="display: none;">
                            <i class="fas fa-spinner fa-spin" style="display: none; color: blue; margin-top: 10px;" id="spinner1"></i>
                        </div>
                       <!--   Affichage des posts -->

                    </div>
                    <div class="col-lg-4" id="trends">


                        <div class="card my-3">
                            <div class="card-body p-2">
                                <div class="h6"> Trends  </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-fixed f-right">
                <div class="side-right">

                </div>
            </div>
        </div>
    </div>
    <!--SCRIPT -->
    <script src="assets/js/jquery.min.js"></script>

    <script src="https://getbootstrap.com/docs/4.2/dist/js/bootstrap.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="js/explore.js"></script>
<!-- SCRIPT -->

</body>
