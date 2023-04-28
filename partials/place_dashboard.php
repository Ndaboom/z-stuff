        <div class="modal fade" id="monModal">    
            <div class="modal-dialog modal-lg" >
                
                <div class="modal-content" style="background-color: #e9ebee; width:1000px;">
                    <div class="modal-header">
     
                    <h3 style="color: #44717C;" ><?= (e($place->place_name))?> Dashboard</h3>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                    
                <div class="modal-body" >
                  
                <div class="row">
                  <div class="col-lg-4">
                    <div class="card">
                      <div class="card-body">
                        <!----Presentation de l'admin---->
                        <div class="welcomeWord text-center">
                          <h4 style="font-style: italic;">Hi!!!</h4>
                        </div>
                     <div class="row" style="border-bottom: solid 1px #DDDDDD;">
                      <div class="col-md-3">
                    <img src="<?= e($src =($user2->profilepic != null) ? $user2->profilepic : 'images/default.png') ?>" class="rounded-circle" width="40" style="height: 50px; width: 50px; border:1.5px solid #f5f6fa;" >
                      </div>
                      <div class="col-md-8">
                         <h5 style="color: #44717C;"><?= e($user->name) ?></h5>
                         <!-- <h6 style="color: #44717C;"><i class="far fa-eye"> 48 visites cette semaine</i></h6> -->
                      </div>
                     </div>
                        <!----Presentation de l'admin fin---->
          <br>         
          <ul class="list-group">
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-1" data-toggle="detail-1">
                    <div class="col-xs-10">
                       <i class="fas fa-home"></i> Home
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-2" data-toggle="detail-2">
                    <div class="col-xs-10">
                        <i class="fa fa-bell"></i>
                        <?= place_notifications_count()?> Notification<?= place_notifications_count() > 1 ? 's' : ''?>
                    </div>
                </div>
            </li>
             <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-4" data-toggle="detail-4">
                    <div class="col-xs-10">
                        <i class="fas fa-cart-plus"></i> Marketplace
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                 <div class="row toggle" id="dropdown-detail-3" data-toggle="detail-3">
                    <div class="col-xs-10">
                        <i class="fas fa-cog"></i> Parameters
                    </div>
                </div>
            </li>
        </ul><br>
        <div class="text-center">
          <a href="placegallery.php?pl_i=<?= $place->id ?>" class="btn btn-outline-primary"><i class="far fa-images"></i> Manage your images</a>
        </div>                
                         <!----Liste fin ---->
                      </div>
                      
                    </div>
                    
                  </div>
                  <div class="col-lg-8">
                     <div class="card" style="width: 640px;">
                      <div class="card-body">
                      <div class="defaultContent text-center">
                        <h1><i class="far fa-surprise"></i></h1>
                        <h3 style="color: #44717C; font-style: italic;" >Congratulations!!!!</h3>
                        <?php if(followers_count(get_session('pl_i')) > 2): ?>
                        <h6 style="color: #44717C;" >more than <?= followers_count(get_session('pl_i'))-1 ?> person(s) are following</h6>
                        <?php endif; ?>
                        <a class="btn btn-outline-primary"><i class="fas fa-globe-africa"></i> Promote</a>
                      </div>

                         <div id="detail-3">
                    <hr></hr>
                    <div class="container">
                        <div class="fluid-row">
                            <div class="col-xs-1">
                                <h6 style="color: #44717C;" >About that place</h6>
                            </div>
                            <div class="col-xs-5">
                              <form method="post" class ="well" autocomplete="off">
                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="">
                                        <label for="place_name">Name <span class="text-primary">*</span></label>
                                        <input type="text" class="form-control" placeholder="Place name" id="place_name" name="place_name" value="<?= get_input('place_name') ? get_input('place_name') : e($place->place_name)?>" 
                              required="require"/>
                                    </div> 
                                  </div>
                                  <div class="col-md-6">
                                     <div class="">
                                         <label for="category">Define a category <span class="text-primary">*</span></label>
                                         <select required="required" name="category" id="category" class="form-control">
                                         <option value="Residence" <?= $place->category == "Residence" ? "selected" : ""?>>
                                          Residential place
                                         </option >
                                         <option value="commercial" <?= $place->category == "commercial" ? "selected" : ""?>>
                                          Commercial place
                                         </option >
                                         <option value="sport" <?= $place->category == "sport" ? "selected" : ""?>>
                                          Sportive place
                                         </option >
                                         <option value="touristic" <?= $place->category == "touristic" ? "selected" : ""?>>
                                         Touristic place
                                         </option >
                                          <option value="educative" <?= $place->category == "educative" ? "selected" : ""?>>
                                         Educative place
                                         </option >
                                          <option value="Hotel" <?= $place->category == "Hotel" ? "selected" : ""?>>
                                         Place, Hotel
                                         </option >
                                          <option value="Restaurant" <?= $place->category == "Restaurant" ? "selected" : ""?>>
                                         Place, Restaurant
                                         </option >
                                         <option value="Commercial,Industrial" <?= $place->category == "Commercial,Industrial" ? "selected" : ""?>>
                                         Place, Commercial & Industrial
                                         </option >
                                    </select >
                                    </div >

                                    
                                  </div>

                                  
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="city">City<span class="text-primary">*</span></label>
                                         <input type="text" name="city" id="city" class="form-control"  value="<?= get_input('city') ? get_input('city') : e($place->city)?>" 
                                        />
                                         </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="country">Country<span class="text-primary">*</span></label>
                                         <input type="text" name="country" id="country" class="form-control"  value="<?= get_input('country') ? get_input('country') : e($place->country)?>" 
                                         />
                                         </div>
                                  </div>
                                </div>
                                 <div class="row">
                                  <div class="col-md-6">
                                       <div class="form-group">
                                          <label for="email">email<span class="text-primary">*</span></label>
                                         <input type="email" name="email" id="email" class="form-control"
                                         value="<?= get_input('email') ? get_input('email') : e($place->email)?>"
                                         />
                                         </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="number">Phone number<span class="text-primary">*</span></label>
                                         <input type="text" name="number" id="number" class="form-control"
                                         value="<?= get_input('place_contacts') ? get_input('place_contacts') : e($place->place_contacts)?>"/>
                                         </div>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="website">Website<span class="text-primary">*</span></label>
                                         <input type="text" name="website" id="website" class="form-control"
                                         placeholder="https://www." value="<?= get_input('website') ? get_input('website') : e($place->website)?>"/>
                                         </div>
                                  </div>
                                </div>
                                   <div class="form-group">
                                   <label for="description">Short description :<span class="text-primary">*</span></label>
                                   <textarea name="description" id="description" cols="75" rows="02" class="form-control"
                                   placeholder="Short description" value="<?= nl2br(replace_links(e($place->description))) ?>"><?= get_input('description') ? get_input('description') :e($place->description)?>
                                   </textarea>
                                   
                                   </div>
                                    <div class="text-center">
                                        <a><input type="submit" class="btn btn-outline-primary" value="Save" name="insert"/></a>
                                    </div>
                                </form>           
                            </div>
                        </div>
                    </div>
                </div>
                
                         <div id="detail-4">
                    <hr></hr>
                    <div class="container">
                        <div class="card" style="border-bottom:solid 1px #DDDDDD;">
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-6">
                              <h5 style="color: #44717C;"><i class="fas fa-shopping-cart"></i> Marketplace</h5>  
                              </div>
                              <div class="col-md-6">
                                  <?php if(a_marketplace_has_already_been_created()):  ?>
                               <a href="marketplace_desactivator.php" class="btn btn-outline-primary btn-xs" style="float: right; font-style: italic;" ><i class="fas fa-lock"></i> Desactivate</a>
                                  <?php else:?>
                                <a href="marketplace_activator.php" class="btn btn-outline-primary btn-xs" style="float: right; font-style: italic;" ><i class="fas fa-lock-open"></i> Activate</a>
                                  <?php endif; ?>
                              
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-body">
                            <h6 style="color: #44717C;"><i class="fas fa-pen"></i> Add to the marketplace:</h6>
                            <form action="marketplace_add_product.php" method="post" enctype="multipart/form-data">
                           <div class="row"> 
                            <div class="col-md-6">
                               <div class="form-group mb-0">
                               <input type="text" class="form-control" placeholder="Designation (product,object)..." id="object_name" name="object_name"
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
                               <input type="file" name="image"/>
                             </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group mb-0">
                            <label for="object_interaction">Interaction with visitors<span class="text-primary">*</span></label>
                             <select required="required" name="object_interaction" id="object_interaction" class="form-control">
                                         <option value="Acheter">
                                         For sale
                                         </option >
                                         <option value="Reserver">
                                         For book
                                         </option >
                                         <option value="Louer">
                                         For lend
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
                </div>
                 <div id="detail-2">
                    <div class="container">
                        <div class="fluid-row">
                            <div class="col-xs-1">
                                <h5>Notifications :</h5>
                                 <?php if(count($pnotifications) !=0): ?>
                            <?php foreach ($pnotifications as $notification): ?>
                                <!-- Debut de l'affichage des notifications-->
                                
                                <div class="card">
                                  <div class="card-body">
                                   <div class="row">
                                    <?php $user_profile=place_followerspic_displayer($notification->poster_id);
                                          ?>
                                    <?php if($notification->content == "you have 1 follower"): ?>
                                     <div class="col-md-3">
                                     <a href="profile.php?id=<?= $notification->poster_id ?>"><img src="<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a> 
                                     </div>
                                     <div class="col-md-9" style="border-left: solid 1px #DDDDDD;">
                                       <h3 style="color: #44717C;"><?= $notification->content ?></h3>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $notification->posted_at ?>"><?= $notification->posted_at ?></span>
                                     </div>

                                    <?php elseif($notification->content == "post_liked"): ?>
                                      <?php $row=fetch_place_post_data($notification->object_id);  ?>
                                    <div class="col-md-3">
                                     <img src="<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >  
                                    </div>
                                    <div class="col-md-6" style="border-left: solid 1px #DDDDDD;">
                                      <h3 style="color: #44717C;">liked your post</h3>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $notification->posted_at ?>"><?= $notification->posted_at ?></span>
                                    </div>
                                    <div class="col-md-3">
                                      <a href="homeplace.php?pl_i=<?= get_session('pl_i')?>#card<?= $notification->object_id ?>"><img src="<?= $row->urlMedia ?>" class="img-thumbnail" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>
                                    </div>
                                     <?php elseif($notification->content == "has_commented"): ?>
                                      <?php $row=fetch_place_post_data($notification->object_id);  ?>
                                    <div class="col-md-3">
                                     <img src="<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" >  
                                    </div>
                                    <div class="col-md-6" style="border-left: solid 1px #DDDDDD;">
                                      <h3 style="color: #44717C;">has commented</h3>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $notification->posted_at ?>"><?= $notification->posted_at ?></span>
                                    </div>
                                    <div class="col-md-3">
                                      <a href="homeplace.php?pl_i=<?= get_session('pl_i')?>#card<?= $notification->object_id ?>"><img src="<?= $row->urlMedia ?>" class="img-thumbnail" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>
                                    </div>
                                   <?php endif; ?>
                                   
                                   </div> 
                                  </div>
                                  
                                </div>
                                <!-- Fin de l'affichage des notifications-->
                             <?php endforeach; ?>
                             <?php else: ?>
                              <div class="text-center">
                                 <p>No notifications available yet...</p>
                              </div>
                      <?php endif; ?>
                        <a href="place_notification_off.php" style="color: #44717C;">Mark as read</a>  
                            </div>
                        </div>
                    </div>
                </div>
                 <div id="detail-1">
                    <div class="container">
                        <div class="fluid-row">
                          <div class="row">
                            <div class="card">
                              <div class="card-body">
                                <div class="text-center">
                                   <h6 style="color: #44717C;"><i class="far fa-eye"></i>48</h6>
                                <h6 style="color: #44717C;">Views</h6>
                                </div>
                              </div>
                            </div>
                            <div class="card">
                              <div class="card-body">
                                <h4>Members</h4>
                              </div>
                              
                            </div>
                            <div class="card">
                              <div class="card-body">
                                <h4>Ranking </h4>
                              </div>
                              
                            </div>
                            
                            
                            
                          </div>
                           
                        </div>
                    </div>
                </div>
                      </div>
                      
                    </div>
                    
                  </div>
                  
                </div>
                </div>

                </div>
            </div>
        </div>