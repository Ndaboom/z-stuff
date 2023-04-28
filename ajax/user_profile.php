<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';

$q=$db->prepare("SELECT * FROM login_details
              WHERE user_id = :user_id
	           ");
	           $q->execute([
             'user_id'=>get_session('user_id')
             ]);	
             $user= $q->fetch(PDO::FETCH_OBJ);

	           $output = '';
                   
               $him = find_user_by_id($user->user_id);
               $output .= '
           <div class="card text-center">
           <a href="profile.php?id='.$user->user_id.'"><img class="card-img-top img-thumbnail" src="'.$him->profilepic.'" style="height:300px;"/></a>
           <div class="card-body">
           <h5><i class="far fa-star"></i>'.$him->name.' '.$him->nom2.'</h5>
           <p>'.$user->interactions.' interactions this month</p>
           </div>
           </div> 

                          '; 
               $output .='';

               echo $output;
