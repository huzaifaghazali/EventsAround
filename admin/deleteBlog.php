<?php
 require("includes/connection.php"); 
include("includes/functions.php");
 


if (isset($_GET['id'])) {
 $id = $_GET['id'];
 $sql = "DELETE FROM `tbl_blogs` WHERE `blog_id` = '$id'";
 $result = mysqli_query($con,$sql);
 if($result){
  $_SESSION['blogDeletedSuccessfullyMsg'] = "Blog Deleted Successfully";
  header("location:addBlogs.php");
  exit();
 } 
}


 ?>