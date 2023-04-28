  <div class="modal fade" id="soundsModal">
            
            <div class="modal-dialog">
                
                <div class="modal-content">
                <div class="modal-body" style="background-color: white;">
                 <form method="post" action="/postaudio.php" enctype="multipart/form-data">
                 <div class="row">                    
                     <div class="col-md-2">
                <h3 style="color: #44717C;"><i class="fas fa-headphones-alt"></i></h3> 
                </div>
                <div class="col-md-8" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; ">
                    <div class="row">
                    <audio controls="autoplays" id="audioPlayer"></audio><br>
                   <textarea class="form-control border-0" name="content" rows="2" 
                     placeholder="Your feeling on this sound ..." maxlength="250" required="required"></textarea> <br>
                    </div>
                    <div class="row">
                       <input type="file" name="audio" id="maudio" accept=".mp3,.wav,.ogg" style="display:none;" onchange="displaySound(this)"/>
                       <h5 onclick="triggerClick3()" ><i class="fas fa-upload"></i></h5>
                    </div>
                 </div>
                    <div class="col-md-2 text-center">
                    <button name="publish" class="btn btn-outline-primary" style="float: right;">Post</button>
                    </div>               
                    </div>
                </form> 

                </div>    
    
                </div>
            </div>
        </div>   