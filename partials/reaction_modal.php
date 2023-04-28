  <div class="modal fade" id="reactionModal<?= e($post->id) ?>">
            
            <div class="modal-dialog modal-lg" >
               <?php  $reactions=getUserForumReaction($post->id);
                      $username=selectSubjectPoster($post->poster_id);
                      
                     ?>
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                         <?= e($post->subject) ?> par <?= e($username->name) ?>
                        <button type="button" class="close" data-dismiss="modal">X</button> 
                    </div>   
                <div class="modal-body" style="background-color: white;">
                    <?php foreach ($reactions as $reaction): ?>
                         <?php $user_profile=place_followerspic_displayer($reaction->user_id);
                               $userfirstname=get_user_name($reaction->user_id);
                               $userlastname=get_user_second_name($reaction->user_id);
                                          ?>
                     <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2" style="border-right: solid 1px #DDDDDD;">
                                  <a href="profile.php?id=<?= $reaction->user_id?>"><img src="<?= $user_profile->profilepic ?>" class="rounded-circle" style="height: 80px; width: 80px; border:1.5px solid #f5f6fa;" ></a>  
                                </div>
                        <?php if($reaction->content_img): ?>
                                <div class="col-md-6" style="border-right: solid 1px #DDDDDD;">
                                    <a href="profile.php?id=<?= $reaction->user_id ?>"><?= e($userfirstname->name) ?> <?= e($userlastname->nom2) ?></a>
                                   <p><?= $reaction->content_text ?></p>
                                   <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $reaction->created_at ?>"><?= $reaction->created_at ?></span>
                                </div>
                                <div class="col-md-3">
                                    <a href=""> <img src="<?= $reaction->content_img ?>" width="150" height="80"></a><br>
                                    <a class="btn btn-default" href="<?= $reaction->content_img ?>" download>Download</a>
                                </div>
                        <?php else: ?>
                    <div class="col-md-10">
                    <a href="profile.php?id=<?= $reaction->user_id ?>"><?= e($userfirstname->name) ?> <?= e($userlastname->nom2) ?></a>
                    <p><?= $reaction->content_text ?></p>
                          <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $reaction->created_at ?>"><?= $reaction->created_at ?></span>
                                </div>
                        <?php endif; ?>
                            </div>
                             <?php if(!already_satisfied($reaction->id)):  ?>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                   
                                       <button  class="btn btn-outline-primary btn-sm <?= already_validate($reaction->id) ? "active" : "" ?>" id="revalidate<?= $reaction->id?>" style="display: none;"> <i class="far fa-thumbs-up"></i> je valide</button>
                    
                                      <a href="" class="validate" id="validate<?= $reaction->id ?>" data-action="<?= $reaction->user_id ?>"><button href="validatereaction.php?re_id=<?= $reaction->id ?>" class="btn btn-outline-primary btn-sm <?= already_validate($reaction->id) ? "active" : "" ?>"> <i class="far fa-thumbs-up"></i> je valide</button> </a>
                                    
                                     
                                
                            <button  class="btn btn-outline-danger btn-sm <?= already_denied($reaction->id) ? "active" : "" ?>" id="redenied<?= $reaction->id?>" style="display: none;"> <i class="far fa-thumbs-down"></i> je nie</button>
                             
                            <a href="" class="denied" id="denied<?= $reaction->id ?>">
                                <button class="btn btn-outline-danger btn-sm <?= already_denied($reaction->id) ? "active" : "" ?>"><i class="far fa-thumbs-down"></i> je nie</button>    
                                </a>
 
                                <a href="" class="satisfied" id="satisfied<?= $reaction->id ?>">
                                 <button class="btn btn-outline-info btn-sm"><i class="far fa-smile"></i> satisfait</button>
                                </a>            
                            </div>
                        </div>
                            <?php endif; ?>
                          <div class="col-md-12 text-center" id="likers_<?= $reaction->id ?>">
                           
                             <?= display_validations($reaction->id)?>
                               
                            </div>
                    </div>   
                </div>
                    <?php endforeach; ?>
                    <div class="card">
                        <div class="card-body text-center">
                          <a href="morereaction.php?rid=<?= $post->id ?>"><i class="fas fa-tasks"></i> plus des reactions</a>    
                        </div>  
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form action="subjectreact.php?rid=<?= e($post->id) ?>" method="post" enctype="multipart/form-data"> 
                    <div class="row">
                      <div class="col-lg-1">
                 <img src= "<?= e($src =($user_profile->profilepic != null) ? $user_profile->profilepic : 'images/default.png') ?>"  alt="<?= e($user->name) ?>" alt="image" class="rounded-circle" width="75" 
                                      style="height: 45px; width: 45px; border:1.5px solid #f5f6fa;"> 
                </div>
                <div class="col-lg-5" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; border-radius: 20px 20px 20px 20px;">
                     <textarea class="form-control border-0" name="content" id="content" rows="4" 
                     placeholder="Votre reaction...?" maxlength="250" required="required" style=" border-radius: 20px 20px 20px 20px; "></textarea><br>
                     <i class="far fa-image" style="padding-top: 1px;" ></i><input type="file" name="image"> 
                 </div>
                    <div class="col-lg-2 text-center">
                    <button type="submit" name="publish" class="btn btn-outline-primary" style="float: right;"> Post</button>
                    </div> 
                    <div class="col-lg-4">
                        
                    </div>   
                    </div>
                </form>    
                        </div>
                    </div>
               
                </div> 
              <!--  <div class="modal-footer">
                                
                </div>  -->   
                </div>
            </div>
        </div>
        