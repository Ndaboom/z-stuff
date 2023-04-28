<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$q=$db->prepare("SELECT * FROM users
	            WHERE id= :user_id
	           ");
	           $q->execute([
	               'user_id'=>get_session('user_id')
	               ]);
               $myself= $q->fetch(PDO::FETCH_OBJ);
	           $q->closecursor();

$q=$db->prepare("SELECT interactions,user_id FROM login_details
               WHERE user_id= :user_id
	           ");
	           $q->execute([
	               'user_id'=>get_session('user_id')
	               ]);
               $you= $q->fetch(PDO::FETCH_OBJ);
	           $q->closecursor();
	  if($myself->profession != null){
	      $profession='
	      <i class="fa fa-briefcase"></i> '.$myself->profession.'
	      ';
	  }else{
	    $profession='';
	  }

	           $output = '';
               $output .= '
                           <div class="card text-center">
                           <a href="profile.php?id='.$myself->id.'"><img class="card-img-top" src="'.$myself->profilepic.'"
													 alt="" style="max-height:400px;"></a>
                           <div class="card-body">
                           <h5>'.$myself->name.' '.$myself->nom2.'</h5>
                           '.$profession.'
                          ';
													
           if($you->interactions != 0){

            $output .='<br><small>You have '.$you->interactions.' interactions</small>
                           </div>
                           </div>
													 ';
           }



           echo $output;
