<?php

//Fonction pour prendre les infos d'une event by his id
if(!function_exists('find_event_by_id')){
    function find_event_by_id($id)
    {

	global $db;
	$q=$db->prepare('SELECT * FROM events WHERE id=?');
	$q->execute([$id]);
    $data=$q->fetch(PDO::FETCH_OBJ);
    $q->closeCursor();	
	return $data;
		
	}		   
    }
    

//Fonction pour prendre toutes les personnes ayant vote un certain candidat
if(!function_exists('find_all_vote_id')){
    function find_all_vote_id($id)
    {

	global $db;
	$q=$db->prepare('SELECT * FROM poll_count WHERE candidate_id= ?');
	$q->execute([$id]);
    $data=$q->fetchAll(PDO::FETCH_OBJ);
    $q->closeCursor();	
	return $data;
		
	}		   
}

//Fonction pour prendre toutes les personnes ayant vote un certain candidat
if(!function_exists('find_candidate_by_id')){
    function find_candidate_by_id($id)
    {

	global $db;
	$q=$db->prepare('SELECT * FROM poll_count WHERE candidate_id= ?');
	$q->execute([$id]);
    $data=$q->fetch(PDO::FETCH_OBJ);
    $q->closeCursor();	
	return $data;
		
	}		   
}

//Fonction pour prendre toutes les info d'un certain candidat
if(!function_exists('find_candidate_info_by_id')){
    function find_candidate_info_by_id($id)
    {

	global $db;
	$q=$db->prepare('SELECT * FROM poll_tb WHERE id= ?');
	$q->execute([$id]);
    $data=$q->fetch(PDO::FETCH_OBJ);
    $q->closeCursor();	
	return $data;
		
	}		   
}
    
// if a user has already followed an event 
if(!function_exists('an_event_has_already_been_followed')){
    function an_event_has_already_been_followed($event_id,$user_id){
         global $db;
        $q=$db->prepare("SELECT id FROM event_followers
                         WHERE event_id = :event_id AND user_id = :user_id AND status= :status");
        $q->execute([
            'event_id'=>$event_id,
            'user_id'=> $user_id,
            'status'=> 1
        ]);
        $data= $q->fetch(PDO::FETCH_OBJ);

        if (!empty($data)) {
             return true;
        }else{
             return false;
        }
        $q->closeCursor();
}	

}

// Fonction pour compter le nombre des notifications d'une evenement
if(!function_exists('event_notifications_count')){
    function event_notifications_count($event_id){
       
        global $db;
        $q=$db->prepare("SELECT * FROM event_notifications
                         WHERE event_id = :event_id
                         AND seen ='0'");
        $q->execute([
            'event_id'=> $event_id
        ]);

        $count=$q->rowCount();


        $q->closeCursor();

        return $count;
}	
}

// Fonction pour afficher les notifications d'un event
if(!function_exists('event_notifications_displayer')){
    function event_notifications_displayer($event_id){
        global $db;
        $q=$db->prepare("SELECT * FROM event_notifications
                         WHERE event_id = :event_id
                         AND seen ='0' ORDER BY -posted_at");
        $q->execute([
            'event_id'=> $event_id
        ]);

       
        $data= $q->fetchAll(PDO::FETCH_OBJ);

        $q->closeCursor();

        return $data;
}	

}
