  
<?php $title="Password changing page";?>

	<?php 
	require "includes/functions.php";
	include('partials/_header.php');?>	
    <body style="background-color: #e9ebee;" >
	<div id="main-content" style="margin-top: 90px;">
      <div class="container" >
	  <div class="row" >
		<div class="col-md-6 ">
		         <div class="card col-md-offset-3" style="height: auto; margin-left: auto; margin-bottom: auto; width: 490px;background-color: #FFF;">
                   <div class="card-header">
                    <h3>Change my password</h3>
                       </div>
                          <div class="card-body">
                            <?php include ('partials/_error.php');?>
							<form method="post" autocomplete="off">
							<div class="row">
							<div class="col-md-6">
							   <div class="form-group">
							    <label for="current_password">Actual password :<span class="text-danger">*</span></label>
								<input type="password" name="current_password" id="current_password" class="form-control"
								style="width: 350px;" 
								required="required"/>
							</div>
							<div class="form-group">
							    <label for="new_password">New password :<span class="text-danger">*</span></label>
						        <input type="password" name="new_password" id="new_password" class="form-control" style="width: 350px;" 
								required="required"/>
							</div>
							<div class="form-group">
								 <label for="password_confirmation">Password confirmation :<span class="text-danger">*</span></label>
								<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" style="width: 350px;"
								required="required"/>
							   </div>
							    <input type="submit" class="btn btn-primary" value="Validate" name="change_password">
						</div>
				</div>
			</form>			
		 </div>
        </div>
    </div>
    	</div>
    	</div>
    	</div>	 
    	</body>
    	 
<?php include('partials/footer.php');?>
  
</html>