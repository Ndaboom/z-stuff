<?php
session_start();

require '../../config/database.php';
require '../../includes/functions.php';

if(isset($_POST["limit"], $_POST["start"]))
  {
        $q=$db->prepare("SELECT * FROM friends_relationships
        WHERE (user_id1 = :current_profile OR user_id2 = :current_profile)
        AND status ='1' LIMIT ".$_POST["start"].", ".$_POST["limit"]."");
	    $q->execute([
            'current_profile'=> $_POST['ui']
        ]);
        $result = $q->fetchAll(PDO::FETCH_OBJ);
        
    	$total_row = $q->rowCount();
    	$output= '';
    	if($total_row > 0)
    	{
            foreach ($result as $row)
               {

                if($row->user_id1 != $_POST['ui']){
                    $user = find_user_by_id($row->user_id1);
                }elseif($row->user_id2 != $_POST['ui']){
                    $user = find_user_by_id($row->user_id2);
                }
            
                  if($user->id != $_POST['ui']){

                  $output .= '
                        <div class="card p-2">
                            <a href="timeline.php?id='.$user->id.'">
                                <img src="/'.$user->profilepic.'" class="h-36 object-cover rounded-md shadow-sm w-full">
                            </a>
                            <div class="pt-3 px-1">
                                <a href="timeline.php?id='.$user->id.'" class="text-base font-semibold mb-0.5">  '.$user->name.' '.$user->nom2.' </a>
                                <p class="font-medium text-sm">Since '.short_time_ago($row->created_at).' </p>
                            </div>
                        </div>
                  ';

                  }
                
               }
    	}else{
            echo "";
        }
        
        echo $output;
}