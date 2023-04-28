        <div class="modal fade" id="commentModal<?= $post->id?>">
            
            <div class="modal-dialog modal-lg" >
                
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                       <h5 style="color:#44717C;"> Commenter </h5>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                    
                <div class="modal-body" style="background-color: #e9ebee;"> 
                  <div id="comment_displayer<?= $post->id ?>">
                    <?= display_comment(get_session('fr_i'),$post->id,$post->poster_id) ?>  
                  </div>               
                       <div class="card">
                        <div class="card-body">
                              <div class="input-group">
                                       <textarea name="msg<?= $post->id ?>" id="msg<?= $post->id ?>" class="form-control type_msg" placeholder="your comment..." required="required" style="border-radius: 20px 20px 20px 20px;"></textarea>
                                     <a id="comment<?= $post->id ?>" class="comment"><button name="send" class="btn btn-outline-primary btn-xs"><i class="fas fa-location-arrow"></i></button> </a> 
                                    </div>
                              </div>
                    </div>
         

                </div>
                
                <!-- <div class="modal-footer">
                                
                </div>  -->
                    
                </div>
            </div>
        </div>