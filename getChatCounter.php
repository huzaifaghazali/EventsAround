<?php 
include("connection.php");  
include("functions.php"); 

if (checkLogin() == true) {
	if (getChatNotificationsForReceiver($_SESSION['onlineUserID'])>0) {
		echo getChatNotificationsForReceiver($_SESSION['onlineUserID']);
	}
	
}
?>