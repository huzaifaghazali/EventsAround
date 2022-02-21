<?php 
include("../../connection.php");  
include("../../functions.php"); 

$senderID = $receiverID = "";
if(isset($_SESSION['onlineUserID'])) {
    $senderID = $_SESSION['onlineUserID'];
}
if (isset($_GET['groupOrganizerID'])) { 
    $receiverID = $_GET['groupOrganizerID'];
}

$sql = "SELECT * FROM `tbl_chat`  WHERE 
  (`senderID` ='$senderID' and `receiverID` = '$receiverID')
  OR
  (`receiverID` = '$senderID' and `senderID` = '$receiverID')";
  $result=mysqli_query($con,$sql);
  $n=1;
  while($row=mysqli_fetch_assoc($result))
  { 

      if($row['senderID'] == $senderID){
          $class = "usermessage";
          $userName = $_SESSION['onlineUserFullName'];
          $userImage = "../../".getUserProfileImage($senderID);
          if($userImage == "../../" OR !file_exists($userImage)){
            $userImage = "../../uploads/users.png";
          }
          
      }

      if($row['receiverID'] == $senderID){
          $class = "organizerMessage";
          $userImage = "../../".getUserProfileImage($receiverID);
          if($userImage == "../../" OR !file_exists($userImage)){
            $userImage = "../../uploads/users.png";
          }
          $userName = getUserName($receiverID);
          echo "<div class='clearfix'></div>";
      }
?>
   <div  class= "<?php echo $class; ?>">
    <p style="margin: 10px 0 10px 0;"> <img style="width: 35px; height: 35px; margin-right: 10px; padding: 5px" class="img-circle" src="<?php echo $userImage; ?>" /><?php echo $userName; ?> </p>
     <p style="padding-left: 10px;"><?php echo $row['message']; ?></p>

    <?php 
      $chatDateTime=strtotime($row['createdTime']);
      $cDate =  date("d-m-Y", $chatDateTime); 
      $cTime =  date("h:i A", $chatDateTime);
  ?>
    <span class="time-right"><?php echo  $cDate ." - ". $cTime;  ?></span>
    <br><br>
  </div>

  <div class="clearfix"></div>
   <?php
}

?>
 
