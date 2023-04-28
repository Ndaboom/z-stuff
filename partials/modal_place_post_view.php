
  <div class="modal fade" id="monModal3">
            
            <div class="modal-dialog modal-lg" >
                
                <div class="modal-content">
                  <div class="modal-header">
                      <h4>Publisher</h4>
                  </div>
                <div class="modal-body" style="background-color: #e9ebee;"> 
               <div class="col">
              <form action="placeposts.php" method="post" enctype="multipart/form-data">
                 <div class="form-group mb-0">
                    <div class="row">
                       <div class="col-md-12">
                           <label class="sr-only" for="content">Add a post</label>
                             <textarea class="form-control border-0" name="content" id="content" rows="2" 
                                placeholder="Hey <?= $user->name ?>,say something...?" maxlength="300" required="required"></textarea> 
                       </div>
                    </div>
                    </div>
                    <br>
                    <div class="row">
                   <div class="col-md-6">
                         <div class="form-group mb-0">
                       <label for="type">what is the announcement?<span class="text-primary">*</span></label>
                     <select required="required" name="type" id="type" class="form-control">
                     <option value="a ajoute une nouvelle photo">
                      add a status
                     </option >
                     <option value="une grande nouvelle">
                      Great news
                     </option >
                     <option value="un nouveaute dans son marketplace">
                      A novelty in the marketplace
                     </option >
                      <option value="la vente">
                      Put up for sale
                     </option >
                    </select >
                    </div>
                      </div>
                   <div class="col-md-6">
                    <div class="form-group mb-0">
                    <label for="image">Add an image </label>
                       <input type="file" name="image" id="image" accept=".jpeg,.jpg, .png, .gif" style="display:none;" onchange="displayImage(this)"/> 
                    <h3 onclick="triggerClick()" ><i class="fas fa-upload"></i></h3>
                    <div id="Imagepreview">
                    <img class="img-thumbnail img-responsive" id="profileDisplay"/>   
                    </div>
                    </div> 
                       </div>
                    </div>
                 </div>  
                </div>
                 <div class="modal-footer">
                <div class="form-group mb-0 status-post-submit">
                <button type="submit" name="publish2" class="btn btn-default">📎 Share</button>
                 </div>
              
            </div>
               
           </form>
                </div>
            </div>
        </div>
