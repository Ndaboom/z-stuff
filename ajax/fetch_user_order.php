<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$q=$db->prepare("SELECT * FROM place_orders 
	               WHERE user_id= :user_id AND place_id= :place_id
                 ORDER BY ordered_at
	           ");
	           $q->execute([
               'user_id'=>get_session('user_id'),
               'place_id'=>get_session('pl_i')
             ]);	
             $orders= $q->fetchAll(PDO::FETCH_OBJ);
	           $q->closecursor(); 

	           $output = '';

	           if(count($orders) != 0){
	           	 foreach($orders as $row)
                  { 
                    if($row->is_send==1){
                      $status='<small class="text-success">Sent</small>';
                    }else{
                      $status="";
                    }


               $output .= '
                          <div class="card text-center">
                           <div class="card-body">
                           <div class="row">
                           <div class="col-md-2"><img src="'.$row->image.'" style="width:50px; height:50px;" /></div><div class="col-md-8"><a href="">'.$row->designation.'</a><br>'.$status.'</div><div class="col-md-2"><h5>'.$row->object_price.'</h5>
                           <a href="removeOrder.php?id='.$row->id.'" class="btn btn-outline-danger cancel" style="color:red;" id="order'.$row->id.'"><i class="fas fa-ban"></i></a></div>
                           </div>
                          </div>
                           </div> 
                          '; 
           }
               }
               if(orders_count(get_session('user_id'),get_session('pl_i'))>0){
               $output .='<div class="card text-center"><div class="card-body"><a class="btn btn-outline-primary" href="order_validation.php"><i class="far fa-check-circle"></i> Validate </a></div></div>';
               }
               echo $output;
