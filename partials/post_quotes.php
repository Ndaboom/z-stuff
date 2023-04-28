  <div class="modal fade" id="quotes">
            
            <div class="modal-dialog">
                
                <div class="modal-content">
                <div class="modal-body" style="background-color: white;">
                 <form action="postquotes.php" method="post">
                 <div class="row">                    
                     <div class="col-md-2">
                <h3 style="color: #44717C;"><i class="fas fa-quote-left"></i></h3> 
                </div>
                <div class="col-md-8" style="border-left: solid 1px #DDDDDD; border-right:solid 1px #DDDDDD; ">
                    <div class="row">
                       <textarea class="form-control border-0" name="content" rows="2" 
                     placeholder="Hi <?= e($user->name)?>,your quotes..." maxlength="250" required="required"></textarea> <br>
                    </div> 
                    <div class="row">
                    <input type="text" class="form-control border-0" placeholder="Author" id="author" name="author" required="required"/>   
                    </div> 
                 </div>
                    <div class="col-md-2 text-center">
                    <button type="submit" name="publish" class="btn btn-outline-primary" style="float: right;">Post</button> 
                    </div>               
                    </div>
                </form> 

                </div>    
    
                </div>
            </div>
        </div>   