<?php 
$poster=find_user_by_id($data->user_id);
$title = "$poster->name 's posts"; ?>
<?php include('partials/_header.php'); ?>
<link rel="stylesheet" href="assets/css/channel/style.css">
<body style="margin-top: 80px;">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
			<div id="post" style="width: 500px; height: 400px; margin-left:auto; margin-right: auto;">
  	
            </div>	
			</div>
			<div class="col-md-4 f-right">
				 <div class="h7 text-center">Friends</div>
                    <div id="user_details">
                      
                    </div>
			</div>
		</div>
		 

	</div>	
</body>
<!-- SCRIPTS -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.timeago.js"></script>
<script src="assets/js/jquery.timeago.fr.js"></script>
 <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".timeago").timeago();
         fetch_online_user();
         fetch_incomming_msg();
         fetch_current_user_post_data();

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

        function update_last_activity()
        {
          $.ajax({
            url:"ajax/update_last_activity.php",
            success:function()
            {

            }
          })
        }

        function fetch_current_user_post_data()
        {
          $.ajax({
            url: 'ajax/fetch_current_user_post_data.php',
            success:function(data)
            {
              $('#post').html(data);
            }
          })
        }

        $(document).on('click', '.like', function(){

        var id= $(this).attr("id");
        var url='ajax/micropost_like.php';
        var action = $(this).data('action');
        var poster = $(this).data('poster');
        var postid = $(this).data('postid');
        var micropostId = id.split("like")[1];
            $.ajax({
                type:'POST',
                url:url,
                data: {
                       micropost_id: micropostId,
                       action: action,
                       poster:poster,
                       postid:postid
                      },
                success: function(likers){
                  fetch_current_user_post_data();
                }

            });
        });

        var post_id;
        var user_id;
        $(document).on('click','.post_comment', function(){
              post_id = $(this).attr('id');
              user_id = $(this).data('user_id');
              var action = 'fetch_comment';
              $.ajax({
                url:"action.php",
                method:"POST",
                data:{post_id:post_id,user_id:user_id,action:action},
                success:function(data){
                  $('#old_comment'+post_id).html(data);
                  $('#comment_form'+post_id).slideToggle('slow');
                }
              })
             
              
        });

        $(document).on('click','.submit_comment',function(){
         var comment = $('#comment'+post_id).val();
         var action = 'submit_comment';
         var receiver_id = user_id;
         var poster = $(this).data('poster');

         if(comment != '')
         {
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{post_id:post_id,receiver_id:receiver_id,comment:comment,action:action,poster:poster},
           success:function(data)
           {
            $('#comment_form'+post_id).slideUp('slow');
           fetch_current_user_post_data();
           } 
          })
         }
        });

        $(document).on('click','.like_comment',function(){
          var poster_id = $(this).data('poster_id');
          var comment= $(this).data('comment');
          var post= $(this).data('post');
          var commentid= $(this).data('commentid');
          var action= 'like_comment';
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
            success:function(data)
            {
             fetch_current_user_post_data();
            }
          })

        });

        $(document).on('click','.unlike_comment',function(){
          var poster_id = $(this).data('poster_id');
          var comment= $(this).data('comment');
          var post= $(this).data('post');
          var commentid= $(this).data('commentid');
          var action= 'unlike_comment';
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
            success:function(data)
            {
            fetch_current_user_post_data();
            }
          })

        });


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

