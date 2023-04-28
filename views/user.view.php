<!doctype html>
<?php 
 session_start();
 include('partials/_header.php'); ?>
 <style type="text/css">
 	body,
  html {
    margin: 0;
    padding: 0;
    height: 100%;
    background-image: url('/assets/css/homebackground.jpg');
    background-size: cover;
    background-repeat: no-repeat;

  }
  .input-group-text {
    background: #008CD0 !important;
    color: white !important;
    border: 0 !important;
    border-radius: 0.25rem 0 0 0.25rem !important;
  }
  .card{
    border-radius: 5px;
    margin-right: auto;
    margin-left: auto;
    margin-top: auto;
    margin-bottom: auto;
    max-height: 330px;
    width: 430px;
  }
  .log_btn {
    width: 100%;
    background: #008CD0 !important;
    color: white !important;
  }
  .log_container {
    padding: 0 2rem;
  }
  .word{
  	font-family:georgia,garamond,serif;
  	font-size:16px;
  	font-style:italic;
  }
  
 </style>
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="card">
                 <div class="card-body">
				<div class="d-flex justify-content-center">
				    <small class="text-center word">Hi <?= $user->name ?>, a new password has been sent to your email address you can change it any time...</small>
				</div>
				<div class="d-flex justify-content-center mt-3 log_container">
					<a href="login.php" name="login" class="btn log_btn">Login</a>
				</div>
			</div>
		</div>
	</div>
</body>