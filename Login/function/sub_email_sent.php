<?php
ob_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//PHPMailer Object
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.googlemail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'alislamicfoundation123@gmail.com';
$mail->Password = 'Al_IslamicFoundation'; //Argument true in constructor enables exceptions

//From email address and name
$mail->From = "alislamicfoundation123@gmail.com";
$mail->FromName = "Event Around";
$subject = "Request For Reset Password";
$url = 'http://localhost/events_org_R/Login/resetPassword.php?fpKey='.$key;
// echo $url;
// die;
$final_msg = "<h1>Request For Reset Password </h1>";
$final_msg .= "<p>Asalam u Alikum</p>";
$final_msg .= "<p>Kindly Click the link for Reset Your Password.  </p>";
$final_msg .= "<a href='".$url."'>Click Here For Reset Password</a>";


$mail->addAddress($email, 'User');

$mail->isHTML(true);

$mail->Subject = $subject;
$mail->Body = $final_msg;
$mail->AltBody = "This is the plain text version of the email content";
try {
$mail->send();
}
catch (Exception $e) {
// echo "Mailer Error: " . $mail->ErrorInfo;
}



?>