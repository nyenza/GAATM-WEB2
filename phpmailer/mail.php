<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
if ( isset( $_POST['action'] ) ){

$name = filter_var( $_POST['username'], FILTER_SANITIZE_STRING );
$from_email = filter_var( $_POST['email'], FILTER_SANITIZE_EMAIL );
$phone = filter_var( $_POST['phone'], FILTER_SANITIZE_STRING );
$subject = filter_var( $_POST['subject'], FILTER_SANITIZE_STRING );
$message = filter_var( $_POST['message'], FILTER_SANITIZE_STRING );

$email_body = "You have Received a message from: " . $name . " <br/>";
	
$email_body .= "Subject: " . $subject . " <br/>";

$email_body .= "Phone: " . $phone . " <br/>";

$email_body .= 	"You can contact " . $name . " via email, " . $from_email ;

$email_body .= $message . " <br/><br/>";

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
   
	$mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'help@thewebmax.org';                     //SMTP username
    $mail->Password   = 'nodu_252525';  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	$mail->SMTPDebug  = 0;

    //Recipients
    $mail->setFrom('help@thewebmax.org', 'thewebmax');
    $mail->addAddress('thewebmaxhelp@gmail.com', 'The Webmax Support');     //Add a recipient
    $mail->addReplyTo('thewebmaxhelp@gmail.com', 'Information');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $email_body;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients for the webmax';

    $mail->send();
	 echo json_encode(array(
            'success' => true,
            'message' => "Message Sent Successfully!"
        ));
} catch (Exception $e) {
	echo json_encode(array(
            'success' => false,
            'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"
        )
    );
}
die;
}