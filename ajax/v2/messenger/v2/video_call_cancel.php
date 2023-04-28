<?php
session_start();
require '../../../../config/database.php';
require '../../../../includes/functions.php';
extract($_POST);

//Check if the record exist
    echo "cancelling...";
if(record_check("video_calls", "from_user_id", $_SESSION['user_id'], "to_user_id", $to_user_id)){
    echo "record exist...";

    $q=$db->prepare('DELETE FROM video_calls WHERE from_user_id= :from_user_id AND to_user_id= :to_user_id');
    $q->execute([
        'from_user_id'=> $_SESSION['user_id'],
        'to_user_id'=> $to_user_id
    ]);

    $q->closecursor();
    echo "call canceled";

}else{
    echo "Call not found";
}