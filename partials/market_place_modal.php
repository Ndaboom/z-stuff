        <div class="modal fade" id="monModal1">
            
            <div class="modal-dialog modal-lg" >
                
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                        <nav style="background-color: white;" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="index.php"> Marketplace</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                    
                <div class="modal-body" style="background-color: #e9ebee;"> 
                      <div class="row">
           <!-- Affichage des produits -->
                        <?php if(count($products) !=0): ?>
                            <?php foreach ($products as $product): ?>
          <div class="col-md-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="about_product.php?pr_i=<?= $product->id ?>"><img class="card-img-top" src="<?= e($src =($product->object_view1 != null) ? $product->object_view1 : 'http://placehold.it/700x400') ?>" alt="" width="600" height="250"></a>
              <div class="card-body text-center">
                <h4 class="card-title">
                  <a href="about_product.php?pr_i=<?= $product->id ?>"><?= $product->object_name ?></a>
                </h4>
                <!-- <h5><?= $product->object_price ?></h5> -->
            <!--    <p class="card-text">A propos</p> -->
              </div>
              <div class="card-footer text-center">
                <?php if(get_session('user_id')== get_session('cr_i')): ?>
                <a href="#" class="btn btn-outline-primary disabled" ><?= $product->object_interaction?> <?= $product->object_price ?></a>
                <a href="delete_product.php?id=<?= $product->id ?>" class="btn btn-outline-danger">Remove</a>
              <?php elseif($product->object_interaction =="Aucune"): ?>
                <a href="#" class="btn btn-outline-primary">Voir</a>
              <?php else: ?>
              <a href="#" class="btn btn-outline-primary order" data-pr_i="<?= $product->id  ?>" data-action="<?= $product->object_interaction ?>" data-designation="<?= $product->object_name ?>" data-object_price="<?= $product->object_price ?>" 
                  data-image="<?=$product->object_view1?>" ><?= $product->object_interaction?> <?= $product->object_price ?></a>
              <small class="text-success" id="ordererm<?= $product->id ?>" style="display:none;">added <i class="fas fa-shopping-basket"></i></small>
            <?php endif; ?>
              </div>
            </div>
          </div>
           <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center"> No items available for the moment</p>
                      <?php endif; ?>
          <!-- Fin du chargement du marketplace -->
        </div>
        <!-- /.row -->

                </div>
                <?php if(get_session('user_id') == get_session('cr_i')): ?>
                <div class="modal-footer">
                <div class="card">
                          <div class="card-body">
                            <h6 style="color: #44717C;"><i class="fas fa-pen"></i> Add to the marketplace:</h6>
                            <form action="marketplace_add_product.php" method="post" enctype="multipart/form-data">
                           <div class="row"> 
                            <div class="col-md-6">
                               <div class="form-group mb-0">
                               <input type="text" class="form-control" placeholder="Name (product, object) ..." id="object_name" name="object_name"
                              required="require"/> 
                            </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group mb-0">
                            <input type="text" class="form-control" placeholder="price" value="$" id="object_price" name="object_price"
                              required="require"/><br>
                            </div>
                            </div> 
                            <div class="col-md-6">
                               <div class="form-group mb-0">
                                <label for="image">Add an image<span class="text-primary">*</span></label>
                                <input type="file" name="image" id="image1" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImage1(this)"/> 
                                <h3 onclick="triggerClick1()" ><i class="fas fa-upload"></i></h3>
                               <div id="Imagepreview1">
                               <img class="img-thumbnail img-responsive" id="profileDisplay1"/>   
                               </div>
                             </div>
                            </div>
                            <script src="../script.js"></script>
                            <div class="col-md-6">
                              <div class="form-group mb-0">
                            <label for="object_interaction">Interaction with visitors<span class="text-primary">*</span></label>
                             <select required="required" name="object_interaction" id="object_interaction" class="form-control">
                                         <option value="Acheter">
                                         For sale
                                         </option >
                                         <option value="Reserver">
                                         To book
                                         </option >
                                         <option value="Louer">
                                         To rent
                                         </option >
                                         <option value="Aucune">
                                         No interaction
                                         </option >
                                    </select ><br>
                            </div> 
                            </div>
                            <div class="col-md-12 text-center">
                              <button type="submit" name="add_product" class="btn btn-outline-primary btn-xs"> +Add</button>
                            </div>
                          </div>
                          </form> 
                          </div>
                        </div>                
                </div>
                <?php endif; ?>    
                </div>
            </div>
        </div>
        