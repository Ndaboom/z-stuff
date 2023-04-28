
<?php $title="Places";?>

    <?php 
    require ('includes/functions.php');
    include('partials/_header.php');
    require('config/database.php');
    ?>

   
    <link rel="stylesheet" href="assets/css/channel/style.css">
    
<!------ Include the above in HEAD tag ---------->

<body style="margin-top: 90px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
               
                </div>
               
            </div>
            <div class="col-lg-7 offset-lg-3">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Panneaux de creation des places -->
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 style="color:#474f7C;">Create a place to allow your friends to know more about you, your business and the products they offer</h6>
                            <br>
                            
                            <div class="card card-sm">
                                <div class="card-body">
                            <a href="" data-toggle="modal" data-target="#monModal" ><i class="fas fa-building"></i> Add a place</a>
                            </div>
                            <?php include('partials/add_place_modal.php'); ?>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <a href="list_places.php">Browse places</a>
                                </div>
                            </div>
                           
                

                            </div>
                            <div class="card-footer text-center">
                                <div style="">Copyright &copy;<script>document.write(new Date().getFullYear());</script>
                                All rights reserved |Zungvi<a href=""><h6>Conditions</h6>
                                    </a><i class="fa fa-heart-o" aria-hidden="true"></i></div>
                            </div>
                            
                        </div>

                    </div>
                    <div class="col-lg-4">
                     <div class="card my-3">
                            <div class="card-body p-2">
                                <div class="h6">Some interesting places :</div>
                              <?php foreach($places as $row): ?>
                                <?php if(!a_place_has_already_been_followed($row->id,get_session('user_id'))): ?>
                                 <div class="card bg-dark text-white">
                                  <img src="<?= e($src =($row->coverpic != null) ? $row->coverpic : 'images/place_cover.jpg') ?>" class="card-img" alt="..." with="95">
                                 <div class="card-img-overlay text-center">
                                  <h5 class="card-title" style="font-family:Arial Black;font-size:20px;font-style:bold;"><?= $row->place_name ?></h5>
                                     <a href="homeplace.php?pl_i=<?= $row->id ?>" class="btn btn-outline-primary btn-xs">Visit</a>
                                  </div>
                                </div> <br>
                              <?php endif; ?>
                              <?php endforeach; ?>
                                <a class="btn btn-link" href="list_places.php">see more</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 offset-fixed f-right">
                <div class="side-right">
                    <div class="h7 text-center">Friends</div>
                    <div id="user_details">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--SCRIPT -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.timeago.js"></script> 
<script src="assets/js/jquery.timeago.fr.js"></script>  


<script type="text/javascript">
    $(document).ready(function() {
        $(".timeago").timeago();
        fetch_online_user();
        fetch_incomming_msg();


        setInterval(function(){
           update_last_activity();
           fetch__online_user();
           fetch_incomming_msg();

        },5000);
         
          function fetch_incomming_msg()
        {
          $.ajax({
            url:"ajax/fetch_incomming_msg.php",
            method:"POST",
            success:function(data)
            {
              $('#message').html(data);
            }
          })
        }
        
         function fetch_online_user()
        {
          $.ajax({
            url:"ajax/fetch_online_user.php",
            method:"POST",
            success:function(data){
              $('#user_details').html(data);
            }
          })
        }

        function update_last_activity()
        {
          $.ajax({
            url:"ajax/update_last_activity.php",
            success:function()
            {

            }
          })
        }
        
         
    });
    
</script>
<!-- SCRIPT -->

</body>
    
    
    
