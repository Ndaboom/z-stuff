  <div class="modal fade" id="reactionModal<?= e($forum->id) ?>">
            
            <div class="modal-dialog modal-md" >
                
                <div class="modal-content">
                   <div class="modal-header">
                    <div class="row">
                        <div class="col-md-10">
                        <?= e($forum->forum_name) ?>
                        </div>
                        <div class="col-md-2">
                           <?php if(!if_already_sent($forum->id)): ?>
                         <a href="joinForumRequest.php?fr_i=<?= $forum->id ?>" class="btn btn-outline-primary btn-xs" style="float: left;">Rejoindre <i class="fas fa-sign-in-alt"></i></a> 
                           <?php else: ?>
                         <a href="cancelForumRequest.php?fr_i=<?= $forum->id ?>" class="btn btn-outline-danger btn-xs" style="float: left;">Annuler <i class="fas fa-sign-out-alt"></i></a> 
                           <?php endif; ?>  
                        </div>
                    </div>
                    </div>
                    
                <div class="modal-body"> 
                <div class="card">
                  <img src="<?= e($src =($forum->forum_pic != null) ? $forum->forum_pic : 'images/portada_7.png') ?>" class="card-img" alt="..." with="95">
                <!--  <div class="card-img-overlay text-center">
                  <h3 class="card-title"><?= e($forum->forum_name) ?></h3>
                  <a href="" class="btn btn-outline-primary btn-md">Rejoindre</a>
                  </div> -->
                </div> 
                </div>
                
                <div class="modal-footer text-center">
                <p>
                 <?= e($forum->description) ?>   
                </p>                
                </div>
                    
                </div>
            </div>
        </div>
        