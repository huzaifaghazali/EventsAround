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



    $sql = "SELECT * FROM `tbl_subscribe` WHERE `subscribe_cateID` = '$eventCateID'";
    $result = mysqli_query($con,$sql);
    if ($result) {
        if (mysqli_num_rows($result) >0) {
            while ($row = mysqli_fetch_array($result)) {
                $sub_email = $row['subscribe_email'];
                $subject = "New Event Added";
    

                $final_msg = "<h1>New Event Added :".$eventTitle." </h1>";
                  $final_msg .= "<p>Asalam u Alikum</p>";
                  $final_msg .= "<p>We are pleased to infrom you that Event Around Organizer Added New Event in which you have intrest.  </p>";
                  $final_msg .= "<b>Event Date : ".$eventDate." And Time :".$eventTime."</b>";


                  $mail->addAddress($sub_email, 'Subscriber');

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
                  
                
            }
        }
    }

?>