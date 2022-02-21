<?php 
session_start(); //session start

/*delete session varible-start */
unset($_SESSION['userID']);
unset($_SESSION['userFullName']);
unset($_SESSION['userType']);
unset($_SESSION['userEmail']);
/*delete session varible-end */


/*Redirect to login page */
header("location:login.php");
exit();

?>