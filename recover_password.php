<?php
session_start();
require("includes/init.php");
include('filters/guest_filter.php');
require("includes/functions.php");
require("config/database.php");
require("bootsrap/locale.php");
if(isset($_POST['validate'])){
    
	//Si tous les champs ont été remplis
	if(not_empty(['email'])){   
	 extract($_POST);
	 $q=$db->prepare("SELECT * FROM users
	                WHERE email= :email");
		$q->execute([
            'email'=>$email	
			]);
			$userHasBeenFound=$q->rowCount();
			if($userHasBeenFound){
				
				$user=$q->fetch(PDO::FETCH_OBJ);
				$to = $user->email;
				
				$new_password ='NW'.rand(5, 15000);
				//Storing the new password in the database
					$q= $db->prepare('UPDATE users SET password = :password WHERE email= :email');
			    
			    $q->execute([
                    'password'=>sha1($new_password),
                    'email'      =>$email
			    ]);
		 
         $subject = "Recover password";
         
         $message = '<b>Your new password is "'.$new_password.'",you can change it any time</b><br>';
         $message .= "<span>connect <a href='https://www.zungvi.com/login.php'>here</a></span>";
         
         $header = "From:info@zungvi.com \r\n";
         $header .= "Cc:info@zungvi.com \r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $retval = mail ($to,$subject,$message,$header);
         
         if( $retval == true ) {
            echo "Message sent successfully...";
         }else {
            echo "Message could not be sent...";
         }
		redirect('user.php?email='.$user->email);
	 }
	 }
}
require("views/recover_password.view.php");