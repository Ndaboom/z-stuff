<?php

define('DB_HOST','localhost');
define('DB_NAME','db_name');
define('DB_USERNAME','db_username');
define('DB_PASSWORD','db_password');
define('ENCODAGE','charset=utf8mb4');


try{ 
$db= new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4;","".DB_USERNAME."","".DB_PASSWORD."");
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


if(!function_exists('replace_links')){
		   function replace_links($texte){
                $regex_url= "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/";
               return  preg_replace($regex_url,"<a href=\"$0\" target=\"_blank\">$0</a>",$texte);   	 
	        }	
	}
	
if(!function_exists('fetch_user_last_activity')){
function fetch_user_last_activity($user_id, $db){
        $query = "
                 SELECT * FROM login_details
                 WHERE user_id ='$user_id'
                 ORDER BY last_activity DESC
                 LIMIT 1
                 ";
        $statement= $db->prepare($query);
        $statement->execute();
        $result= $statement->fetchAll();
        foreach ($result as $row) {
        	return $row['last_activity'];
        }

}
}

if(!function_exists('fetch_user_chat_history')){
function fetch_user_chat_history($from_user_id, $to_user_id,$db){
    $query= "
            SELECT * FROM chat_message
            WHERE (from_user_id= '".$from_user_id."'
            AND to_user_id = '".$to_user_id."')
            OR (from_user_id= '".$to_user_id."'
            AND to_user_id= '".$from_user_id."') 
            ORDER BY created_at DESC
    ";
    $statement= $db->prepare($query);
    $statement->execute();
    $result=$statement->fetchAll();
    $output= '<div class="list-unstyled">';
    foreach ($result as $row) {
        $username= '';
         if($row["color"]){
          $wish='<div style="border-bottom: solid 1px #DDDDDD;border-radius:5px 5px 5px 5px;background: '.$row["color"].';color:white;">
           <b style="font-family:arial,sans-serif; font-style:italic;">'.$row["wish"].'</b>
           </div>
           ';   
    }else{
        $wish='';
    }
        if($row["from_user_id"]== $from_user_id)
        {
        $username = '<b class="text-success"> You </b>';
         $box ='
            <li style="margin-left:30%;width:70%;background-color:#00336C;color:black; margin-top:10px;border-radius:5px 5px 5px 5px; padding:10px;">
               '.$wish.'
               <p>'.replace_links(e($row["chat_message"])).'
            <div align="right">
                 -<small><em>'.$row['created_at'].'</em></small>
            </div>
               </p>
            </li><br>
        ';
        }else{
        $username= '<b class="text-danger">'.get_user_nam($row['from_user_id'],$db).'</b>';
        $box ='

            <li style="margin-left:Opx; width:70%;background-color:#efefef;color:black; margin-top:10px; border-radius:5px 5px 5px 5px;padding:10px;">
               '.$wish.'
               <p>'.replace_links(e($row["chat_message"])).'
            <div align="right">
                 -<small><em>'.$row['created_at'].'</em></small>
            </div>
               </p>
            </li><br>
        ';
        }
        $output.= ''.$box.'';
       
    }
        $output .= '</div>';
        $query = "
        UPDATE chat_message
        SET status = '0'
        WHERE from_user_id = '".$to_user_id."'
        AND to_user_id = '".$from_user_id."'
        AND status = '1'
        ";
        $statement= $db->prepare($query);
        $statement->execute();

        return $output;


    }
}


if(!function_exists('get_user_nam')){
function get_user_nam($user_id, $db){
     $query= "SELECT name FROM users WHERE id= '$user_id'";
     $statement= $db->prepare($query);
     $statement->execute();
     $result= $statement->fetchAll();

     foreach($result as $row)
     {
       return $row['name']; 
     }

      }
    }

if(!function_exists('count_unseen_message')){
function count_unseen_message($from_user_id, $to_user_id,$db){
     $query="
             SELECT * FROM chat_message 
             WHERE from_user_id = '$from_user_id'
             AND to_user_id = '$to_user_id'
             AND status = '1'
            ";
     $statement = $db->prepare($query);
     $statement->execute();
     $count= $statement->rowCount();
     $output= '';
     if($count > 0)
     {
        $output= '<span class="badge" style="background-color: #C3CBE0; color:white; font-size:15px;">'.$count.'</span>';
     }
     return $output;
      }
    }

if(!function_exists('fetch_is_type_status')){
function fetch_is_type_status($user_id, $db){
    $query= "
       SELECT is_type FROM login_details
       WHERE user_id = '".$user_id."'
       ORDER BY last_activity DESC
       LIMIT 1
    ";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output= '';
    foreach ($result as $row) 
    {
        if($row["is_type"] == 'yes')
        {
            $output = 'yes';
        }else{
            $output = 'no';
        }
    }
    return $output;
}
}

if(!function_exists('fetch_is_type_status_v2')){
    function fetch_is_type_status_v2($user_id, $db){
        $query= "
           SELECT is_type FROM login_details
           WHERE user_id = '".$user_id."'
           ORDER BY last_activity DESC
           LIMIT 1
        ";
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetchAll();
        $output= '';
        foreach ($result as $row) 
        {
            if($row["is_type"] == 'yes')
            {
                $output = '<p><span class="animate-typing-col">
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                    <span class="dot"></span>
                                </span>
                           </p>';
            }
        }
        return $output;
    }
    }

if(!function_exists('fetch_group_chat_history')){
function fetch_group_chat_history($db){
      $query = "
         SELECT * FROM chat_room
         WHERE forum_id = '".get_session('fr_i')."'
         ORDER BY created_at DESC
      ";
      $statement = $db->prepare($query);

      $statement->execute();

      $result = $statement->fetchAll();

      $output = '<ul class="list-unstyled">';
      foreach ($result as $row) {
          $user_name = '';
          if($row['from_user_id'] == get_session('user_id'))
          {
            $user_name = '<b class= "text-success">You</b>';
          }
          else
          {
            $user_name = '<b class= "text-danger">'.get_user_nam($row['from_user_id'],$db).'</b>';
          }

          $output .='
           <li style="border-bottom:1px dotted #ccc">
           <p>'.$user_name.' - '.replace_links($row['chat_message']).'
            <div align="right">
               - <small><em>'.$row['created_at'].'</em></small>
            </div>
           </li>
          ';
      }
      $output .= '</ul>';
      $query = "
        UPDATE unseen_forum
        SET seen = '1'
        WHERE user_id = '".get_session('user_id')."'
        AND forum_id = '".get_session('fr_i')."'
        AND seen = '0'
        ";
        $statement= $db->prepare($query);
        $statement->execute();
      return $output;

}
}

}catch(PDOException $e){
   die('Erreur: '.$e->getMessage());
   }
?> 
