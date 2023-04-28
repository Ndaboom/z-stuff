<?php
session_start();
require '../../config/database.php';
require '../../includes/functions.php';
require '../../includes/event_functions.php';

$q=$db->prepare("SELECT id,name,nom2,profilepic FROM users
	             WHERE id!= :id
	             ORDER BY RAND()
	             LIMIT 4
	           ");
	           $q->execute([
                   'id'=>get_session('user_id')
	           ]);


                $friends= $q->fetchAll(PDO::FETCH_OBJ);
	            $q->closecursor();

                $output = '';
                if(count($friends) != 0){
                   foreach($friends as $row)
                {

                    if(already_friends(get_session('user_id'), $row->id)){
                       if(!is_already_in_forum(get_session('fr_i'), $row->id)){
                        if(!forum_invitation_already_sent(get_session('fr_i'), $row->id, "join_forum_request"))
                        {
                            $output .='
                                   <div class="flex items-center space-x-4 rounded-md -mx-2 p-2 hover:bg-gray-50">
                                    <a href="timeline.php?id='.$row->id.'" href="timeline.php?id='.$row->id.'"iv class="w-12 h-12 flex-shrink-0 overflow-hidden rounded-full relative">
                                        <img src="/'.e($row->profilepic) .'" class="absolute w-full h-full inset-0 " alt="">
                                    </a>
                                    <div class="flex-1">
                                        <a href="timeline.php?id='.$row->id.'" class="text-base font-semibold capitalize">  '.e($row->name) .' '. e($row->nom2) .' </a>
                                        <div class="text-sm text-gray-500 mt-0.5"> '.friends_count($row->id).' friend(s)</div>
                                    </div>
                                    <a href="" id="iButt'.$row->id.'" data-user_id="'.$row->id.'"
                                        class="flex items-center justify-center h-8 px-3 rounded-md text-sm border font-semibold invite_friends">
                                        Invite
                                    </a>
                                    <small class="text-green-600" style="display:none;" id="conf'.$row->id.'">invitation sent</small>
                                </div>
                                      ';
                        }
                       }
                    }

                }
                }


$output .='';
echo $output;
