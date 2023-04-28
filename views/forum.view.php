
    <?php 
    
    if($notifications_count > 0)
        {
          $notifications_nbr = "(".$notifications_count.")";
        }else{
          $notifications_nbr = "";
        }
 $title= $notifications_nbr." Forum";
 
    require ('includes/functions.php');
    include('partials/_header.php');
    require('config/database.php');
    ?>

   
    <link rel="stylesheet" href="assets/css/channel/style.css">
    
<body style="margin-top: 90px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                    <div class="d-flex">
                      
                        <div class="ml-3 h7">
                          
                        </div>
                    </div>
                    
                     <div>
                       
                        
                    </div>

                </div>
               
            </div>
            <div class="col-lg-7 offset-lg-3">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Panneaux de creation des places -->
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 style="color:#474f7C;">Create a forum to exchange with your friends on questions, relevant topics of professional, social life, ... </h6>
                            <br>
                             <div class="card">
                                <div class="card-body">
                                    <a href="list_forums.php">Browse forums</a>
                                </div>
                            </div>
                            
                            <div class="card" style="background-color: white;">
                                <div class="card-body">
                            <i class="fas fa-users"></i> Create a forum
                            </div>
                            <div class="card-footer">
                            <form method="post" class ="well" autocomplete="off">
                                    <div class="">
                                        <input type="text" class="form-control" placeholder="Name of the forum" id="forum_name" name="forum_name"
      required="require"/>
                                    </div><br>
                                   <div class="form-group">
                                   <textarea name="description" id="description" cols="75" rows="03" class="form-control"
                                    placeholder="About the forum"></textarea>
                                    
                                   
                                   </div>
                                    <br>
                                    <div class="pull-right">
                                        <a><input type="submit" class="btn btn-primary" value="Create" name="insert"/></a>
                                    </div>



                                   
                                </form>
                                
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
    <script src="script.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.min.js"></script>
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
        
         var url ='ajax/search.php';
        $('input#searchbox').on('keyup', function(){
            var query = $(this).val();
        if (query.length > 2) {
          $.ajax({
                type:'POST',
                url:url,
                data: {
                       query: query
                      },
                beforeSend: function(){
                    $("#spinner").show();
                },
                success: function(data){
                   $("#spinner").hide();
                   $("#display-results ").html(data).show();

                }

            });
        }else{
            $("#display-results ").hide();
        }
          
    });
    });
    
</script>
<!-- SCRIPT -->

</body>
    
    
    
