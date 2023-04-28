                <div class="modal fade" id="productImageUpdaterModal2">
            <div class="modal-dialog modal-md" >
                
                <div class="modal-content">
                <div class="modal-body" style="background-color: #e9ebee;">
                <?php if($product->object_view2 != null):  ?>
                <img src="<?= $product->object_view2 ?>"  alt="<?= e($product->object_name) ?>" class="img-thumbnail img-responsive">
                <?php endif; ?>
                <form action="productImg2Uploader.php" method="post" enctype="multipart/form-data"> 
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
