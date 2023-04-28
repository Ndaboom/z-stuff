<div class="modal fade" id="editProfileModal">
            
<div class="modal-dialog modal-lg" >
    
    <div class="modal-content"> 
    <div class="modal-header text-center">
    <div class="modal-title">Your profile</div>	
    </div>
    <div class="modal-body">
      <!-- START FORM  -->
<form method="post" autocomplete="off">
	<div class="row text-left">
	<div class="col">
	   <div class="form-group">
	    <label for="name"><b>First name</b><span class="text-danger">*</span></label>
		<div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="fas fa-user"></i></span>
		</div>
		<input type="text" name="name" id="name" class="form-control"
placeholder="Sam" value="<?= get_input('name') ? get_input('name') : e($user->name)?>"
required="required"/>
        </div>
	    </div>
</div>

	<div class="col">
	  <div class="form-group">
	<label for="city"><b>Lastname</b><span class="text-danger">*</span></label>
	<div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="fas fa-users"></i></span>
		</div>
		<input type="text" name="nom2" id="nom2" class="form-control" value="<?= get_input('nom2') ? get_input('nom2') : e($user->nom2)?>"
		required="required"/>
    </div>
	    </div>
		</div>
	</div>
	<div class="row text-left">
	<b style="padding-left: 15px;"><i class="fas fa-map-marker-alt"></i> Location</b>	
	</div>
	<div class="row text-left">
	  <div class="col">
	   <div class="form-group">
	<label for="city">City</label>
	<div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="fas fa-city"></i></span>
		</div>
		<input type="text" name="city" id="city" class="form-control" value="<?= get_input('city') ? get_input('city') : e($user->city)?>"
		required="required"/>
    </div>
	    </div>   
	  </div>
	  <div class="col">
	    <div class="form-group">
	    <label for="country">Country</label>
	    <div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="far fa-flag"></i></span>
		</div>
		<input type="text" name="country" id="country" class="form-control" value="<?= get_input('country') ? get_input('country') : e($user->country)?>"
		required="required"/>
        </div>
	    </div>   
	  </div>
	</div>
	<div class="row text-left">
	<b style="padding-left: 15px;" ><i class="fas fa-users"></i>  Social links</b>	
	</div>
	<div class="row text-left"> 
	<div class="col">
	  <div class="form-group">
	    <label for="country">Instagram</label>
	    <div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="fab fa-instagram"></i></span>
		</div>
		<input type="text" name="instagram" id="instagram" class="form-control" value="<?= get_input('instagram') ? get_input('instagram') : e($user->instagram)?>"
		/>
        </div>
	    </div> 
	</div>
		<div class="col">
	   <div class="form-group">
	    <label for="twitter">Twitter:</label>
	    <div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="fab fa-twitter"></i></span>
		</div>
		<input type="text" name="twitter" id="twitter" class="form-control" value="<?= get_input('twitter') ? get_input('twitter') : e($user->twitter)?>"/>
        </div>
	    </div>
		 </div>
		  
	</div >
    
	<div class="row text-left">

	<div class="col">
	   <div class="form-group">
	    <label for="github">Github:</label>
	    <div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="fab fa-github"></i></span>
		</div>
		<input type="text" name="github" id="github" class="form-control" value="<?= get_input('github') ? get_input('github') : e($user->github)?>"/>
        </div>
	    </div>
		 </div>
	</div>
	<div class="row text-left">
	<i class="fas fa-user-lock" style="padding-left: 15px;"></i>   <b>  Confidential informations</b>
	</div>
    <div class="row text-left">
	<div class="col">
	   <div class="form-group">
	    <label for="dbirth">Birth date :</label>
	     <div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="fas fa-address-card"></i></span>
		</div>
		<input type="date" name="dbirth" id="dbirth" class="form-control" value="<?= get_input('dbirth') ? get_input('dbirth') : e($user->dbirth) ?>"/>
        </div>
	    </div>
		 </div>
		 <div class="col">
		     <div class="form-group">
			     <label for="sex">Sexe </label>
				 <select required="required" name="sex" id="sex" class="form-control">
				 <opion value="...">
				     ...
				 </opion>
				 <option value="H" <?= $user->sex == "H" ? "selected" : ""?>>
				 Man
				 </option >
				 <option value="F" <?= $user->sex == "F" ? "selected" : ""?>>
				 Woman
				 </option >
			</select >
			</div >
	</div >
</div>
	<div class="row text-left">
	<div class="col">
	   <div class="form-group">
	    <label for="profession"> Profession:</label>
	    <div class="input-group mb-3">
		<div class="input-group-append">
			<span class="input-group-text"><i class="fas fa-briefcase"></i></span>
		</div>
		<input type="text" name="profession" id="profession" class="form-control" value="<?= e($user->profession)?>"/>
        </div>
	    </div>
		 </div>
    <div class="col">
	    <div class="form-group">
			     <label for="relationshipStatus">R status : </label>
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
	</div>
		<div class="row text-left">
		 <div class="col">
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
		<div class="col text-left">
	    <div class="form-group">
			     <div class="form-group">
			    <label for="available_for_hiring"><input type="checkbox" name="available_for_hiring"
                id="available_for_hiring" <?= $user->available_for_hiring ? "checked" : ""?>/>
				Available for hiring?
				</label>
	     </div>
		</div>
		</div>
		</div>

		<div class="row text-left">
				 <div class="col">
				 <div class="form-group">
				<label for="bio">Biography <small>(Public) </small>	<span class="text-danger">*</span></label>
				<textarea name="bio" id="bio" cols="75" rows="05" class="form-control"
				placeholder="I'm ..."><?= get_input('bio') ? get_input('bio') :e($user->bio)?></textarea>
				
				       </div>
				    </div>
	    </div>
	    <div class="text-center">
      <input type="submit" class="btn btn-outline-primary" value="Save" name="update"/>
		</div>
</form>
      <!-- END FORM  -->
    </div>
    </div>
</div>
</div>