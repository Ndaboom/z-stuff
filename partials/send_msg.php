  <div class="modal fade" id="msgModal">
            
            <div class="modal-dialog" >
                <div class="modal-content" style="border-radius:5%;">
                <div class="modal-body" style="background-color: white;">
                <form action="send_msg.php?id=<?= $_GET['id'] ?>" method="post">
                  <div class="row">
                      <div class="col-md-10">
                         <textarea class="form-control border-0" name="content" id="content" rows="2" 
                     placeholder="your message..." maxlength="250" required="required"></textarea>  
                      </div>
                     <div class="col-md-2">
                     <input type="submit" class="btn btn-outline-primary" value="send" name="send"/>
                     </div>
                  </div> 
                </form>   
                </div> 
                </div>
            </div>
        </div> 