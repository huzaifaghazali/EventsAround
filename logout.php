<?php 
session_start(); //session start

/*delete session varible-start */
unset($_SESSION['onlineUserID']);
unset($_SESSION['onlineUserFullName']);
unset($_SESSION['onlineUserType']);
unset($_SESSION['onlineUserEmail']);
/*delete session varible-end */


/*Redirect to login page */
header("location:Login/login.php");
exit();

?>