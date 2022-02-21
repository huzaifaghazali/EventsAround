<?php 
date_default_timezone_set("Asia/Karachi");
include ("../../connection.php");

if(isset($_POST['senderID']) && isset($_POST['receiverID']) && isset($_POST['message'])){
	$senderID = $_POST['senderID'];
	$receiverID = $_POST['receiverID'];
	$message = mysqli_real_escape_string($con,$_POST['message']);
	$chatTime = date("Y-m-d h:i:s");
	  $sql = "INSERT INTO tbl_chat (senderID, receiverID, message, senderReadNoti, receverReadNoti,createdTime) VALUES ('$senderID', '$receiverID', '$message', '1', '0', '$chatTime')";
	 $result = mysqli_query($con,$sql);
	if($result){
		echo "1";
	}else{
		echo "0";
	}
}
?>