<?php 
include("../../connection.php");
 include("../../functions.php"); 

if (isset($_POST['userID']) && isset($_POST['blogID']) && isset($_POST['blogComment'])) {
    $userID = $_POST['userID'];
    $blogID = $_POST['blogID'];
    $blogComment = $_POST['blogComment'];

    $createdDate = date("Y-m-d");
         $sql = "INSERT INTO `tbl_blogs_comments` (`blogID`,`userID`,`blog_comment`,`createdDate`) VALUES ('$blogID','$userID','$blogComment','$createdDate')";
        $result = mysqli_query($con,$sql);
        if($result){
            echo "1";
        }else{
            echo "0";
        }
    
}else{
    echo "00";
}
?>