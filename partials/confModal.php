<div class="modal fade" id="confModal">
            
            <div class="modal-dialog modal-sm" >
                
                <div class="modal-content"> 
                <div class="modal-body" style="background-color: #e9ebee;">
                 <div class="card">
                     <div class="card-body text-center">
                         <a href="place_gallery_privacy_on.php?device=mobile"><i class="fas fa-users"></i> Only people following this place</a><?= $places->place_privacy == 1 ? '(activated)' : '' ?>
                     </div>
                 </div>
                  <div class="card">
                     <div class="card-body text-center">
                         <a href="place_gallery_privacy_off.php?device=mobile"><i class="fas fa-globe-africa"></i> Everybody</a>
                         <?= $places->place_privacy == 0 ? '(activated)' : '' ?>
                     </div>
                 </div>
                </div>
                </div>
            </div>
        </div>