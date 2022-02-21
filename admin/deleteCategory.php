<?php
 require("includes/connection.php"); 
include("includes/functions.php");
 


if (isset($_GET['id'])) {
 $id = $_GET['id'];
 $sql = "DELETE FROM `tbl_categories` WHERE `id` = '$id'";
 $result = mysqli_query($con,$sql);
 if($result){
  $_SESSION['cateDeletedSuccessfullyMsg'] = "Category Deleted Successfully";
  header("location:addCategories.php");
  exit();
 } 
}


 ?>