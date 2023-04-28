
<?php $title="Profile page edit";?>

	<?php 
	require "includes/functions.php";
	include('partials/_header.php');?>
	
    <body style="background-color: #e9ebee;">
	<div id="main-content" style="margin-top: 90px;">
      <div class="container" >
	  <div class="row" >
	   
<?php if (!empty($_GET['id']) && $_GET['id']=== get_session('user_id')): ?>

		<div class="col-md-6 ">
		         <div class="card">
                   <div class="card-header">
                    <h3 class="">Complete your profile</h3>
                       </div>
                          <div class="card-body">
                            <?php include ('partials/_error.php');?>
							<form method="post" autocomplete="off" enctype="multipart/form-data">
							<div class="row">
							<div class="col-md-6">
							   <div class="form-group">
							    <label for="name">First name<span class="text-danger">*</span></label>
								<input type="text" name="name" id="name" class="form-control"
								placeholder="Sam" value="<?= get_input('name') ? get_input('name') : e($user->name)?>"
								required="required"/>
							    </div>
						</div>
							<div class="col-md-6">
							  <div class="form-group">
							<label for="city">City<span class="text-danger">*</span></label>
						    <input type="text" name="city" id="city" class="form-control" value="<?= get_input('city') ? get_input('city') : e($user->city)?>"
								required="required"/>
							    </div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="avatar"> Change my profile pic</label>
										<input type="file" name="profile_image" id="profile_image" accept="image/*">
										<?php
										if($user->profilepic != '')
										{
                                          echo '
                                           <img src="'.$user->profilepic.'" class="img-thumbnail"
                                           width="150" />
                                          ';
                                          echo '<input type="hidden" name="profile_image" value="'.$user->profilepic.'" />';
										}
										?>
									</div>
								</div>
								
							</div>
			
							<div class="row"> 
							<div class="col-md-6">
							   <div class="form-group">
							    <label for="country">Country<span class="text-danger">*</span></label>
								<input type="text" name="country" id="country" class="form-control" value="<?= get_input('country') ? get_input('country') : e($user->country)?>"
								required="required"/>
							    </div>
								 </div>
								  <div class="col-md-6">
								     <div class="form-group">
									     <label for="sex">Sexe<span class="text-danger">*</span></label>
										 <select required="required" name="sex" id="sex" class="form-control">
										 <option value="H" <?= $user->sex == "H" ? "selected" : ""?>>
										 Man
										 </option >
										 <option value="F" <?= $user->sex == "F" ? "selected" : ""?>>
										 Woman
										 </option >
									</select >
									</div >
							</div >
							</div >
						    
							<div class="row">
							<div class="col-md-6">
							   <div class="form-group">
							    <label for="twitter">Twitter:</label>
								<input type="text" name="twitter" id="twitter" class="form-control" value="<?= get_input('twitter') ? get_input('twitter') : e($user->twitter)?>"/>
							    </div>
								 </div>
							<div class="col-md-6">
							   <div class="form-group">
							    <label for="github">Github:</label>
								<input type="text" name="github" id="github" class="form-control" value="<?= get_input('github') ? get_input('github') : e($user->github)?>"/>
							    </div>
								 </div>
							</div>
						<div class="row">
							<div class="col-md-6">
							   <div class="form-group">
							    <label for="dbirth">Date of birth :</label>
								<input type="date" name="dbirth" id="dbirth" class="form-control" value="<?= get_input('dbirth') ? get_input('dbirth') : e($user->dbirth) ?>"/>
							    </div>
								 </div>
							<div class="col-md-6">
							   <div class="form-group">
							    <label for="profession"> Profession:</label>
								<input type="text" name="profession" id="profession" class="form-control" value="<?= e($user->profession)?>"/>
							    </div>
								 </div>
						    <div class="col-md-6">
							    <div class="form-group">
									     <label for="relationshipStatus">Relationship status : </label>
										 <select required="required" name="relationshipStatus" id="relationshipStatus" class="form-control">
										 <option value="Single" <?= $user->relationshipStatus == "Single" ? "selected" : ""?>>
										 Single
										 </option >
										 <option value="Married" <?= $user->relationshipStatus == "Married" ? "selected" : ""?>>
										 Married
										 </option >
										  <option value="Engaged" <?= $user->relationshipStatus == "Engaged" ? "selected" : ""?>>
										 Engaged
										 </option >
										  <option value="Its complicated" <?= $user->relationshipStatus == "Its complicated" ? "selected" : ""?>>
										 Its complicated
										 </option >
										 <option value="In a relationship" <?= $user->relationshipStatus == "In a relationship" ? "selected" : ""?>>
										 In a relationship
										 </option >
										 <option value="Widowed" <?= $user->relationshipStatus == "Widowed" ? "selected" : ""?>>
										 Widowed
										 </option >
										 <option value="Divorced" <?= $user->relationshipStatus == "Divorced" ? "selected" : ""?>>
										 Divorced
										 </option >
									</select >
									</div >
								 </div>
						    <div class="col-md-6">
							   <div class="form-group">
							    <label for="religion">Religion : </label>
										 <select required="required" name="religion" id="religion" class="form-control">
										 <option value="Christian" <?= $user->religion == "Christian" ? "selected" : ""?>>
										 Christian
										 </option >
										 <option value="Muslim" <?= $user->religion == "Muslim" ? "selected" : ""?>>
										 Muslim
										 </option >
										  <option value="Catholic" <?= $user->religion == "Catholic" ? "selected" : ""?>>
										 Catholic
										 </option >
									</select >
							    </div>
								 </div>

						<div class="col-md-12">
							   <div class="form-group">
							     <div class="form-group">
							    <label for="available_for_hiring"><input type="checkbox" name="available_for_hiring"
id="available_for_hiring" <?= $user->available_for_hiring ? "checked" : ""?>/>
								Available for job?
								</label>
					     </div>
						</div>
					    </div>
						
			    <div class="row">
				 <div class="col-md-12">
				 <div class="form-group">
				<label for="bio">Biographie<span class="text-danger">*</span></label>
				<textarea name="bio" id="bio" cols="75" rows="05" class="form-control"
				placeholder="I'm ..."><?= get_input('bio') ? get_input('bio') :e($user->bio)?>
</textarea>
				
				       </div>
					  <input type="submit" id="update" class="btn btn-primary" value="Validate" name="update"/> 
				   </div>
				 	   
				</div> 
			</form>			
		 </div>
        </div>
    </div>
    	<? endif; ?>	
    	</div>
    	</div>
    	</div>	 
    	</body>
    	 <script src="assets/js/jquery.min.js"></script>
    	 <script src="libraries/uploadify/jquery.uploadify.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script type="text/javascript">
    	fetch_incomming_msg();

         setInterval(function(){
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
    	 $('#image').on('change', function(event){
           var action='preview';
           $.ajax({
            url:"action.php",
            method:"POST",
            data:{action:action},
            success:function(data)
            {
              alert(data);
              $('#Imagepreview').html(data);
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

    </script>

  
</html>