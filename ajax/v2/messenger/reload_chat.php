<?php
session_start();
require '../../../config/database.php';
require '../../../includes/functions.php';
extract($_POST);

if(isset($_POST["limit"], $_POST["start"]))
{
    
$from_user_id = $_SESSION['user_id'];

 $q=$db->prepare("SELECT * FROM chat_message
                  WHERE (from_user_id= '".$from_user_id."'
                  AND to_user_id = '".$to_user_id."')
                  OR (from_user_id= '".$to_user_id."'
                  AND to_user_id= '".$from_user_id."') 
                  ORDER BY created_at DESC
	              LIMIT ".$_POST["start"].", ".$_POST["limit"]."
	            ");
	            
	           $q->execute();
	           $messages = $q->fetchAll(PDO::FETCH_OBJ);
	           $q->closecursor();

               $output = '';
               
               $reversed_array = array_reverse($messages);

foreach($reversed_array as $message){

$user1 = find_user_by_id($message->from_user_id);

if($from_user_id == $message->from_user_id){

$output .=' <div class="message-bubble me">
                                        <div class="message-bubble-inner">
                                            <div class="message-avatar"><img src="'.$user1->profilepic.'" alt=""></div>
                                            <div class="message-text"><p>'.$message->chat_message.'</p></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>';

}else{

$output .=' <div class="message-bubble">
                                        <div class="message-bubble-inner">
                                            <div class="message-avatar"><img src="'.$user1->profilepic.'" alt=""></div>
                                            <div class="message-text"><p>'.$message->chat_message.'</p></div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>';

}

}

echo $output;
}
