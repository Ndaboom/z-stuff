  
<?php $title="Password recover page";
      include('partials/_header.php');?>
    <body style="background-color: #e9ebee;" >
	<div id="main-content" style="margin-top: 90px;">
      <div class="container" >
	  <div class="row" >
		<div class="col-md-6 ">
		         <div class="card " style="height: auto; margin-left: auto; margin-bottom: auto; width: 490px;background-color: #FFF;">
                   <div class="card-header">
                    <h3>Reset password</h3>
                    <small>A new password will be sent to your email address</small>
                       </div>
                          <div class="card-body">
                            <?php include ('partials/_error.php');?>
							<form method="post" autocomplete="off">
							   <div class="form-group">
							    <label for="current_password">Your email address <span class="text-danger">*</span></label>
								<input type="email" name="email" id="email" class="form-control"
								style="width: 100%;" 
								required="required"/>
							</div>
							    <input type="submit" class="btn btn-primary" value="Validate" name="validate" style="width:100%;">
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