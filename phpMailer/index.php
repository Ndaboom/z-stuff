<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
session_start();
require('../config/database.php');
require('../includes/functions.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require 'pvendor/autoload.php';


//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$activation_code = rand(1000, 9999); 

	//Storing the AC in the database
	$q= $db->prepare('UPDATE users SET account_activation_code = :account_activation_code WHERE email= :email');
    
    $q->execute([
        'account_activation_code' => $activation_code,
        'email' => $_GET['email']
    ]);

try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.supremecluster.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'info@zungvi.com';                     //SMTP username
    $mail->Password   = 'kabila12';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    //Recipients
    $mail->setFrom('info@zungvi.com', 'Zungvi');
    $mail->addAddress($_GET['email'], $_SESSION['current_name']);     //Add a recipient
    $mail->addCC('registrationinfo@zungvi.com');
    $mail->Subject = 'Zungvi activation code';
    $mail->Body    = 'Hey '.$_SESSION['current_name'].', your activation code is <b>'.$activation_code.'</b>';
    $mail->AltBody = 'Thanks for being among us';

    $mail->send();
    
    redirect('../account_verification.php?user_id='.$_SESSION['current_id'].'&email='.$_SESSION['current_email'].'&nom2='.$_SESSION['current_nom2'].'&msg=activation code sent successfully, check your mail box&device='.$_GET['device']);
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}