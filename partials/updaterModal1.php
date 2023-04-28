                <div class="modal fade" id="placeImageUpdaterModal1">
            <div class="modal-dialog modal-md" >
                
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                    	<h4 style="color:#44717C;">Edit the first image</h4>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
   
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                    
                <div class="modal-body" style="background-color: #e9ebee;">
                <img src="<?= e($src =($places->image != null) ? $places->image : 'images/place_cover.jpg') ?>"  alt="<?= e($user->name) ?>" class="img-thumbnail img-responsive">
                <form action="placeImg1Uploader.php" method="post" enctype="multipart/form-data"> 
                      <div class="row">
                      		<div class="col-md-6">
                      		<input type="file" name="image" required="required" accept=".jpeg,.jpg, .png, .gif">	
                      		</div>
                      		<div class="col-md-6">
                      		<div class="form-group mb-0 status-post-submit">
                                                <button type="submit" name="coverUploader" class="btn btn-outline-primary btn-xs" style="float: right; margin-top: 3px;">📎 Upload</button>
                            </div>
                      		</div>
        </div>
        </form>
           
        <!-- /.row -->

                </div>
                
                <!-- <div class="modal-footer">
                                
                </div>  -->
                    
                </div>
            </div>
        </div>
