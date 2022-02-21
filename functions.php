<?php 
  function checkUserEmailExist($email,$id=""){
    global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_users` WHERE `user_email` = '$email' and `user_id` != '$id'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }

 }

  function checkSubscribeEmailExist($email){
    global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_subscribe` WHERE `subscribe_email` = '$email' ";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }

 }

 function checkUserReviweExistAgainstGroup($userID,$groupID){
    global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_reviews` WHERE `review_userID` = '$userID' AND `review_groupID` = '$groupID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }

 }
 function getChatNotifications($senderID,$receiverID){
   global $con;
  $sql = "SELECT count(*) as tot FROM `tbl_chat` WHERE `senderID` = '$senderID' AND `receiverID` = '$receiverID' AND `receverReadNoti` = '0'";
    
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
}

function getChatNotificationsForReceiver($receiverID){
   global $con;
  $sql = "SELECT count(*) as tot FROM `tbl_chat` WHERE  `receiverID` = '$receiverID' AND `receverReadNoti` = '0'";
    
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
}

 
function getUserProfileImage($userID){
  global $con;
   $sql = "SELECT `user_image` FROM `tbl_users` WHERE `user_id` = '$userID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['user_image'];
    }
}


  function checkLogin(){
    if(isset($_SESSION['onlineUserID']) && $_SESSION['onlineUserID'] != "" && isset($_SESSION['onlineUserFullName']) && $_SESSION['onlineUserFullName'] != "" && isset($_SESSION['onlineUserType']) && $_SESSION['onlineUserType'] != "" && isset($_SESSION['onlineUserEmail']) && $_SESSION['onlineUserEmail'] != "" ){
        return true;
    }else{
      return false;
    }
  }

    function generateErrorMsg($status){
    if($status == 'P'){
      array_push($_SESSION['errors'],"Your Account is in Pending State, After Admin Approval You can Login in our Portal");
      return false;
        
    }else if($status == 'B'){
        
         array_push($_SESSION['errors'],"Your Account Has Been Blocked By Admin, For more details please contact with admin support");
        return false;
        
    }else if($status == 'R'){
      
         array_push($_SESSION['errors'],"Your Account Has Been Rejected By Admin, For more details please contact with admin support");
        return false;
       
    }else{
      return true;
    }
  }


  function checkGroupExistAgainstOrganizerID($organizerID){
    global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_groups` WHERE `group_organizerID` = '$organizerID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
  }

  function getOrganizerGroupID($organizerID){
    global $con;
    $sql = "SELECT `group_id` FROM `tbl_groups` WHERE `group_organizerID` = '$organizerID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['group_id'];
    }
  }

  function checkBlogPostAreadyLikedByUser($blogID,$userID){
    global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_blogs_like` WHERE `blogID` = '$blogID' AND `userID` = '$userID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
  }
  function getUserName($userID){
  global $con;
   $sql = "SELECT `user_name` FROM `tbl_users` WHERE `user_id` = '$userID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['user_name'];
    }
}


  function getUserImg($userID){
    global $con;
    $sql = "SELECT `user_image` FROM `tbl_users` WHERE  `user_id` = '$userID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['user_image'];
    }
  }
  function checkAlreadyMember($userID,$groupID){
    global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_group_members` WHERE  `userID` = '$userID' AND `groupID` = '$groupID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
  }


function countGroupMembers($groupID){
    global $con;
    $sql = "SELECT count(*) as tot FROM `tbl_group_members` WHERE `groupID` = '$groupID'";
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }
  }

  function getStatusTitle($status){
    if($status == 'P'){
      return "Pending";
    }else if($status == 'A' || $status == '1' ){
      return "Active";
    }else if($status == 'R'){
      return "Rejected";
    }else if($status == 'B' || $status == '0' ){
      return "Blocked";
    }else if($status == 'D' ){
      return "Deactivated";
    }else {
      return "N/A";
    }   
  }


  function getStatusTicketReservationTitle($status){
    if($status == 'P'){
      return "Pending";
    }else if($status == 'A' ){
      return "Confirm";
    }else {
      return "N/A";
    }   
  }

  function getTicketHowToGetTitle($status){
    if($status == 'E'){
      return "Email";
    }else if($status == 'A' ){
      return "On Arival";
    }else {
      return "N/A";
    }   
  }


  function getTicketReservationPaymentTitle($status){
    if($status == 'EP'){
      return "Eazy Paisa";
    }else if($status == 'BT' ){
      return "Bank Transfer";
    }else if($status == 'JC' ){
      return "Jazz Cash";
    }else {
      return "N/A";
    }   
  }


   function getTotCountTicketPurchase($eventID=""){
    global $con;
    $organizerID = $_SESSION['onlineUserID'];
    if($eventID == ""){
      $sql = "SELECT count(*) as tot FROM `tbl_event_tickets` WHERE `event_ticket_groupOnwerID` = '$organizerID' AND `event_ticket_groupOnwerNoti` = '0'";
    }else{
    $sql = "SELECT count(*) as tot FROM `tbl_event_tickets` WHERE `event_ticket_eventID` = '$eventID' AND `event_ticket_groupOnwerID` = '$organizerID' AND `event_ticket_groupOnwerNoti` = '0'";  
    }
    
    $result=mysqli_query($con,$sql);
    if($row=mysqli_fetch_assoc($result)){
      return $row['tot'];
    }

 }

 function generateKey($size)
    {
        $alpha_key = '';
        $keys = range('A', 'Z');

        for ($i = 0; $i < 2; $i++) {
            $alpha_key .= $keys[array_rand($keys)];
        }

        $length = $size - 2;

        $key = '';
        $keys = range(0, 9);

        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        return $alpha_key . $key;
    }
 ?>