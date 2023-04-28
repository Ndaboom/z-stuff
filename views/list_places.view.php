<?php $title="places";?>

    <?php 
    require ('includes/functions.php');
    include('partials/_header.php');
    require('config/database.php');
    ?>

   
    <link rel="stylesheet" href="assets/css/Allplaces/style.css">
    

<body style="margin-top: 90px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 offset-fixed f-left">
                <div class="side-left">
                    
                     <div>
                        
                    </div>

                </div>
               
            </div>
            <div class="col-lg-7 offset-lg-3">
                <div class="row">
                    <div class="col-lg-8">
                      <div class="placeCard">
                                
                       <div class="card">
          <div class="card-header">
            <h1>Find some better places</h1>
          </div>
          <div class="card-body" id="placesList">
            
          </div>
         <div class="d-flex justify-content-center" style="display: none;">
                            <i class="fas fa-spinner fa-spin" style="display: none; color: blue; margin-top: 10px;" id="spinner1"></i>
         </div>
          
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
        
        var limit = 2;
        var start = 0;
        var limit2=2;
        var action= 'inactive';
        function load_data(limit,start){
          $.ajax({
            url:"ajax/fetch_places.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            beforeSend: function(){
                    $("#spinner1").show();
                },
            success:function(data)
            {
              $('#placesList').append(data);
              $("#spinner1").hide();
              if(data == '')
              {
               $('#post_list_message').html("<h5>No available places...</h5>");
               action = 'active';
              }
              else 
              {
               $('#post_list_message').html("<button class='btn btn-zung btn-block btn-sm more_post'>loading...</button>");
               action = 'inactive';
              }
            }
          })
        }
        if(action == 'inactive')
        {
          action = 'active';
          load_data(limit,start);

        }
        $(window).scroll(function(){
           if($(window).scrollTop() + $(window).height() > $("#placesList").height() && action == 'inactive')
           {
            action = 'active';
            start = start + limit;
            limit2 = start+2;
            setTimeout(function(){
              load_data(limit,start);
            },1000);
           }
        });

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
    
    
    
