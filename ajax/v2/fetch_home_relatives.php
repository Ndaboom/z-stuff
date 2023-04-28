<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';
extract($_POST);

$user_id = get_session('user_id');

if($user_id){
        
        $current_user = find_user_by_id($user_id);
    	
    	$q=$db->prepare('SELECT * FROM users WHERE id!= :id LIMIT 3');
	    $q->execute([
	                'id' => $user_id
	                ]);
    	$result = $q->fetchAll(PDO::FETCH_OBJ);
    
    	$output= '<div class="uk-slider-container px-1 py-3">
        <ul class="uk-slider-items uk-child-width-1-3@m uk-child-width-1-3@s uk-child-width-1-2 uk-grid-small uk-grid">';
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
    	
    	$output .= '
                    <li>
                        <a href="timeline.php?id='.$relative->id.'" class="uk-link-reset">
                            <div class="card">
                                <img src="/'.$relative->profilepic.'" class="h-44 object-cover rounded-t-md shadow-sm w-full">
                                <div class="p-4">
                                    <h4 class="text-base font-semibold mb-1"> '.$relative->name.' '.$relative->nom2.'</h4>
                                </div>
                            </div>
                        </a>
                        '.$button.'
                    </li>';

        }
    	
    	}

        $output .= '
            </ul>
        </div>
        ';
    
    echo $output;
    
}


