<?php 
require("../../config/database.php");
require('../../includes/functions.php');

$response = array();
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['email'])){
       $q=$db->prepare("SELECT id, nom2, email FROM users
                  WHERE email= :email");
    $q->execute([
            'email'=> $_POST['email']
      ]);
      $userHasBeenFound=$q->rowCount();
       if($userHasBeenFound>0 && $user->email != ""){
       	    $user=$q->fetch(PDO::FETCH_OBJ);

         	$q=$db->prepare('SELECT * FROM users WHERE email=?');
	        $q->execute([$user->email]);
            $data=$q->fetch(PDO::FETCH_OBJ);
            $q->closeCursor();
            
            //UPDATE THE DB AND SEND THE EMAIL ADRESS
            
             $new_password ='NW'.rand(5, 15000);
    		 
             $subject = "Recover password";
             
             $message = '<b>Your new password is "'.$new_password.'",you can change it any time</b><br>';
             $message .= "<span>connect <a href='https://www.zungvi.com/login.php'>here</a></span>";
             
             $header = "From:info@zungvi.com \r\n";
             $header .= "Cc:info@zungvi.com \r\n";
             $header .= "MIME-Version: 1.0\r\n";
             $header .= "Content-type: text/html\r\n";
             
             $retval = mail ($to,$subject,$message,$header);
             
             if( $retval == true ) {
                	//Storing the new password in the database
    				$q= $db->prepare('UPDATE users SET password = :password WHERE email= :email');
    			    
    			    $q->execute([
                        'password'=>sha1($new_password),
                        'email'      =>$user->email
    			    ]);
             }
            
            //END JOB
            
            $response['error'] = false;
   	        $response['id'] = $user->id;
   	        $response['email'] = $user->email;
   	        $response['name'] = $user->name;
            
            $response['error'] = false;
            $response['message'] = "Hey ".$user->name.", a default password has been sent to your email address, Please check it out!";
       }else{
       	$response['error'] = true;
   	    $response['message'] = "No account found with the given email address";
       }
	}else{
		$response['error'] = true;
   	    $response['message'] = "Please submit your email";
	}

}

echo json_encode($response);