<?php
 //Function pour verifier si un utilisateur a deja la notife Mutoo
 if(!function_exists('view_notif_mutoo')){
    function view_notif_mutoo($user_id){
  
    // initialisation de la variable $Db
    global $db;
   
   // verification de l'exesitance par query
  $q=$db->prepare("SELECT subject_id,name,user_id FROM notifications 
                         WHERE subject_id = :subject_id AND name= :name AND user_id= :user_id");
  $q->execute([
                     'subject_id' =>$user_id,
                     'name' => 'mutoo_notif',
                     'user_id' => 347,
                    ]);
  
  $count=$q->rowCount();
  
  
  $q->closeCursor();
  
  return $count;
  }
  }
  
  //Function pour verifier si un utilisateur a deja la notife covid
 if(!function_exists('view_notif_covid')){
    function view_notif_covid($user_id){
  
    // initialisation de la variable $Db
    global $db;
   
   // verification de l'exesitance par query
  $q=$db->prepare("SELECT subject_id,name,user_id FROM notifications 
                         WHERE subject_id = :subject_id AND name= :name AND user_id= :user_id");
  $q->execute([
                     'subject_id' =>$user_id,
                     'name' => 'covid_notif',
                     'user_id' => 1,
                    ]);
  
  $count=$q->rowCount();
  
  
  $q->closeCursor();
  
  return $count;
  }
  }
  
  //Function pour verifier si un utilisateur a deja ete suggerer a un autre
 if(!function_exists('already_suggested')){
    function already_suggested($user_id1,$user_id2){
  
    // initialisation de la variable $Db
    global $db;
   
   // verification de l'exesitance par query
  $q=$db->prepare("SELECT * FROM user_relationships_suggestion 
                         WHERE (user_id1 = :user_id1
                         AND user_id2 = :user_id2)
                         OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");
  $q->execute([
             'user_id1' => $user_id1,
             'user_id2' => $user_id2
             ]);
  
  $count=$q->rowCount();
  
  
  $q->closeCursor();
  
  return $count;
  }
  }
  
   // Fonction pour verifier si l'un des users a deja envoyes une demande d'amitie
	   if(!function_exists('request_already_sent_v1')){
		   function request_already_sent_v1($id1, $id2){
			    global $db;
	           $q=$db->prepare("SELECT status FROM friends_relationships
	                            WHERE (user_id1= :user_id1 AND user_id2= :user_id2) OR (user_id1= :user_id2 AND user_id2= :user_id1)
			   	                 ");
	           $q->execute([
                   'user_id1'=> $id1,
                   'user_id2'=> $id2
	           ]);
	
	           $count=$q->rowCount();
	
	
	           $q->closeCursor();
	
	           return (bool) $count;
	}	

	}
	
	// Fonction pour verifier si un utilisateur a deja completer sa localisation 
     if(!function_exists('location_completed')){
       function location_completed($user_id){
          global $db;
             $q=$db->prepare("SELECT city,country FROM users
                             WHERE id= :user_id");
             $q->execute(['user_id'=> $user_id]);

             $data=$q->fetch(PDO::FETCH_OBJ);

             if($data->city == "" || $data->country == "")
             {
              return false;
             }
             else
             {
              return true;
             }     
          } 
        }