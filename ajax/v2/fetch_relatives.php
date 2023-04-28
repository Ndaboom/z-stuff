<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

$user_id = get_session('user_id');

if($user_id){
    	
    	$q=$db->prepare('SELECT * FROM users 
                         WHERE id!= :id ORDER BY profilepic ASC
                         LIMIT '.$start.','.$rows.'');
	    $q->execute([
	                'id' => $user_id
	                ]);
	    $records = $q->rowCount();
    	$result = $q->fetchAll(PDO::FETCH_OBJ);
    
    	$output= '';
        $friends= '';
        $button= '';
    	
    	foreach($result as $relative){

        if(!already_friends(get_session('user_id'),$relative->id)){

        $data = friends_in_common(get_session('user_id'), $relative->id);
        
        if(relation_link_to_display($relative->id) == "accept_reject_relation_link"){
            $button = '<a href="#" class="flex items-center justify-center h-9 px-3 rounded-md bg-blue-100 text-blue-500 accept_friends" id="requested_friends'.$relative->id.'" data-user_id="'.$relative->id.'"> 
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 mr-2">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
            </svg> Accept
            </a>';
        }else{
            $button = '<a href="#" class="flex items-center justify-center h-9 px-3 rounded-md bg-blue-100 text-blue-500 add_friend" id="requested_friends'.$relative->id.'" data-user_id="'.$relative->id.'"> 
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 mr-2">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
            </svg> Friends
            </a>';
        }
    	
    	$output .= '<div class="user_box flex items-center space-x-4">
                        <div class="w-20 h-20 flex-shrink-0 rounded-md relative mb-3"> 
                            <img src="/'.$relative->profilepic.'" class="absolute w-full h-full inset-0 rounded-md object-cover shadow-sm" alt="">
                        </div> 
                        <div class="flex-1 border-b pb-3">
                            <a href="timeline.php?id='.$relative->id.'"  class="text-lg font-semibold capitalize"> '.$relative->name.' '.$relative->nom2.' </a>
                            <div class="flex space-x-2 items-center text-sm">
                                <div> '.friends_count_v2($relative->id).' Friends</div>
                                <div>·</div>
                                <div> '.records_count('microposts', 'user_id', $relative->id).' posts</div>
                            </div>
                            <div class="flex items-center mt-2">
                                <img src="assets/images/avatars/avatar-2.jpg" class="w-6 rounded-full border-2 border-gray-200 -mr-2" alt="">
                                <img src="assets/images/avatars/avatar-4.jpg" class="w-6 rounded-full border-2 border-gray-200" alt="">
                                <div class="text-sm text-gray-500 ml-2">'.count($data).' mutual friend(s)</div>
                            </div>

                        </div>
                        '.$button.'
                    </div>';

        }
    	
    	}
    
    echo $output;
    
}


