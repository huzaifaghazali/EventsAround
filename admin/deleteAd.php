<?php
 require("includes/connection.php"); 
include("includes/functions.php");
 


if (isset($_GET['id'])) {
 $id = $_GET['id'];
 $sql = "DELETE FROM `tbl_ads` WHERE `ad_id` = '$id'";
 $result = mysqli_query($con,$sql);
 if($result){
  $_SESSION['adDeletedSuccessfullyMsg'] = "Ad Deleted Successfully";
  header("location:addAds.php");
  exit();
 } 
}


 ?>