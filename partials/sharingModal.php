<div class="modal fade" id="sharingModal">
            
            <div class="modal-dialog modal-md" >
                
                <div class="modal-content"> 
                <div class="modal-body" style="background-color: #e9ebee;">
                 <div class="card">
                     <div class="card-body text-center">
                         <a href="shareplace.php"><i class="fas fa-share-alt"></i> Share with friends <i class="fas fa-users"></i></a>
                     </div>
                 </div>
                 <div class="card">
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-2 text-success">
                           <i class="far fa-copy"></i>
                           </div>
                           <div class="col-md-10">
                           <input type="text" class="form-control" value="https://zungvi.com/homeplace.php?p_i=<?= get_session('pl_i') ?>" readonly/>
                           </div>
                       </div>
                     </div>
                 </div>
                </div>
                </div>
            </div>
        </div>