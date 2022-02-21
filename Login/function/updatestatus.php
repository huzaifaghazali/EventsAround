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
$mail->FromName = "Al Islamic Foundation";

include ("../includes/connection.php"); //this is our head code 

if (isset($_GET['NgoID']) && isset($_GET['status'])) {
   $NgoID = $_GET['NgoID'];
   $status = $_GET['status'];

     $sql = "SELECT * FROM `tbl_ngos` WHERE `ngos_id` = '$NgoID'";
    $result = mysqli_query($con,$sql);
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            if ($row = mysqli_fetch_array($result)) {
                $ngoName = $row['ngos_name'];
                $ngoLogo = $row['ngos_logo'];
                $ngoContactNo = $row['ngos_contactNo'];
                $ngoEmail = $row['ngos_email'];
                $ngoLocation = $row['ngos_location'];
                $ngoCity = $row['ngos_city'];
                $ngoProvince = $row['ngos_province'];
                $ngoScope = $row['ngos_scope'];
                $ngoYearFounded = $row['ngos_YearFounded'];
                $ngoStatus = $row['ngos_status'];
                
            }
        }
    }

   $sql = "UPDATE `tbl_ngos` SET `ngos_status` = '$status' WHERE `ngos_id` = '$NgoID'";
   $result = mysqli_query($con,$sql);
   if ($result) {
    if ($status == "A") {
      $final_msg = "<h1>Your NGO :".$ngoName.", Account Approval/Rejection</h1>";
      $final_msg .= "<p>Asalam u Alikum</p>";
      $final_msg .= "<p>We are pleased to infrom you that your account has been approved after Verification. Now you can login via using our Mobile App. </p>";
    }
    else if($status == "R"){
      $final_msg = "<h1>Your NGO :".$ngoName.", Account Approval/Rejection</h1>";
      $final_msg .= "<p>Asalam u Alikum</p>";
      $final_msg .= "<p>We are here to infrom you that your account has been rejected after Verification. </p>";
    }
    else if($status == "B"){
      $final_msg = "<h1>Your NGO :".$ngoName.", Account Approval/Rejection</h1>";
      $final_msg .= "<p>Asalam u Alikum</p>";
      $final_msg .= "<p>We are here to infrom you that your account has been Blocked after Verification due to some suspicious activities. </p>";
    }
    $subject = "NGo Account Status Updated";
    $dbEmail  = $ngoEmail;
      
        $mail->addAddress($dbEmail, 'Al Islamic Foundation!');

        $mail->isHTML(true);

        $mail->Subject = $subject;
        $mail->Body = $final_msg;
        $mail->AltBody = "This is the plain text version of the email content";
        try {
            $mail->send();
            $_SESSION['successMessage'] = "NGO Profile Status has been updated successfully";
            header("location:../viewNGODetails.php?NgoID=".$NgoID);
        }
        catch (Exception $e) {
            // echo "Mailer Error: " . $mail->ErrorInfo;
        }
      
   }
}
?>