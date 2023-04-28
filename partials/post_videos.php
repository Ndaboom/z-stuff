<div class="modal fade" id="videosModal">
        
    <div class="modal-dialog modal-lg">
        
        <div class="modal-content">
        <div class="modal-body text-center">
         <video controls preload="meta-data" loop poster="" onclick="triggerClick4();" id="videoPlayer" style="max-width:100%;">
            <source src="">
            </source>
         </video>

         <form id="upload_form" enctype="multipart/form-data" method="post">
            <input type="file" name="file1" id="file1" accept=".mp4,.avi" style="display:none;" onchange="displayVideo(this)"><br>
             <textarea class="form-control border-0" name="videoDescription" id="videoDescription" rows="2" 
                     placeholder="Short description..." maxlength="1000"></textarea> 
           <progress id="progressBar" value="0" max="100"></progress>
            <h5 id="status"></h5>
            <p id="loaded_n_total"></p><br>
            <input type="button" class="btn btn-outline-primary upload_video" value="Publish"> 
         </form>
        </div>    

        </div>
    </div>
</div>   