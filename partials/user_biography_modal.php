<div class="modal fade" id="biographyModal">
            
<div class="modal-dialog modal-md" >
    
    <div class="modal-content"> 
    <div class="modal-body">
      <div class="text-center"><b><?= $user->name ?> Biography</b></div>
      <p>
          <?= replace_links(e($user->bio)); ?>
      </p>
    </div>
    </div>
</div>
</div>