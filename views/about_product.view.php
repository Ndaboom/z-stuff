<?php $title="$product->object_name";?>

    <?php 
    require ('includes/functions.php');
    include('partials/_header.php');
    require('config/database.php');
    $_SESSION['pr_i']= $product->id;
    $_SESSION['product_img1']= $product->object_view1;
    $_SESSION['product_img2']= $product->object_view2;
    ?>
<body style="margin-top: 60px;">
<div class="row">
	<div class="col-md-8">
	 <div class="card">
 	<div class="card-body">
 	<b style="font-family:georgia,garamond,serif;font-size:25px;font-style:italic;"><?=  $product->object_name  ?></b><br>
 	<div class="row">
 		<div class="card">
          <div class="card-body">
          	<div class="row">
          	<img src="<?= $product->object_view1 ?>" class="img-thumbnail img-responsive" width="400" data-toggle="modal" data-target="#productImageUpdaterModal1" >
          	<img src="<?= $product->object_view2 ?>" class="img-thumbnail img-responsive" width="400" data-toggle="modal" data-target="#productImageUpdaterModal2">	
          	</div>
          	<div class="row">
          		<?php if($product->object_view3 != null):   ?>
          	<img src="<?= $product->object_view3 ?>" class="img-thumbnail img-responsive" width="400">
          	    <?php endif; ?>
          	<?php if($product->object_about != null): ?>
          	<b>About :</b>
            <p><?= nl2br(e($product->object_about)) ?></p>
          	<?php endif; ?>
          	</div>
          </div> 			
 		</div>
 	</div>	
 	</div>
 </div>
</div>
<div class="col-md-4">
	<?php if(get_session('user_id') == get_session('cr_i')):  ?>
	<?php include('partials/product_uploader_modal1.php');
	      include('partials/product_uploader_modal2.php');   ?>
 <div class="card">
 	<div class="card-body">
 		<b>Update <?= $product->object_name ?></b><br>
 	<form action="marketplace_edit_product.php?pr_i=<?= get_session('pr_i') ?>" method="post" enctype="multipart/form-data">
                           <div class="row"> 
                            <div class="col-md-6">
                               <div class="form-group mb-0">
                               <input type="text" class="form-control border-0" placeholder="Name (product, object) ..." id="object_name" name="object_name" value="<?= get_input('object_name') ? get_input('object_name') : e($product->object_name)?>"
                              required="require"/> 
                            </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group mb-0">
                            <input type="text" class="form-control border-0" placeholder="price" id="object_price" name="object_price" value="<?= get_input('object_price') ? get_input('object_price') : e($product->object_price)?>"
                              required="require"/><br>
                            </div>
                            </div> 
                            <div class="col-md-6">
                               <div class="form-group mb-0">
                                <input type="text" class="form-control border-0" placeholder="stock" id="object_quantity" name="object_quantity" value="<?= get_input('object_quantity') ? get_input('object_quantity') : e($product->object_quantity)?>"
                              />
                             </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group mb-0">
                                <input type="text" class="form-control border-0" placeholder="stock" id="place_name" name="place_name" value="<?= get_input('place_name') ? get_input('place_name') : e($product->place_name)?>"
                                readonly/>
                             </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group mb-0">
                            <label for="object_interaction">Interaction with visitors</label>
                             <select required="required" name="object_interaction" id="object_interaction" class="form-control">
                             	         <option value="Acheter" <?= $product->object_interaction == "Acheter" ? "selected" : ""?>>
                                         For sale
                                         </option >
                                         <option value="Reserver" <?= $product->object_interaction == "Reserver" ? "selected" : ""?>>
                                         To book
                                         </option >
                                         <option value="Louer" <?= $product->object_interaction == "Louer" ? "selected" : ""?>>
                                         To rent
                                         </option>
                                         <option value="Aucune" <?= $product->object_interaction == "Aucune" ? "selected" : ""?>>
                                         No interaction
                                         </option >
                                    </select ><br>
                            </div> 
                            </div>
                            <div class="col-md-6">
                              <div class="form-group mb-0">
                                <label for="object_quantity">The remaining quantity</label>
                               <input type="number" class="form-control border-0" placeholder="Quantity in stock" id="object_quantity" name="object_quantity" value="<?= get_input('object_quantity') ? get_input('object_quantity') : e($product->object_quantity)?>"
                              required="require"/> 
                            </div>   
                            </div>
                            <div class="col-md-12">
                            <textarea name="object_about" id="object_about" cols="75" rows="05" class="form-control border-0"
				placeholder="<?= $product->object_about ?> features"><?= get_input('object_about') ? get_input('object_about') :e($product->object_about)?>
</textarea>	
                            </div>

                            <br>
                            <div class="col-md-12 text-center">
                              <button type="submit" name="edit_product" class="btn btn-outline-primary btn-xs"> Edit</button>
                            </div>
                          </div>
                          </form> 
 		
 	</div>
 </div>
 <?php endif; ?>	
</div>
</div>
 <!--SCRIPT -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.timeago.js"></script> 
<script src="assets/js/jquery.timeago.fr.js"></script>  


<script type="text/javascript">
    $(document).ready(function() {
        $(".timeago").timeago();
         fetch_incomming_msg();

        setInterval(function(){
           update_last_activity();
           fetch_incomming_msg();
        },5000);

        function update_last_activity()
        {
          $.ajax({
            url:"ajax/update_last_activity.php",
            success:function()
            {

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
        
       
    });

    $(document).ready(function() {
          $('[id^=detail-]').hide();
          $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
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

</body>