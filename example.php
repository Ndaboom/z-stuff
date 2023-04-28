<?php
$to = "250732226261@vtext.com";
$from = "info@zungvi.com";
$message = "This is a text message...";
$headers = "From: $from\n";
if(mail($to, '',$message, $headers)){
echo "Send successfuly";
}
?>