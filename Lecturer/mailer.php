<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/src/Exception.php';
require __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require __DIR__ . '/../PHPMailer/src/SMTP.php';


// Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

// Uncomment for debugging
// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = 'smtp.gmail.com';  
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
$mail->Port = 587;
$mail->Username = 'lessonsmyse@gmail.com'; 
$mail->Password = 'xxgl ldow tmvr ltqa'; 






$mail->isHTML(true);

return $mail;


?>
