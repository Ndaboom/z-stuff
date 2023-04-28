<?php 
session_start();
require '../config/database.php';
require '../includes/functions.php';
extract($_POST);

$q = $db->prepare('SELECT * FROM users
	               WHERE (name LIKE :query OR nom2 LIKE :query OR email LIKE :query)
	               LIMIT 7
	               ');
$q->execute([
             'query'=> '%'.$query.'%'
]);

$users = $q->fetchAll(PDO::FETCH_OBJ);
$output='';
if (count($users)>0) {
	foreach ($users as $row) {
		 $query= "
            SELECT * FROM chat_message
            WHERE (from_user_id= '".get_session('user_id')."'
            AND to_user_id = '".$row->id."')
            OR (from_user_id= '".get_session('user_id')."'
            AND to_user_id= '".$row->id."') 
            ORDER BY created_at DESC
    ";
    $statement= $db->prepare($query);
    $statement->execute();
    $result=$statement->fetch(PDO::FETCH_OBJ);
    
    if(already_friends(get_session('user_id'), $row->id)){
 $output .= '<a href="wishMaker.php?id='.$row->id.'" style="text-decoration: none;"><div class="card">
                  <div class="card-body" style="padding-left : 30px;height:80px;">
		           <div class="row">
                     <div class="img_cont">
                  <img src="/'.e($row->profilepic) .'" class="rounded-circle" style="height: 50px;
			width: 50px; border: solid 1.5px #00336C;">
                     </div>
                     <div class="user_info">
                  <small>Make a wish to </small><b>'.e($row->name) .' '. e($row->nom2) .'</b><br>
                     </div>
                     </div>
                     </div>
		           </div></a>
           '; 
    }
    
	}
}else{
    $output .= 'no loved ones found :(';
}

echo $output;
?>