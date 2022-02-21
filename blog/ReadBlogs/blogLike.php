<?php 
include("../../connection.php");
 include("../../functions.php"); 

if (isset($_POST['userID']) && isset($_POST['blogID'])) {
    $userID = $_POST['userID'];
    $blogID = $_POST['blogID'];
    $createdDate = date("Y-m-d");
    if(checkBlogPostAreadyLikedByUser($blogID,$userID) == 0){
        $sql = "INSERT INTO `tbl_blogs_like` (`blogID`,`userID`,`blog_like_date`) VALUES ('$blogID','$userID','$createdDate')";
        $result = mysqli_query($con,$sql);
        if($result){
            echo "1";
        }else{
            echo "0";
        }
    }else{
        $sql = "DELETE FROM `tbl_blogs_like` WHERE `blogID` = '$blogID' AND `userID` = '$userID'";
        $result = mysqli_query($con,$sql);
        if($result){
            echo "2";
        }else{
            echo "0";
        }
    }
}else{
    echo "0";
}
?>