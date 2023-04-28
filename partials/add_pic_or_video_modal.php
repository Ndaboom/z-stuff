  <div class="modal fade" id="monModal">
            
            <div class="modal-dialog" >
                
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" >Select a photo</h4>
                        <button type="button" class="close" data-dismiss="modal">Next</button>
                        
                    </div>
                    
                <div class="modal-body" style="background-color: #e9ebee;">
                    <input type="file" name="image" id="image" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImage(this)"/> 
                    <h3 onclick="triggerClick()" ><i class="fas fa-upload"></i></h3>
                    <div id="Imagepreview">
                    <img class="img-thumbnail img-responsive" id="profileDisplay"/>   
                    </div>
                </div> 
                </div>
            </div>
        </div>   