                <div class="modal fade" id="monModalCover">
            <div class="modal-dialog modal-md" >
                
                <div class="modal-content">
                  <?php if(get_session('user_id')== get_session('cr_i')): ?>
                    <div class="modal-header" style="background-color: white;">
                    	<h4 style="color:#44717C;">Edit cover photo</h4>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
   
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                  <?php endif; ?>
                    
                <div class="modal-body" style="background-color: #e9ebee;">
                  <img src="<?= e($src =($place->coverpic != null) ? $place->coverpic : 'images/place_cover.jpg') ?>"  alt="<?= e($user->name) ?>" style="width: 650px;" class="img-thumbnail img-responsive">
                  <?php if(get_session('user_id')== get_session('cr_i')): ?>
                <form action="placeCoverUploader.php" method="post" enctype="multipart/form-data"> 
                      <div class="row">
                      		<div class="col-md-6">
                      		<input type="file" name="image" required="required" accept=".jpeg,.jpg, .png, .gif">	
                      		</div>
                      		<div class="col-md-6">
                      		<div class="form-group mb-0 status-post-submit">
                                                <button type="submit" name="coverUploader" class="btn btn-outline-primary btn-xs" style="float: right; margin-top: 3px;">📎 Post</button>
                            </div>
                      		</div>
                       </div>
        </form>
          <?php endif; ?>  
        <!-- /.row -->

                </div>
                    
                </div>
            </div>
        </div>
        