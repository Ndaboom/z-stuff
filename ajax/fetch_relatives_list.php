<?php
session_start();
require '../config/database.php';
require '../includes/functions.php';
require '../includes/event_functions.php';

if(isset($_POST["limit"], $_POST["start"]))
{

$q=$db->prepare("SELECT id,name,nom2,profilepic FROM users
	                            WHERE id!= :id
	                            ");
	           $q->execute([
                   'id'=>get_session('user_id')
	           ]);


                $friends= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor();

                $output = '<div class="container">';
                if(count($friends) != 0){
                   foreach($friends as $row)
                {

                    if(already_friends(get_session('user_id'), $row->id)){
                        $status='';
                        $current_timestamp= strtotime(date('Y-m-d H:i:s') .'+3580 second');
                        $current_timestamp= date('Y-m-d H:i:s',$current_timestamp);
                        $user_last_activity=fetch_user_last_activity($row->id,$db);
                        if(!an_event_has_already_been_followed(get_session('ev_i'),$row->id))
                        {
                            $output .='
                                  <div class="row">
                                            <div class="col-md-3">
                                                <img class="rounded-circle" src="'.e($row->profilepic) .'" alt="" style="height: 30px;
                            width: 45px; height:45px;
                            border:1.5px solid #f5f6fa;">
                                            </div>
                                            <div class="col-md-5">
                                                '.e($row->name) .' '. e($row->nom2) .'
                                            </div>
                                            <div class="col-md-4">
                                            <a class="btn btn-outline-primary btn-xs invite_friends" id="iButt'.$row->id.'" data-user_id="'.$row->id.'"> Invite</a>
                                            <small class="text-success send_txt" style="display:none;" id="conf'.$row->id.'">invitation sent</small>
                                            </div>
                                  </div>
                                      ';
                        }

                    }

                }
                }


$output .='</div>';
}
echo $output;
