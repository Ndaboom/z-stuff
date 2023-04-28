        <div class="modal fade" id="commentModal<?= $placepost->id?>">
            
            <div class="modal-dialog modal-lg" >
                
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                       <h5 style="color:#44717C;"> Comment </h5>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                    
                <div class="modal-body" style="background-color: #e9ebee;"> 
                  <div id="comment_displayer<?= $placepost->id ?>">
                    <?= pdisplay_comment(get_session('pl_i'),$placepost->id,$placepost->user_id,get_session('cr_i')) ?> 
                  </div>               
                       <div class="card">
                        <div class="card-body">
                              <div class="input-group">
                                       <textarea name="msg<?= $placepost->id ?>" id="msg<?= $placepost->id ?>" class="form-control type_msg" placeholder="your comment..." required="required" style="border-radius: 20px 20px 20px 20px;"></textarea>
                                     <a id="comment<?= $placepost->id ?>" class="comment"><button name="send" class="btn btn-outline-primary btn-xs"><i class="fas fa-location-arrow"></i></button> </a> 
                                    </div>
                              </div>
                    </div>
         

                </div>
                
                <!-- <div class="modal-footer">
                                
                </div>  -->
                    
                </div>
            </div>
        </div>