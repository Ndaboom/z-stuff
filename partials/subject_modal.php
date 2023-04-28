        <div class="modal fade" id="moreSubject">
            
            <div class="modal-dialog modal-lg" >
                
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                         Topics in <?= e($forum->forum_name) ?>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                    
                <div class="modal-body" style="background-color: #e9ebee;"> 
                 
                      
                        <?php if(count($Allforumsubjects) !=0): ?>
                            <?php foreach ($Allforumsubjects as $subject): ?>
                              <div class="card">
                    <div class="card-body">
                       <div class="row">
                                <div class="col-lg-1">
                                     <h3 style="color: #44717C;"><i class="fas fa-brain"></i></h3> 
                                     </div>
                                     <div class="col-lg-9" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; font-style: italic; ">
                                       <h5 style="color: #44717C;"><?= nl2br(replace_links(e($subject->subject))) ?></h5>
                                       <i class="fa fa-globe" aria-hidden="true"></i> <span class="timeago" title="<?= $subject->created_at ?>"><?= e($subject->created_at) ?></span>
                                     </div>
                                     <div class="col-lg-2 text-center">
                                      <?php if($subject->reaction==0): ?>
                                     <a href=""><h4 style="font-style: italic;">0</h4>
                                     <h6 style="font-style: italic;">Reaction</h6></a> 
                                     <?php else: ?>
                                      <a href="morereaction.php?rid=<?= $subject->id ?>"><h4 style="font-style: italic;"><?= e($subject->reaction) ?></h4>
                                     <h6 style="font-style: italic;">Reactions</h6></a> 
                                     <?php endif; ?>
                                     </div>
                                    </div>
                    </div>
                  </div>
                  
           <?php endforeach; ?>
                      <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
        