<?php
$title="Messaging page";
  require "includes/functions.php";
  include('partials/_header.php');
  ?>
  <link rel="stylesheet" href="assets/css/message/style.css">
<body style="margin-top: 65px; overflow-x: hidden; overflow-y:auto;">
  <div class="row">
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <div id="user_details">
            
          </div>
          <div class="d-flex justify-content-center" style="display: none;">
            <i class="fas fa-spinner fa-spin" style="display: none; color: blue; margin-top: 10px;" id="spinner1"></i>
         </div>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
         <div id="user_model_details"></div> 
        </div>
      </div>
    </div>
  </div>

</body>
    <!--SCRIPT -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js" ></script>
   <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
   <script src="assets/js/emojionearea.min.js"></script>
   
  <script type="text/javascript" src="js/messager.js"></script>
