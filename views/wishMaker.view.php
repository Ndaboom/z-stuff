
<?php $title="Wish maker";?>

	<?php 
	require "includes/functions.php";
	include('partials/_header.php');?>
<body style="z-index: 99; position: relative;height: 90%;">
<div style="position: relative; padding-top: 60px; width:100%;" class="card">
    <div class="card-body wishBody" id="wishBody">
      <div class="d-flex">
                                    <div>
                                        <img src= "/<?= e($src =($user->profilepic != null) ? $user->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>"   alt="image" class="rounded-circle" style="height: 60px; width: 60px; border:1.5px solid #f5f6fa;" >
                                    </div>
                                    <div class="col">
                                            <div class="form-group mb-0">
                                                <label class="sr-only" for="content">Make a wish</label>
                                                <textarea class="form-control border-0 textbox" name="content" id="content" rows="3" placeholder="Your wish to <?= e($user->name)?>" maxlength="50" require="require" style="font-style: italic;" ></textarea>
                                            </div>
                                    </div>
     </div>
        
    </div>
    <div class="card-footer">
        <div class="row" style="padding:5px;">
            <div class="card blue" style="border-radius :50%; background:blue;" id="blue">
             <div class="card-body"></div> 
            </div>
            <div class="card pink" style="border-radius :50%; background:pink;" id="pink">
             <div class="card-body"></div>
            </div>
            <div class="card yellow" style="border-radius :50%; background: yellow;" id="yellow">
             <div class="card-body"></div>   
            </div>
            <div class="card gray" style="border-radius :50%; background: gray;" id="gray">
             <div class="card-body"></div>   
            </div>
            <div class="card truePink" style="border-radius :50%; background: #FF00B3;" id="truePink">
             <div class="card-body"></div>   
            </div>
            <div class="card black" style="border-radius :50%; background: black;" id="black">
             <div class="card-body"></div>   
            </div>
            <img src= "/flags/drc_flag.jpg"  alt="DRC flag" id="drc_flag"  alt="image" class="rounded-circle drc_flag" style="height: 50px; width: 50px; border:1.5px solid #f5f6fa;" >
        </div>
    </div>
     <div>
    <a class="btn btn-primary send" style ="margin-top:15px;border-radius: 5px 5px 5px 5px; width:100%;" id="send"><i class="far fa-paper-plane"></i> Send </a><br>
    <div class="text-center">
    <i class="fas fa-spinner fa-spin" style="display: none; color: blue;" id="spinnerSh"></i>
    </div>
    <a class="btn btn-ouline-success success" style ="margin-top:15px;border-radius: 5px 5px 5px 5px; width:100%; display:none;" id="success"><i class="far fa-paper-plane"></i> Sent </a>
    </div>
</div>
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <script type="text/javascript">
    	$(document).ready(function() {
    	 var color="";   
    	$('.blue').click(function() {
    	color= $(this).attr("id");
        $('.wishBody').css({
        'background': 'blue'
        });
        $('.textbox').css({
        'background': 'blue'
        });
        });
        
        $('.pink').click(function() {
        color= $(this).attr("id");
        $('.wishBody').css({
        'background': 'pink'
        });
        $('.textbox').css({
        'background': 'pink'
        });
        });
        $('.yellow').click(function() {
        color= $(this).attr("id");
        $('.wishBody').css({
        'background': 'yellow'
        });
        $('.textbox').css({
        'background': 'yellow'
        });
        });
        
        $('.gray').click(function() {
        color= $(this).attr("id");
        $('.wishBody').css({
        'background': 'gray'
        });
        $('.textbox').css({
        'background': 'gray'
        });
        });
        
        $('.black').click(function() {
        color= $(this).attr("id");
        $('.wishBody').css({
        'background': 'black'
        });
         $('.textbox').css({
        'background': 'black'
        });
        });
        
        $('.truePink').click(function() {
        color= '#FF00B3';
        $('.wishBody').css({
        'background': '#FF00B3'
        });
        $('.textbox').css({
        'background': '#FF00B3'
        });
        });
        
        $('.drc_flag').click(function() {
        color= 'flags/drc_flag.jpg';
        $('.wishBody').css({
        'background-image': 'url("/flags/drc_flag.jpg")'
        });
        
         $('.textbox').css({
         'opacity' : '0.5',
         'font-weight' : 'bold'
         });
        });
        
        $('.send').click(function() {
          var wish = $("#content").val();
          if(wish != '')
         {
          $.ajax({
            url:"ajax/send_wish.php",
            method:"POST",
            data:{wish:wish,color:color},
           beforeSend: function(){
            $("#spinnerSh").show();
            },
           success:function(data)
           {
            $("#spinnerSh").hide();
            $("#send").hide();
            $("#success").show();
           } 
          })
         }
          
        });

        

    	});	
    </script>