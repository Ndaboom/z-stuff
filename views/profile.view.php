
<?php $title= $user->name." Profile";?>

	<?php
	require "includes/functions.php";
	include('partials/_header.php');?>
<style type="text/css">
.h3{
font-style: italic;
}
.label{
font-style: italic;
}
#userprofile{
position: absolute; top: 180px; left: 50%;  width: 200px; height: 200px;
}

#buttonBox{
    width: 670px;
    padding-top: 10px;
}

#cover{
position: relative; top: 0; left: 0; width: 670px; height: 250px;
}

#usercover1{
position: relative; top: 0; left: 0; width: 500px; height: 250px;
}
#userprofil1{
position: absolute; top: 180px; left: 150px;  width: 250px;
}

@media (max-width:580px){

#profileP{
position: absolute; top: 220px; left: 110px; height: 70px; width: 70px;
}

#userprofile{
position: absolute; top: 180px; left: 50%;  width: 100px; height: 100px;
}

#cover{
position: relative; top: 0; left: 0; width: 100%; height: 150px;
}

.postCard{
    max-width:300px;
}

#buttonBox{
    max-width:300px;
    padding-top: 10px;
}

#all_post{
  max-width:300px;
}

#username{
  font-size: 20px;
}
}

</style>
	<link rel="stylesheet" href="assets/css/profile/style.css">
   <body>

<div class="container-fluid">
<div class="row">
<div class="col-lg-3 offset-fixed f-left">
<div class="side-left">
<div class="card">
<div class="card-body text-center">
<h6 class="text-primary card-title"> About <?= get_session('user_id') == $_GET['id'] ? "You" : "<?= $user->name ?>  <?= $user->nom2 ?>"; ?>
</h6>

<?php if($user->profession != ""): ?>
  <i class="fa fa-briefcase"></i> <?= $user->profession ?><br>
<?php endif; ?>

<?php if($user->city != "" && $user->country != ""): ?>
   lives in <?= $user->country ?>, <?= $user->city ?><br>
<?php endif; ?><br>
 <?=
     $user->sex=="H" ? '<i class="fas fa-male"></i>' : '<i class="fas fa-female"></i>';
 ?>

  <?=
     $user->available_for_hiring ? ' Available for hiring' : ' Not Available for hiring';
 ?><br>
<div class="text-center">
    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#biographyModal"><?= $user->name ?> Biography</button>
</div>

</div>
</div>

<div class="card">
    <div class="card-body text-center">
       <h6 class="text-primary card-title"> Social links</h6>
      <div class="col-md-12">
         <?php if($user->instagram != null): ?>
         <i class="fab fa-instagram"></i><a href="//www.instagram.com/<?=e($user->instagram)?>" target="_blank"> @<?=e($user->instagram)?></a><br>
         <?php endif; ?>
          <?php if($user->github != null): ?>
        <i class="fab fa-twitter"></i><a href="//twitter.com/<?=e($user->twitter)?>" target="_blank"> @<?=e($user->twitter)?></a></Br>
        <?php endif; ?>
        <?php if($user->github != null): ?>
        <i class="fab fa-github-square"></i><a href="//github.com/<?=e($user->github)?>" target="_blank"> <?=e($user->github)?></a></Br>
        <?php endif; ?>

       </div>
    </div>
</div>

</div>

</div>
<div class="col-lg-7 offset-lg-3">
    <div class="row">
        <div class="col-lg-8">
              <div class="coverPic" style="margin-top: 60px !important;">
               <img src="<?= e($src =($user->coverpic != null) ? $user->coverpic : 'images/cover.jpeg') ?>" data-toggle="modal" data-target="#coverModal" id="cover">
               <img src="<?= e($user->profilepic) ?>" id="userprofile" class="rounded-circle img-thumbnail" data-toggle="modal" data-target="#monModal"/>
              </div>

              <?php include('partials/user_biography_modal.php'); ?>
              <!-- FOR PROFILE && COVER EDITION  --->
              <!--- Modal for the profile pic  --->
            <div class="modal fade" id="monModal">

        	<div class="modal-dialog" >

        		<div class="modal-content">
        			<div class="modal-header">
        			    <h4 class="text-primary"><?= (e($user->name)) ?>'s profile picture</h4>
        				<button type="button" class="close" data-dismiss="modal">X</button>
        			</div>

        		<div class="modal-body">
        			<div class="text-center">
        				<img src="/<?= e($src =($user->profilepic != null) ? $user->profilepic : 'images/default.png') ?>"
        			class="img-thumbnail" width="300" onclick="triggerClick()" id="profileDisplay"/><br>
        			</div>
        			<br>
        			<?php if($_GET['id']==get_session('user_id')): ?>
        			<form method="post" action="change_profile_pic.php" enctype="multipart/form-data" name="upl_frm">
        			<input type="file" name="image" id="image" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImage(this)">
        			<button name="publish2" type="submit" class="btn btn-outline-primary btn-xs" style="float: right; font-style: italic; display:none;" id="forprofile">Save </button><i class="fas fa-spinner fa-spin" style="display: none; color: blue;" id="spinnerP"></i>
        			</form>
        			<?php endif; ?>

        		</div>

        		</div>
        	</div>
        </div>
        <!--- Modal for the cover pic    --->
        <div class="modal fade" id="coverModal">

          <div class="modal-dialog" >

            <div class="modal-content">
              <div class="modal-header">
                 <h4 class="text-primary"><?= (e($user->name)) ?>'s cover picture</h4>
                <button type="button" class="close" data-dismiss="modal">X</button>

              </div>

            <div class="modal-body">
              <div class="text-center">
              <img src="/<?= e($src =($user->coverpic != null) ? $user->coverpic : 'images/default.png') ?>"
              class="img-thumbnail" width="500" id="profileDisplay1" onclick="triggerClick1()"/><br>
              </div>
              <br>
              <?php if($_GET['id'] == get_session('user_id')): ?>
              <form method="post" action="change_cover_pic.php" enctype="multipart/form-data" name="upl_frm">
                    <input type="file" name="image" id="image1" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImage1(this)">
        			<button name="publish3" type="submit" class="btn btn-outline-primary" style="float: right; font-style: italic; display:none;" id="forcover">Save </button><i class="fas fa-spinner fa-spin" style="display: none; color: blue;" id="spinnerC"></i>
              </form>
              <?php endif; ?>
            </div>

            <!-- <div class="modal-footer">

            </div>  -->

            </div>
            	<script src="script.js"></script>
          </div>
        </div>

              <!-- END PROFILE && COVER EDITION     --->
              <div id="buttonBox">
                        <div class="row">
                            <div class="col text-left">
                  <h3 class="text-primary" id="username"><?= (e($user->name)) ?> <?= (e($user->nom2)) ?></h3>
             <a href=""><h6 style="color: #44717C;"><i class="fas fa-users"></i> <?= friends_count_wparameter($_GET['id'])?> friend<?= friends_count_wparameter($_GET['id']) ==1 ? '' : 's'?></h6></a>
                            </div>
          <div class="col-md-6 text-right">
        <?php if(get_session('user_id') != $_GET['id']):  ?>
   <?php include('partials/send_msg.php'); ?>
   <a class="btn btn-outline-primary" data-toggle="modal" data-target="#msgModal"><i class="far fa-envelope"></i> Message</a>

        <?php else: ?>
   <?php include('partials/edit_profile.php');?>
   <a class="btn btn-outline-primary" data-toggle="modal" data-target="#editProfileModal"><i class="fas fa-user-cog"></i> update your profile</a>
        <?php endif; ?>
   <!-- Ads  -->
          </div>

                        </div>
              </div>
                <div class="postCard" style="margin-top: 3px;">
                 <div class="galleryCard">
                    <div class="card">
                        <div class="card-body">
            <?php if(count($photos) != 0): ?>
              <?php foreach($photos as $row): ?>
               <?php if($row->compressed_img != ""): ?>
               <a href="imageViewer.php?picname=<?= $row->compressed_img ?>"><img src="<?= e($row->compressed_img) ?>" style="margin-top: 0px; width: 150px; height: 150px;" class="img-thumbnail"></a>
               <?php else: ?>
               <a href="imageViewer.php?picname=<?= $row->url ?>"><img src="<?= e($row->url) ?>" style="margin-top: 0px; width: 150px; height: 150px;" class="img-thumbnail"></a>
               <?php endif; ?>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-primary">No photos yet</p>
            <?php endif; ?>
             <!--<a href="ugallery.php?id=<?= get_session('user_id') ?>"><button class="btn btn-outline-primary" width="250" >+</button></a> -->
                        <!-- Avis des followers -->
              <?php if(get_session('user_id') != $_GET['id']): ?>
              <div class="cotationDiv text-center"><br>
                <a class="btn btn-outline-primary" href="hispost.php?id=<?= $_GET['id'] ?>">All <?= $user->name ?> <?= $user->nom2 ?>'s posts</a>
              </div>
              <?php endif; ?>
                           <!-- End avis -->
                        </div>
                    </div>

                </div>
        <div class="col-md-12 text-center">
        <br>
       <?php if(!empty($_GET['id']) && $_GET['id'] !== get_session('user_id')): ?>
             <?php include('partials/_relation_links.php'); ?>
       <?php endif; ?>
        </div>

            <div class="pubCard" id="all_post">


            </div>

        </div>
    </div>
</div>
</div>
<div class="col-lg-2 offset-fixed f-right">
    <div class="side-right">
        <div class="h7 text-center">Friends </div>
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


<script type="text/javascript">
       $('#forcover').click(function(){
          $("#spinnerC").show();
        });
        $('#forprofile').click(function(){
          $("#spinnerP").show();
        });

        $('#image1').on('change',function(event){
          $("#forcover").show();
        });

        $('#image').on('change',function(event){
          $("#forprofile").show();
        });

      fetch_incomming_msg();
			fetch_online_user();
			update_last_activity();

      setInterval(function(){
      fetch_incomming_msg();
			fetch_online_user();
			update_last_activity();
		},14000);

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

        var limit = 3;
        var start = 0;
        var limit2= 7;
				var from = 0;
        var action= 'inactive';
        function load_data(limit,start){
          $.ajax({
            url:"ajax/fetch_current_user_post_ajax.php",
            method:"POST",
            data:{limit:limit, start:start},
            cache:false,
            beforeSend: function(){
                    //alert("Boom");
                },
            success:function(data)
            {
              $('#all_post').html(data);
            }
          })
        }

        if(action == 'inactive')
        {
          action = 'active';
          load_data(limit,start);

        }

       $(window).scroll(function(){
           if($(window).scrollTop() + $(window).height() > $("#all_post").height() && action == 'inactive')
           {
            action = 'active';
            start = start + limit;
            limit = limit+7;
            setTimeout(function(){
              load_data(limit,start);
            },1000);
           }
        });

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
                 beforeSend: function(){
                  if(action == "like"){
                    $("#like"+micropostId).hide();
                    $("#unlike"+micropostId).fadeIn('fast');

                  }else{
                    $("#like"+micropostId).fadeIn('fast');
                    $("#unlike"+micropostId).hide();
                  }
                },
                success: function(likers){
                   load_data(limit2,from);
                }

            });
        });

				$(".timeago").timeago();
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

				function update_last_activity()
				{
					$.ajax({
						url:"ajax/update_last_activity.php",
						success:function()
						{

						}
					})
				}

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
                  $('#display_last_comment'+post_id).hide();
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
            load_data(limit2,from);
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
             load_data(limit2,from);
            }
          })

        });

        $(document).on('click','.unlike_comment',function(){
          var poster_id = $(this).data('poster_id');
          var comment= $(this).data('comment');
          var post= $(this).data('post');
          var commentid= $(this).data('commentid');
          var action = 'unlike_comment';
          $.ajax({
            url:"action.php",
            method:"POST",
            data:{poster_id:poster_id,comment:comment,post:post,commentid:commentid,action:action},
            success:function(data)
            {
             load_data(limit2,from);
            }
          })

        });

</script>

<!-- SCRIPT -->


</body>
