<div class="modal fade" id="monModal">
        	
        	<div class="modal-dialog" >
        		
        		<div class="modal-content">
        			<div class="modal-header">
        				<h4 class="modal-title" >Creation of a place ...</h4>
        				<button type="button" class="close" data-dismiss="modal">X</button>
                        
        			</div>
        			
        		<div class="modal-body" style="background-color: #e9ebee;"> 
        			<form method="post" class ="well" autocomplete="off">
                                    <div class="">
                                        <label for="place_name">Name of the place <span class="text-primary">*</span></label>
                                        <input type="text" class="form-control" placeholder="Name of the place" id="place_name" name="place_name"
      required="require"/>
                                    </div>
                                   <div class="form-group">
                                   <label for="description">About :<span class="text-primary">*</span></label>
                                   <textarea name="description" id="description" cols="55" rows="05" class="form-control"
                                   placeholder="About this place"></textarea>
                                   
                                   </div>

                                    <div class="">
                                         <label for="category">Define a category <span class="text-primary">*</span></label>
                                         <select required="required" name="category" id="category" class="form-control">
                                         <option value="Residence">
                                         Residential place
                                         </option >
                                         <option value="Commercial">
                                         Commercial place
                                         </option >
                                         <option value="Art">
                                         Artistic place
                                         </option >
                                         <option value="sport">
                                         Sports place
                                         </option >
                                         <option value="Touristic">
                                        Tourist place
                                         </option >
                                          <option value="Educative">
                                         Educational place
                                         </option >
                                          <option value="Hotel">
                                        Place, Hotel
                                         </option >
                                          <option value="Restaurant">
                                         Place, Restaurant
                                         </option >
                                         <option value="Commercial,industrial">
                                        Place, commercial and industrial
                                         </option >
                                    </select >
                                    </div >

                                    <br>
                                    <div class="pull-right">
                                        <a><input type="submit" class="btn btn-primary" value="Create" name="insert"/></a>
                                    </div>



                                   
                                </form>			
        		</div>
        		
        		<!-- <div class="modal-footer">
                      			
        		</div>  -->
        			
        		</div>
        	</div>
        </div>
        