<!doctype html>
<?php 
 session_start();
 include('android/partials/header.php'); ?>
 <style type="text/css">
 	body,
  html {
    margin: 0;
    padding: 0;
    height: 100%;
    background-image: url('../assets/css/homebackground.jpg');
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
  	font-size:16px;
  }
  
 </style>
<body>
	<div class="container h-100">
		<div class="d-flex justify-content-center h-100">
			<div class="card">
                 <div class="card-body">
        <?php if(isset($_GET['msg'])): ?>
          <div class="d-flex justify-content-center">
				    <p class="text-center word">Activation code sent successfully, check your mail box</p><br>
				</div>
        <?php else: ?>
        <div class="d-flex justify-content-center">
				    <p class="text-center word">We just sent an email/sms at <b><?= $_GET['email'] ?></b> containing your account activation code...</p><br>
				</div>
        <?php endif; ?>
				<form method="post" autocomplete="off">
				<div class="d-flex justify-content-center form_container">
						<div class="input-group mb-2">
							<div class="input-group-append">
								<span class="input-group-text">AC</span>
							</div>
							<input type="number" name="activation_code" class="form-control" value="" placeholder="Activation code" required="required">
						</div>
				</div>
				<div class="d-flex justify-content-center mt-3 log_container">
					<button type="submit" name="validate" class="btn log_btn">Validate</button>
				</div>
                </form>
				<div class="mt-4">
					<div class="d-flex justify-content-center links">
						<a href="inscription.php?action=restart">Create an account</a> | <a href="phpMailer/index.php?email=<?= $_GET['email'] ?>&device=<?= $_GET['device'] ?>"> Resend code?</a>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</body>



