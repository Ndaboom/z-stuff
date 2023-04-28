        <div class="modal fade" id="orderModal">
            
            <div class="modal-dialog modal-lg" >
                
                <div class="modal-content">
                    <div class="modal-header" style="background-color: white;">
                       <div class="alert alert-primary alert-lg" style="width: 100%;">Orders </div>
                        <button type="button" class="close" data-dismiss="modal">X</button>
                        
                    </div>
                    
                <div class="modal-body" style="background-color: #e9ebee;"> 
                  <div id="orders_displayer">
                 <?php $orders=get_orders($notification->place_id);
                       $user=find_user_by_id($notification->user_id);
                        ?>
                 <?php if(!empty($orders)):  ?>
                  <?php foreach($orders as $order): ?>
                   <div class="card text-center">
                           <div class="card-body">
                           <div class="row">
                           <div class="col-md-2"><img src="<?= $order->image ?>" style="width:50px; height:50px;" /></div>
                           <div class="col-md-8 text-center">
                            <a href=""><?= $order->designation ?></a><br>
                  <div class="card">
                    <div class="card-body">
                      <small>by:</small> <img src="<?= $user->profilepic ?>" class="rounded-circle" style="height: 65px; width: 65px; border:1.5px solid #f5f6fa;">
                      <?php if($order->seen ==0): ?>
                  <div id="chat_box">
                  <textarea placeholder="votre reponse a <?= $user->name ?>" style="height:50px;" class=" form-control border-0" rows="2" id="<?= $order->id ?>"></textarea>
                  <a class="btn btn-outline-primary action_button" id="<?= $order->id ?>" data-customer="<?= $user->id ?>" data-order="<?= $order->id ?>">Reply</a>
                  </div>
                  <small class="text-success" style="display: none;" id="acknolegment">Reply sent</small>
                  <?php else: ?>
                  <small class="text-success">Reply sent</small>
                  <?php endif; ?>
                    </div>
                  </div>  
                          </div>
                           <div class="col-md-2"><h5><?= $order->object_price ?></h5>
                           </div>
                           </div>
                          </div>
                           </div>
                  <?php endforeach; ?>
                 <?php endif; ?>
                      
                  </div>               
                </div>
                </div>
            </div>
        </div>