                <div class="modal fade" id="productImageUpdaterModal1">
            <div class="modal-dialog modal-md" >
                
                <div class="modal-content">
                <div class="modal-body" style="background-color: #e9ebee;">
                <img src="<?= $product->object_view1 ?>"  alt="<?= e($product->object_name) ?>" class="img-thumbnail img-responsive">
                <form action="productImg1Uploader.php" method="post" enctype="multipart/form-data"> 
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
